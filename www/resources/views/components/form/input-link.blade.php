<div class="form-group">
    <label class="control-label">{{ $label }}</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">https://</span>
        </div>
        <input class="form-control" type="text" placeholder="{{ $placeholder }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name) }}">
    </div>
    {{ $slot }}

</div>
