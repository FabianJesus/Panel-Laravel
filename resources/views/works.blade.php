@extends('layouts.app')

@section('content')
<div class="card">
   
    <div class="card-header justify-content-center">
        @include('includes.nav2')
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }};
        </div>
    @endif
    <div class="card-body row">
    <div class="col-md-6">
        <div class="text-md-center col-md-12">
            <h3>Trabajos</h3>
            <form method="post" class="mt-4 mb-2" action="{{ url('/trabajos/filtroNombre') }}">
                @csrf
                <div class="form-group row">
                    <label for="nameClient" class="col-md-4 col-form-label text-md-right">Nombre</label>
                    <div class="col-md-6">
                        <input id="nameClient" type="nameClient" class="form-control @error('nameClient') is-invalid @enderror" name="nameClient" value="{{$nameclient}}" required autocomplete="nameClient">

                        @error('nameClient')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    Filtrar
                </button>
                <a href="{{route('works')}}">Quitar Filtros</a>
            </form>
        </div>
        <div class="card col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Direccion</th>
                        <th>Presupuesto €</th>
                        <th>Coste €</th>
                        @if ($statusDate == 'DESC')
                            <th>Fecha del registro <a href="{{url('/trabajos/filtroFecha/ASC')}}">v</a></th> 
                        @else
                            <th>Fecha del registro <a href="{{url('/trabajos/filtroFecha/DESC')}}">&#94;</a></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($worksData as $work)
                        <tr>
                        <td>
                        <a href="{{url('clientes/'.$work->client_id)}}">{{$work->client['name']}}</a>
                        </td>
                        <td><a href="{{url('mapa?lat='.$work->lat.'&lon='.$work->lon.'')}}" target="_blank">Dirección</a></td>
                        <td>{{$work->budget}}</td>
                        <td>{{$work->cost}}</td>
                        <td>{{$work->created_at->format('d/m/Y')}}</td>
                        <td><a href="{{url('mail/'.$work->client_id)}}">Contacto</a></td>
                        <td><a href="{{url('trabajos/borrar/'.$work->id)}}" class="a_delete">X</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if ($worksData  instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{$worksData->links()}}
                @endif
            </div>
        </div>
    </div>
        <div class="col-md-6">
            <form method="POST" class="mt-4" action="{{ route('newJob') }}">
                @csrf
                <div class="form-group text-md-center ">
                    <h3>Registrar Nuevo trabajo</h3>
                
                </div>
                <div class="form-group row">
                    <label for="client" class="col-md-4 col-form-label text-md-right">{{ __('Email del cliente') }}</label>

                    <div class="col-md-6">
                        <input id="client" type="text" class="form-control @error('client') is-invalid @enderror" name="client" value="{{ session('email') }}" required autocomplete="client">
                        <a href="" class="ml-3" data-toggle="modal" data-target="#exampleModal">
                            Nuevo Cliente
                        </a>
                        @error('client')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="direction" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>

                    <div class="col-md-6">
                        <div><input type="text" id="adress"><input type="button" value="Buscar" onclick="map.searchAdress()"></div>
                        <div id="resultado"></div>
                        <div id="myMap" style="height: 200px"></div>
                        <input type="text" id="lat" name="lat" hidden>
                        <input type="text" id="lon" name="lon" hidden>
                        @error('direction')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="budget" class="col-md-4 col-form-label text-md-right">{{ __('Presupuesto') }}</label>

                    <div class="col-md-6">
                        <input id="budget" type="text" class="form-control @error('budget') is-invalid @enderror" name="budget" value="{{ old('budget') }}" required  autofocus>

                        @error('budget')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cost" class="col-md-4 col-form-label text-md-right">{{ __('Coste Total') }}</label>

                    <div class="col-md-6">
                        <input id="cost" type="text" class="form-control @error('cost') is-invalid @enderror" name="cost" value="{{ old('cost') }}" required autofocus>

                        @error('cost')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Registrar Trabajo') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel">Registrar nuevo cliente</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('newClient') }}">
                        @csrf
                        <div class="form-group text-md-center">
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
        
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  required autocomplete="name" autofocus>
        
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
        
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>
        
                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" pattern="[0-9]{9}" required>
        
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar Cliente') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
@endsection
