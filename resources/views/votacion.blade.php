@extends('layouts.menu')

@section('contenido-externo')

<form metho="get" id="FormPeriodo" action="{{ route('votaciones.getP') }}">
<div class="form-group">
    <label for="periodo">Seleccione un Periodo</label>
    <select class="form-control" id="periodo">
      @foreach($votacion as $fecha){
        <option class='periodo' value='{{ $fecha->id }}'>{{$fecha->fecha_inicio}}/{{$fecha->fecha_limite_votacion}}</option>
      }
      @endforeach
    </select>  
  </div>
  {{csrf_field()}}
</form>

<div id="postulados">

</div>

<script>
    $(document).ready(function(){

    $('#periodo').change(function(e) {
        console.log($(this).val());
        $frm = $('#FormPeriodo');
        e.preventDefault();
        $url = $frm.attr('action');
        console.log($url);
        $.ajax({
            type:'GET',
            url:$url,
            dataType: 'json',
            data:$frm.serialize(),
            })
            .done(function(data){
                 $('div.content-search').html(data);
                 $('div.content-search').slideDown();
                bindItems();
            });
    });
    });
</script>

@endsection
