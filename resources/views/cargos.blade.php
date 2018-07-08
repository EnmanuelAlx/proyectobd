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
            <div class="form-group">
                <label for="tipo">Buscar Por</label>
                <select name="tipo" id="tipo" class="form-control">
                    <option value="1">Profesores</option>
                    <option value="2">Egresados</option>
                </select>
            </div>
        @endslot
    @endcomponent
    <br>
    
    {{--Componente del panel para agregar nuevo registro--}}
    @component('componentes.paneladdnew')
        @slot('mod', $mod)
        @slot('inputs')
            <div class="form-group">
                <label for="input_1">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="form-group">
                <select name="tipo" id="tipo" class="form-control">
                    <option value="1">Profesores</option>
                    <option value="2">Egresados</option>
                </select>
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
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="form-group">
                <select name="tipo" id="tipo" class="form-control">
                    <option value="0">Profesores</option>
                    <option value="1">Egresados</option>
                    <option value="3">Todos</option>
                </select>
            </div>
        @endslot
    @endcomponent
@stop

