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
                <label for="escuelas">Nombre de la escuela</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre de la escuela" id="nombre">
            </div>

            <div class="form-group">
                <label for="facultades">Facultad</label>
                <select name="facultades" id="facultades" class="form-control">
                    @foreach($facultades as $facultad)
                        <option value="{{ $facultad->id }}">{{ $facultad->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="extensiones">Extension</label>
                <select name="extensiones" id="extensiones" class="form-control">
                    @foreach($extensiones as $extension)
                        <option value="{{ $extension->id }}">{{ $extension->nombre}}</option>
                    @endforeach
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
                <label for="escuelas">Nombre de la escuela</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre de la escuela" id="nombre">
            </div>

            <div class="form-group">
                <label for="facultades">Facultad</label>
                <select name="facultades" id="facultades" class="form-control">
                    @foreach($facultades as $facultad)
                        <option value="{{ $facultad->id }}">{{ $facultad->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="extensiones">Extension</label>
                <select name="extensiones" id="extensiones" class="form-control">
                    @foreach($extensiones as $extension)
                        <option value="{{ $extension->id }}">{{ $extension->nombre}}</option>
                    @endforeach
                </select>
            </div>
        @endslot
    @endcomponent
@stop