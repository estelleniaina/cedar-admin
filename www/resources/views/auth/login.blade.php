@extends('layout/app-auth')
@section('content')

    @include("layout/error")

    <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
        <div class="mb-6">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Adresse email" value="{{old('email')}}">
        </div>

        <!-- Password -->
        <div class="mb-6 mt-4">
            <label for="exampleFormControlTextarea1" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" placeholder="Mot de passe">
        </div>

        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Se souvenir de moi
            </label>
        </div>

        <div class="sm:text-right">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    Mot de passe oublié?
                </a>
            @endif

            <button type="submit" class="btn bg-green ml-2 right">Se connecter</button>
        </div>

    </form>
@endsection
