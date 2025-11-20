<a
   href="javascript:void(0);"
   data-toggle="tooltip"
   data-id="{{ $id }}"
   data-original-title="Modifier"
   onclick="bntEditClick( '{{ route('opportunite.edit', $id)  }}' )"
>
    <i class="fas fa-edit color-green"></i>
</a>
<a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Supprimer" data-id="{{ $id }}"
    onclick="deleteFunc( '{{ route('opportunite.destroy', $id)  }}' )"
>
    <i class="fas fa-trash color-red"></i>
</a>
