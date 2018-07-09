@extends('layouts.menu')

@section('contenido-externo')

<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label for="eleccion">Eleccion</label>
            <select name="eleccion" id="eleccion" class="form-control">
                <option value="0" selected> </option>
                @foreach($elecciones as $eleccion)
                    <option value="{{ $eleccion->id }}">{{ $eleccion->id }}</option>
                @endforeach
            </select>
        </div>


    </div>
</div>

    <div class="row">
        <div id="profesores" class="col-sm-6">

        </div>

        <div id="egresados" class="col-sm-6">

        </div>
    </div>
    {!! $grafico_profesores !!}
    {!! $grafico_egresados !!}

<script>
    $(document).ready(function(){
        $('#eleccion').change(function(){
            var eleccion = $(this).val();
            $.ajax({
                type:'GET',
                url: "{{ route('GetGraficas') }}",
                dataType: 'json',
                data: {id_eleccion: eleccion}
            }).done(function(data){
                $('div#profesores').html(data['grafica_profesores']);
                $('div#egresados').html(data['grafica_egresados']);
            })
        });
    });
</script>
@endsection