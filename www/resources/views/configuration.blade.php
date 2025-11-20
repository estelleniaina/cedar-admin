@extends("layout/app", [
    "title" => "Gestion configuration"
])

@section("content")
    <div class="row">
        <div class="col-6">
            @include('layout.error')
            <form action="{{ route('configuration.save') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" title="Facebook"><i class="fab fa-facebook"></i></span>
                    </div>
                    <input type="text" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $facebook) }}">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                    </div>
                    <input type="text" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', $instagram) }}">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

@endsection
