@extends('layouts.menu')

@section('contenido-externo')
<link href="{!! asset('css/votaciones.css') !!}" media="all" rel="stylesheet" type="text/css" />


<form metho="get" id="FormPeriodo" action="{{ route('votaciones.getP') }}">
<div class="form-group">
    <label for="periodo">Seleccione un Periodo</label>
    <select class="form-control" id="periodo">
        <option value="0" class="periodo" selected ></option>
        @foreach($elecciones as $eleccion)
            <option class='periodo' value='{{ $eleccion->id }}'>{{$eleccion->fecha_inicio}}/{{$eleccion->fecha_limite_votacion}}</option>
        @endforeach
    </select>  
  </div>
  {{csrf_field()}}
</form>


<div id="postulados" class="row my-row">

</div>

<script>
    $(document).ready(function(){

        $('#periodo').change(function(e) {
            e.preventDefault();
            $frm = $('#FormPeriodo');
            $url = $frm.attr('action');
//        console.log($('#periodo').val());
            $.ajax({
                type:'GET',
                url:$url,
                dataType: 'json',
                data: {frm: $frm.serialize(), periodo: $('#periodo').val()},
            }).done(function(data){
                    $('div#postulados').html(data);
                    bindItems($('#periodo').val());
                });
        });

        function bindItems($periodo){
            $('div.postulado').click(function(){
                console.log($(this).find('.id_postulado').val());
                if(confirm('¿Seguro que desea votar por este men?')){
                    $.ajax({
                        type:'GET',
                        url:"{{route('votaciones.getVoto')}}",
                        dataType: 'json',
                        data: {id_postulado:$(this).find('.id_postulado').val(), periodo: $periodo, id_cargo:$(this).find('.id_cargo').val()},
                    }).done(function(data){
                        $('div#postulados').html('<h2>Felicidades, ya ejerciste tu voto</h2>')
                    });
                }

            });
        }


    });
</script>
@endsection
