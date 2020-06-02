@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header"><h1>Turno Actual</h1></div>

                <div class="card-body p-4 text-center">
                    <p class="en-text-primary" style="font-size: 120px">{{(!empty($turns))?$turns->first()->id:''}}</p>
                </div>
            </div>
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
    setInterval(function(){ window.location.reload(); }, 3000);
@endsection