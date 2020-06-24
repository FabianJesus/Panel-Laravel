@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header justify-content-center">
        <nav class="nav d-flex container">
          <a class="p-2 text-muted" href="{{route('works')}}">Trabajos</a>
          <a class="p-2 text-muted" href="{{route('client')}}">Clientes</a> 
        </nav>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }};
        </div>
    @endif
    <div class="card col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Fecha del registro</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($clientsData as $client)
                    <tr>
                    <td>
                    <a href="{{url('clientes/'.$client->id)}}">Editar</a>
                    </td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->phone}}</td>
                    <td>{{$client->created_at->format('d/m/Y')}}</td>
                    <td><a href="{{url('mail/'.$client->id)}}">Contacto</a></td>
                    
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$clientsData->links()}}
        </div>
    </div>
</div>
@endsection
