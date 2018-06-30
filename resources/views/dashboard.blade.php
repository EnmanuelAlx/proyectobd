@extends('layouts.menu')

@section('contenido-externo')

<div class="card">
    <div class="card-body">
        <strong>Nombre: {{ auth()->user()->nombre }}</strong>
    </div>
</div>

@endsection