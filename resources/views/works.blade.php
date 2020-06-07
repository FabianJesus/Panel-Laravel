@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Trabajos</div>

    <div class="card-body row">
    <div class="col-md-6">
        <div class="text-md-center col-md-12">
            <h3>Trabajos</h3>
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
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($works as $work)
                            <tr>
                            <td>{{$work->client['name']}}</td>
                            <td>{{$work->direction}}</td>
                            <td>{{$work->budget}}</td>
                            <td>{{$work->cost}}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{$works->links()}}
                </div>
            </div>
    </div>
        <div class="col-md-6">
            <form method="POST" action="{{ route('newClient') }}">
                @csrf
                <div class="form-group text-md-center">
                    <h3>Registrar nuevo cliente</h3>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                        <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" required>

                        @error('password')
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

            <form method="POST" class="mt-4" action="{{ route('newJob') }}">
                @csrf
                <div class="form-group text-md-center ">
                    <h3>Registrar Nuevo trabajo</h3>
                    @if (session('status2'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status2') }}
                    </div>
                @endif
                </div>
                <div class="form-group row">
                    <label for="client" class="col-md-4 col-form-label text-md-right">{{ __('Email del cliente') }}</label>

                    <div class="col-md-6">
                        <input id="client" type="text" class="form-control @error('client') is-invalid @enderror" name="client" value="{{ old('client') }}" required autofocus>

                        @error('client')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="direction" class="col-md-4 col-form-label text-md-right">{{ __('Direccion') }}</label>

                    <div class="col-md-6">
                        <input id="direction" type="text" class="form-control @error('direction') is-invalid @enderror" name="direction" value="{{ old('direction') }}" required autocomplete="direction" autofocus>

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
    </div>
</div>
@endsection
