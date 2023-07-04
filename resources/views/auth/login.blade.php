@extends('plantilla')

@section('body')
<section>
    <div class="card rounded m-auto col-md-6 col-sm-12 m-sm-auto">
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3 form-group">
                <label class="text-primary-g text-medium GibsonRegular" for="email">Correo</label>

                <div class="">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 form-group">
                <label for="password" class="text-primary-g text-medium GibsonRegular">Contraseña</label>

                <div class="">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="pill">Login</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</section>
@endsection