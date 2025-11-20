@extends('layout/app-auth')
@section('content')

    @include("layout/session-success")
    @include("layout/error")

    <h1 class="h3 mb-3 fw-normal">Mot de passe oublié?</h1>
    <p>Veuillez entrer votre adresse email et nous vous enverrons un email pour réinitialiser votre mot de passe</p>

    <form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
        <div class="mb-3 mt-4">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Adresse email" value="{{old('email')}}">
        </div>


        <button type="submit" class="btn btn-success">Envoyer l'email de réinitialisation</button>
    </form>

@endsection
