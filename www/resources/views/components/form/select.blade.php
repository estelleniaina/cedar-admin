<div class="form-group">
    <label for="name" class=" control-label">{{$label}}</label>
    <div class="">
        <select class="form-control" id="{{ $name }}" name="{{ $name }}" >
            @foreach($data as $key => $value)
                <option value="{{ $key }}"> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
