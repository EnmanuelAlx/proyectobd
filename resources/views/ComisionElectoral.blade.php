@extends('layouts.menu')

@section('usuario')
@stop
@section('contenido-externo')
    {{--Componente para agregar nuevo--}}
    @component('componentes.addnew')
        @slot('header', $header)
        @slot('count', $cantidad)
    @endcomponent
    <br>

    {{--Componente de la barra de busqueda--}}
    @component('componentes.search')
        @slot('mod', $mod)
        @slot('inputs')
            {{--Inputs que ayudan a definir la busqueda de algo--}}

        @endslot
    @endcomponent
    <br>

    {{--Componente del panel para agregar nuevo registro--}}
    @component('componentes.paneladdnew')
        @slot('mod', $mod)
        @slot('inputs')
            <div class="form-group">
                <label for="eleccion">Eleccion</label>
                <select name="eleccion" id="eleccion" class="form-control">
                    @foreach($elecciones as $eleccion)
                        <option value="{{ $eleccion->id }}">{{ $eleccion->id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col col-sm-6">
                    <div class="card" style="color: #000000">
                        <div class="card-header">
                            Profesores
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Nombre</th>
                                    <th></th>
                                </tr>
                                @foreach($profesores as $profesor)
                                    <tr>
                                        <td>{{ $profesor->profesor_nombre }}</td>
                                        <td><input type="checkbox" name="profesores[]" value="{{ $profesor->profesor_id }}"></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col col-sm-6">
                    <div class="card" style="color: #000000">
                        <div class="card-header">
                            Egresados
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Nombre</th>
                                    <th></th>
                                </tr>
                                @foreach($egresados as $egresado)
                                    <tr>
                                        <td>{{ $egresado->egresado_nombre }}</td>
                                        <td><input type="checkbox" name="egresados[]" value="{{ $egresado->egresado_id }}"></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @endslot
    @endcomponent


    {{--Componente para el view del panel--}}
    @component('componentes.panelview')
        @slot('mod', $mod);
    @endcomponent

    {{--Componente para el edit de un registro--}}
    @component('componentes.paneledit')
        @slot('mod', $mod)
        @slot('inputs')
            <div class="row">
                <div class="col col-sm-6">
                    <div class="card" style="color: #000000">
                        <div class="card-header">
                            Profesores
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Nombre</th>
                                    <th></th>
                                </tr>
                                @foreach($profesores as $profesor)
                                    <tr>
                                        <td>{{ $profesor->profesor_nombre }}</td>
                                        <td><input type="checkbox" name="profesores[]" value="{{ $profesor->profesor_id }}"></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col col-sm-6">
                    <div class="card" style="color: #000000">
                        <div class="card-header">
                            Egresados
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Nombre</th>
                                    <th></th>
                                </tr>
                                @foreach($egresados as $egresado)
                                    <tr>
                                        <td>{{ $egresado->egresado_nombre }}</td>
                                        <td><input type="checkbox" name="egresados[]" value="{{ $egresado->egresado_id }}"></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endslot
    @endcomponent
@stop

