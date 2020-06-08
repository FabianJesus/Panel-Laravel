
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Email</div>

    <div class="card-body">
        <form method="POST" action="{{ route('send') }}">
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
                <label for="affair" class="col-md-4 col-form-label text-md-right">{{ __('Asunto') }}</label>

                <div class="col-md-6">
                    <input id="affair" type="affair" class="form-control @error('affair') is-invalid @enderror" name="affair" value="{{ old('affair') }}" required autocomplete="affair">

                    @error('affair')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="Message" class="col-md-4 col-form-label text-md-right">{{ __('Mesanje') }}</label>

                <div class="col-md-6">
                    <textarea id="Message" type="Message" class="form-control @error('Message') is-invalid @enderror" name="Message" pattern="[0-9]{9}" required></textarea>

                    @error('Message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
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
@endsection