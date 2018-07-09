@extends('layouts.menu')

@section('usuario')
@endsection
@section('contenido-externo')

<form metho="get" id="FormPeriodo" action="{{ route('total_post_prof.get') }}">
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
<form id="frm_print" method="get" action="{{ route('frm_get3') }}" target="_blank" class="hidden">
    <input type="hidden" id="id_eleccion" name="id_eleccion">
</form>
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
                bindItems($('#periodo').val());
            });
        });

        function bindItems($eleccion){
            $('#pdf').click(function(){
                $token = $('input[name="_token"]').val();
                $frm2 = $('#frm_print');
                $url = $frm2.attr('action');
                $('#id_eleccion').val($eleccion);
                console.log($('#id_eleccion').val());
                $frm2.submit();
            });
        }
    });
</script>

@endsection