@extends('layouts.menu')

@section('usuario')
@endsection
@section('contenido-externo')

<form metho="get" id="FormPeriodo" action="{{ route('post_egre_1mas_cargos.get') }}">
<div class="form-group">
    <select class="form-control" id="periodo">
        <option value="0" class="periodo" selected ></option>
        @foreach($elecciones as $eleccion)
            <option class='periodo' value='{{ $eleccion->id }}'>{{$eleccion->id}}</option>
        @endforeach
    </select>  
  </div>
  {{csrf_field()}}
</form>
<div id='tabla'>
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
                    $('div#tabla').html(data);
                });
        });
    });
</script>

@endsection