@extends("layout/app")

@section("title")
    Page profil
@endsection

@section("sub-title")
   Modification du profil
@endsection

@section("content")
    @include("layout/error")

    <form method="POST" action="{{ route('profil.update') }}">
        @csrf

        <!-- Nom -->
        <div class="mb-3">
            <label for="name" class="form-label"> Nom </label>
            <input type="text" class="form-control" id="name" name="name" required autofocus placeholder="Nom" value="{{$name}}">
        </div>

        <!-- Email Address -->
        <div class="mb-3 mt-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Adresse email" value="{{$email}}">
        </div>

        {{--    <div class="row">--}}
{{--    <div class="col-md-6">--}}
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Modification mot de passe</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
{{--                <div class="form-group">--}}
{{--                    <label for="inputName">Project Name</label>--}}
{{--                    <input type="text" id="inputName" class="form-control" value="AdminLTE">--}}
{{--                </div>--}}

                <!-- Mot de passe -->
                <div class="mb-3 mt-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                </div>

                <!-- Confirmer mot de passe -->
                <div class="mb-3 mt-4">
                    <label for="password_confirmation" class="form-label">Confirmer mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmer mot de passe">
                </div>
            </div>
            <!-- /.card-body -->
        </div>

            <div class="text-right">
            <button type="submit" class="btn btn-success">Modifier</button>
            </div>

            {{--        <!-- /.card -->--}}
{{--    </div>--}}
{{--    </div>--}}
    </form>
@endsection
