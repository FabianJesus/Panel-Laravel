@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cliente</div>

                <div class="card-body">
                    <div>
                        <label>Nombre:  {{$client[0]->name}}</label>
                    </div>
                    <div>
                        <label>Email:  {{$client[0]->email}}</label>
                    </div>
                    <div>
                        <label>Telefono:  {{$client[0]->phone}}</label>
                    <div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
