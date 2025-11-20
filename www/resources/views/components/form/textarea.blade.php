<div class="form-group">
    <label for="{{ $name }}" class="col-sm-2 control-label">{{ $label }}</label>
    <div class="col-sm-12">
        <textarea
            class="form-control"
            rows="{{$rows ?? 4}}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
        ></textarea>
    </div>
</div>
