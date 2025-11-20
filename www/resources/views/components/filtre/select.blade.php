<div class="form-group row">
    <label for="centre_id" class="col-sm-3 col-form-label">{{$label}}</label>
    <div class="col-sm-9">
        <select class="form-control" id="{{$name}}" name="{$name}}">
            @if(isset($showAll) && $showAll)
                <option value=""> -- Tous -- </option>
            @endif
            @foreach($data as $key => $value)
                <option value="{{ $key }}"> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
