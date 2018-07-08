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
                    <option value="0" selected></option>
                    @foreach($elecciones as $eleccion)
                        <option value="{{ $eleccion->id }}">{{ $eleccion->id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group card">
                <div class="card-body" id="cargos" style="color: #2a2a2a">

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

        @endslot
    @endcomponent

    <script>
        $(document).ready(function(){
            $('#eleccion').change(function() {
                var id_eleccion = $(this).val();
                $frm = $('#frm_add_new');
                $.ajax({
                    type:'POST',
                    url: "{{url('admin/'.$mod.'/getCargos')}}",
                    dataType:'json',
                    data:$frm.serialize(),
                }).done(function(data) {
                    if(data=='err'){
                        alert('No hay cargos para esta eleccion en tu escuela')
                    }
                    else{
                        $('div#cargos').html(data);
                    }
                });
            });
        });
    </script>
@stop



