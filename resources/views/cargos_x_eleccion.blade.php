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

    @if(\App\User::PuedeAgregar())
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

            <span>Cargos</span>
            <div class="card" style="color: #2F3133">
                <div class="card-body">
                    @foreach($cargos as $cargo)
                        <input type="checkbox" class="" name="cargos[]" value="{{ $cargo->id }}"> <span>{{ $cargo->nombre }}</span>
                        <hr>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="cargo">Escuela</label>
                <select name="escuela" id="escuela" class="form-control">
                    @foreach($escuelas as $escuela)
                        <option value="{{ $escuela->id }}">Escuela: {{ $escuela->nombre_escuela}}-Facultad: {{ $escuela->nombre_facultad }} Extension: {{ $escuela->nombre_extension }}</option>
                    @endforeach
                </select>
            </div>

        @endslot
    @endcomponent
@endif

    {{--Componente para el view del panel--}}
    @component('componentes.panelview')
        @slot('mod', $mod);
    @endcomponent

    @if(\App\User::PuedeEditar())
        {{--Componente para el edit de un registro--}}
        @component('componentes.paneledit')
            @slot('mod', $mod)
            @slot('inputs')
                <span>Cargos</span>
                <div class="card" style="color: #2F3133">
                    <div class="card-body">
                        @foreach($cargos as $cargo)
                            <input type="checkbox" class="" name="cargos[]" value="{{ $cargo->id }}"> <span>{{ $cargo->nombre }}</span>
                            <hr>
                        @endforeach
                    </div>
                </div>
            @endslot
        @endcomponent
    @endif
@stop

