<div class="form-group">
    <label for="{{ $name }}" class="col-sm-2 control-label">{{ $label }}</label>
    <div class="col-sm-12">
        <input
            type="text"
            class="form-control"
            id="{{ $name }}"
            name="{{ $name }}"
{{--            placeholder="{{ $placeholder }}"--}}
{{--            {{ $required ?? ""}}--}}
            {{ $attributes }}
        >
    </div>
</div>
