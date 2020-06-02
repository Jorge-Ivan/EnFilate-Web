@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-deck justify-content-center">

        <div class="card p-4">
            <h3 class="text-center mb-4">Solicitar turno <br> <span class="en-text-primary">Externo</span></h3>
            <form method="GET" name="turn-in">
                @csrf
                <div class="text-center">
                    <select class="form-control m-auto mb-1" name="venue_id" style="width: 200px;">
                        <option value="">-- Seleccione la sede --</option>
                        @foreach(\App\Venue::cursor() as $ven)
                        <option value="{{$ven->id}}">{{$ven->name}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-lg btn-dark m-auto text-center" style="width: 200px; height: 200px;">
                        <div class="p-4 en-primary" style="width: 160px; height: 160px;border-radius: 100%;"><img src="{{asset('assets/tap.png')}}" height="100%"></div>
                    </button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header text-center en-text-primary">{{ __('Login') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" class="text-center">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn en-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link en-text-primary" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts-ready')
$('[name="turn-in"').on('submit', function(e){
    e.preventDefault();
    var venue = $('[name="venue_id"]').val();
    Swal.fire({
      title: 'Solicitar turno en'+$('option[value="'+venue+'"]').html(),
      showCancelButton: true,
      confirmButtonText: 'Solicitar',
      showLoaderOnConfirm: true,
      preConfirm: (login) => {
        $.ajax({
          method: "POST",
          url: '{{route('turn.create')}}',
          data: {venue_id:venue}
        })
        .done(function( response ) {
            if (!response.success) {
              Swal.fire(`La solicitud fallo.`)
            }
            Swal.fire({
              title: 'Su turno es el:'+response.turn.id,
              imageUrl: 'https://dummyimage.com/150x150/ef8f4f/fff&text='+response.turn.id
            })
        }).fail(function( response ) {
            Swal.fire(`La solicitud fallo.`)
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    });
});
@endsection
