@extends('layouts.app')

@section('content')
    <div class="container">
    <h2>Exportar Datos a Excel</h2>

    <div class="form-group mb-2">
        <label for="date" class="sr-only">Date</label>
        <input type="text" readonly class="form-control-plaintext" id="date" value="Seleccione Fecha de Registros a procesar">
    </div>
        
    
        <form class="form-inline" method="POST" action="{{route('comprobante.excel')}}">
            @csrf
            <p>FECHA INICIO</p>
            <div id="date-picker-example" class="form-group mx-sm-3 mb-2 md-form md-outline input-with-post-icon datepicker">
            <input type="date" class="form-control" id="dateini" placeholder="Fecha Inicio" name="dateini">
            <i class="fas fa-calendar input-prefix" tabindex=0></i>
            </div>
            <p>FECHA FIN</p>
            <div id="date-picker-example" class="form-group mx-sm-3 mb-2 md-form md-outline input-with-post-icon datepicker">
                <input type="date" class="form-control" id="datefin" placeholder="Fecha Inicio" name="datefin">
                <i class="fas fa-calendar input-prefix" tabindex=1></i>
            </div>

            <button type="submit" class="btn btn-primary mb-2">Export</button>
        </form>
        

        <p>

            Clic <a href="{{route('comprobante.excel')}}">
                Aquí
            </a>
            para descargar Excel
        </p>
    </div>

@endsection
