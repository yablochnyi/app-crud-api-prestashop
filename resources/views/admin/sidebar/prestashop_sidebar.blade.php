<!-- Side navigation -->
<div class="sidenav">
    <div class="action">
        PrestaShop
    </div>
    <div class="hr-shadow">
        <ul>
            <form method="post" action="{{ route('add.all.prestashop') }}">
                @csrf
                <button type="submit" class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-6">
                    Add all products
                </button>
            </form>
            <li>
                <a class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2"
                   href="{{ route('update.price.all.prestashop') }}"> Update all prices</a>
            </li>
            <li>
                <a class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2"
                   href="{{ route('update.all.quantity.prestashop') }}"> Update all quantity</a>
            </li>
        </ul>
    </div>
</div>
