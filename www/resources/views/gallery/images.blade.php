<div class="photos py-3">
    <!-- List images -->
    @foreach($gallery as $file)
        @if(isset($file['image']))
            <div class="photo-container">
                <input class="check-image" type="checkbox" name="image" value="{{$file['id']}}" >
                <a href="{{ Storage::url("gallery/" . $file['image'])  }}" data-toggle="lightbox" data-title="Image" data-gallery="gallery">
                    <img src="{{ Storage::url("gallery/" . $file['image'])  }}" class="photo" alt=""/>
                </a>
            </div>
        @endif
    @endforeach

</div>

<div class="pagination justify-content-end">
    {{ $gallery->onEachSide(5)->links() }}
</div>
