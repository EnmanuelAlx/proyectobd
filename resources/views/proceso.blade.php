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
                <label for="id">Nombre de la eleccion</label>
                <input type="text" class="form-control" name="id">
            </div>

            <div class="form-group">
                <label for="f_inicio">Fecha de inicio</label>
                <input type="date" class="form-control" name="f_inicio">
            </div>

            <div class="form-group">
                <label for="f_fin">Fecha finalizacion</label>
                <input type="date" class="form-control" name="f_fin">
            </div>

            <div class="form-group">
                <label for="fecha_limite_postulacion">Fecha limite de las Postulaciones</label>
                <input type="date" class="form-control" name="fecha_limite_postulacion">
            </div>

            <div class="form-group">
                <label for="fecha_limite_votacion">Fecha limite de las votaciones</label>
                <input type="date" class="form-control" name="fecha_limite_votacion">
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
            <div class="form-group">
                <label for="f_inicio">Fecha de inicio</label>
                <input type="date" class="form-control" name="f_inicio">
            </div>

            <div class="form-group">
                <label for="f_fin">Fecha finalizacion</label>
                <input type="date" class="form-control" name="f_fin">
            </div>

            <div class="form-group">
                <label for="fecha_limite_postulacion">Fecha limite de las Postulaciones</label>
                <input type="date" class="form-control" name="fecha_limite_postulacion">
            </div>

            <div class="form-group">
                <label for="fecha_limite_votacion">Fecha limite de las votaciones</label>
                <input type="date" class="form-control" name="fecha_limite_votacion">
            </div>
        @endslot
    @endcomponent
@stop

