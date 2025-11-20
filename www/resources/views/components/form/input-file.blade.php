<div class="form-group">
    <label for="{{ $name }}" class="">{{ $label }}</label>
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="{{ $name }}" name="{{ $name }}" data-value="" {{$attributes}}>
            <label class="custom-file-label" for="{{ $name }}">{{ $placeholder }}</label>
        </div>
    </div>
</div>
