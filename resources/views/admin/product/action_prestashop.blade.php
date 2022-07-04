<form method="post" action="{{ route('add.prestashop',$id) }}">
    @csrf
    <button type="submit" class="edit btn btn-custom-success edit mt-1">
        Add to prestashop
    </button>
</form>
<form method="post" action="{{ route('update.price.prestashop',$id) }}">
    @csrf
    @method('put')
    <button type="submit" class="edit btn btn-custom-success edit mt-1">
            Update price
    </button>
</form>
<form method="post" action="{{ route('update.quantity.prestashop',$id) }}">
    @csrf
    @method('put')
    <button type="submit" class="edit btn btn-custom-success edit mt-1">
            Update quantity
    </button>
</form>
