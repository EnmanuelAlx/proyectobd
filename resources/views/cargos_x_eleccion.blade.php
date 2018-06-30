{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: Enmanuel--}}
 {{--* Date: 26/06/2018--}}
 {{--* Time: 11:17--}}
{{--*/--}}
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

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <select multiple name="cargo" id="cargo" class="form-control">
                    @foreach($cargos as $cargo)
                        <option value="{{ $cargo->id }}">{{ $cargo->nombre}}</option>
                    @endforeach
                </select>
            </div>
            {{--@foreach($cargos as $cargo)--}}
                {{--<div class="form-group">--}}
                    {{--<input type="checkbox" value="{{ $cargo->id }}" name="cargo">--}}
                    {{--<label for="cargo">{{ $cargo->nombre }}</label>--}}
                {{--</div>--}}
            {{--@endforeach--}}

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
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
        @endslot
    @endcomponent
@stop

