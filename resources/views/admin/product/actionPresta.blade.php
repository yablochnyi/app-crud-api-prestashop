<a href="{{ route('add.prestashop',$id) }}" data-toggle="tooltip" data-original-title="Add"
   class="edit btn btn-success edit">
    Add to prestashop
</a>
<form method="post" action="{{ route('update.price.prestashop',$id) }}">
    @csrf
    @method('put')
    <button type="submit" class="edit btn btn-success edit mt-1">
            Update price to prestashop
    </button>
</form>
<form method="post" action="{{ route('update.quantity.prestashop',$id) }}">
    @csrf
    @method('put')
    <button type="submit" class="edit btn btn-success edit mt-1">
            Update quantity to prestashop
    </button>
</form>
<form method="post" action="{{ route('delete.prestashop',$id) }}">
    @csrf
    @method('delete')
    <button type="submit" class="delete btn btn-danger mt-1">
    Delete
    </button>
</form>
