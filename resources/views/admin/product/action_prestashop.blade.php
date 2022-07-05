<form method="post" action="{{ route('add.prestashop',$id) }}">
    @csrf
    <button type="submit" class="edit btn btn-success edit mt-1">
        Add to prestashop
    </button>
</form>
<<<<<<< HEAD
{{--<a href="{{ route('add.prestashop',$id) }}" data-toggle="tooltip" data-original-title="Add"--}}
{{--   class="edit btn btn-custom-success edit">--}}
{{--    Add to prestashop--}}
{{--</a>--}}
=======
>>>>>>> dev
<form method="post" action="{{ route('update.price.prestashop',$id) }}">
    @csrf
    @method('put')
    <button type="submit" class="edit btn btn-success edit mt-1">
            Update price
    </button>
</form>
<form method="post" action="{{ route('update.quantity.prestashop',$id) }}">
    @csrf
    @method('put')
    <button type="submit" class="edit btn btn-success edit mt-1">
            Update quantity
    </button>
</form>
