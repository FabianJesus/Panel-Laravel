
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Contactar</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('send') }}">
            @csrf
            <div class="form-group text-md-center">
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                <div class="col-md-6">
                    <label class="col-md-4 col-form-label">{{$mailData[0]->email}}</label>
                    <input id="email" type="hidden" name="email" value="{{$mailData[0]->email}}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $email }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $name }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="affair" class="col-md-4 col-form-label text-md-right">{{ __('Asunto') }}</label>

                <div class="col-md-6">
                    <input id="affair" type="affair" class="form-control @error('affair') is-invalid @enderror" name="affair" value="{{ old('affair') }}" required autocomplete="affair">

                    @error('affair')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $affair }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="msg" class="col-md-4 col-form-label text-md-right">{{ __('Mensaje') }}</label>

                <div class="col-md-6">
                    <textarea id="msg" type="msg" class="form-control @error('msg') is-invalid @enderror" name="msg" pattern="[0-9]{9}" required></textarea>

                    @error('msg')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $msg }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Enviar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">Historial de mensajes enviados</div>

    <div class="card-body justify-content:center ">
        @foreach ($msgs as $msgd)
            <div class="form-group card col-md-4 ">
                <larabel class="col-form-label">Nombre: {{$msgd->name}}</larabel>
                <larabel class="col-form-label">Asuntos: {{$msgd->affair}}</larabel>
                <larabel class="col-form-label">Mensaje: {{$msgd->message}}</larabel>
                <larabel class="col-form-label">Fecha de envio: {{$msgd->created_at}}</larabel>
            </div>               
        @endforeach
    </div>
</div>
@endsection