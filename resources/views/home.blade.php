@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            @if(isset($turn))
            <div class="card">
                <div class="card-header"><h1><small>Turno:</small> <span class="en-text-primary">{{$turn->id}}</span></h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-row" name="form-turn" id="form-turn">
                        @csrf
                        @method('put')
                        <input type="hidden" name="status" value="2">
                        <div class="col-6 mb-2">
                            <input class="form-control" type="text" name="name" placeholder="Nombre Completo" maxlength="255">
                        </div>
                        <div class="col-6 mb-2">
                            <input class="form-control" type="text" name="document" placeholder="Documento de Identificación" maxlength="150">
                        </div>
                        <div class="col-12 mb-2">
                            <select class="form-control" name="consutl_type">
                                <option value="">-- Seleccione tipo de consulta --</option>
                                <option value="Registro Hoja de Vida">Registro Hoja de Vida</option>
                                <option value="Asesoria general">Asesoria general</option>
                            </select>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-lg btn-dark m-auto text-center" style="width: 150px; height: 150px;">
                                <small>Siguiente turno</small>
                                <div class="p-3 en-primary m-auto" style="width: 60px; height: 60px;border-radius: 100%;"><i class="fas fa-arrow-right fa-lg"></i></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="text-center">
                <h1>Sin turnos</h1>
                <button id="check-btn" class="btn btn-lg en-primary m-auto">Validar si hay turnos</button>
            </div>
            @endif
        </div>
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped text-center" align="center">
                        <tr>
                            <th>Asesor</th>
                            <th>Turno</th>
                        </tr>
                        @foreach($turns as $item)
                        <tr>
                            <td>{{(!empty($item->user))?$item->user->name:''}}</td>
                            <td><h3 class="en-text-primary m-0">{{$item->id}}</h3></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts-ready')
    $('#check-btn').on('click',function(){window.location.reload()});
@if(!empty($turn))
    $('[name="form-turn"').on('submit', function(e){
        e.preventDefault();
        var venue = $('[name="venue_id"]').val();
        Swal.fire({
          title: 'Finalizar turno?',
          showCancelButton: true,
          confirmButtonText: 'Enviar',
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            $.ajax({
              method: "POST",
              url: '{{route('turn.update', $turn->id)}}',
              data: new FormData(document.getElementById("form-turn")),
              processData: false,
              contentType: false,
            })
            .done(function( response ) {
                if (!response.success) {
                  Swal.fire(`La solicitud fallo:`+response.error)
                }else{
                    window.location.reload()
                }
            }).fail(function( response ) {
                Swal.fire(`La solicitud fallo.`)
            });
          },
          allowOutsideClick: () => !Swal.isLoading()
        });
    });
@endif
@endsection