@extends('layout/app-auth')
@section('content')

    @include("layout/error")

    <h1 class="h3 mb-3 fw-normal">Réinitialisation mot de passe</h1>

    <form method="POST" action="{{ route('password.update') }}">
    @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3 mt-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="Adresse email" value="{{old('email')}}">
        </div>

        <!-- Mot de passe -->
        <div class="mb-3 mt-4">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Mot de passe">
        </div>

        <!-- Confirmer mot de passe -->
        <div class="mb-3 mt-4">
            <label for="password_confirmation" class="form-label">Confirmer mot de passe</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirmer mot de passe">
        </div>

        <button type="submit" class="btn btn-success">Réinitialiser mot de passe</button>
    </form>

@endsection
