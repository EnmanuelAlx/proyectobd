@extends('layouts.menu')

@section('contenido-externo')
<link href="{!! asset('css/votaciones.css') !!}" media="all" rel="stylesheet" type="text/css" />

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

$count = 0;
<div class="container">
  <div class="row my-row">
    @foreach($postulados as $postulado){
      <div class="col -sm-3">
        <div class="card">
          <img src="img_avatar.png" alt="Avatar" style="width:100%">
          <div class="containe">
            <h4><b>{{postulado->nombreU}}</b></h4> 
            <p>{{postulado->nombreC}}</p> 
          </div>
        @if($count = 4){
          <div class="w-100 d-none d-md-block"></div>
          $count = 0;
          }    
      </div> 
      $++count;   
    @endforeach
</div>
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
