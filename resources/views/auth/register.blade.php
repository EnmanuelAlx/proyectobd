@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5 text-center" style="margin: 0 auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-tittle">Registrarse</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="id">Cedula</label>
                            <input class="form-control" type="text" value="{{ old('id') }}" required name="id" placeholder="Ingresa tu cedula">
                            {!! $errors->first('user', '<span class="help-block">:message</span>') !!}
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" type="text" required name="nombre" placeholder="Ingresa tu nombre">
                        </div>

                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <input class="form-control" type="text" name="direccion" required placeholder="Ingresa tu direccion">
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input class="form-control" type="password" name="password" required placeholder="Ingresa tu contraseña">
                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        </div>

                        <div class="row">
                            <div class="form-group col">
                                <input type="radio" class="form-control" name="optionsRadios" id="profesor" value="1" checked>
                                <label for="">Profesor</label>
                            </div>

                            <div class="form-group col">
                                <input type="radio" class="form-control" name="optionsRadios" id="egresado" value="2">
                                <label for="">Egresado</label>
                            </div>
                        </div>

                        <div class="form-group" id="inputs_egresados">

                        </div>

                        <button class="btn btn-primary btn-block">Registrarse</button>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ route('/') }}">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var egresados = '' +
                    '<label for="fecha_egreso">Fecha de egreso</label>'+
                    '<input type="date" class="form-control" required name="fecha_egreso" id="fecha_egreso">'+
                    '<label for="estado">Estado</label>'+
                    '<input type="text" class="form-control" name="estado" id="estado">'+
                    '<label for="pais">Pais</label>'+
                    '<input type="text" class="form-control" name="pais" id="pais">'+
                    '<label for="foto">Foto</label>'+
                    '<input type="file" class="" name="foto" id="foto">';

            $('#egresado').click(function(){
                $('#inputs_egresados').append(egresados);
            });
            $('#profesor').click(function() {
                $('#inputs_egresados').empty();
            });



        });
    </script>
@endsection


