<a
   href="javascript:void(0);"
   data-toggle="tooltip"
   data-id="{{ $id }}"
   data-original-title="Modifier"
   onclick="bntEditClick( '{{ route('connaissance.edit', $id)  }}', 'Modification base de connaissance' )"
>
    <i class="fas fa-edit color-green"></i>
</a>
<a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Supprimer" data-id="{{ $id }}"
    onclick="deleteFunc( '{{ route('connaissance.destroy', $id)  }}' )">
    <i class="fas fa-trash color-red"></i>
</a>
