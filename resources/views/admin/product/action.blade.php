<a href="{{ route('products.edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
    Edit
</a>
<a href="{{ route('add.prestashop',$id) }}" data-toggle="tooltip" data-original-title="Add" class="edit btn btn-success edit">
    Add to prestashop
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger mt-1">
    Delete
</a>
