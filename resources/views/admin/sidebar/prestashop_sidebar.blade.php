<!-- Side navigation -->
<div class="sidenav">
    <div class="action">
        PrestaShop
    </div>
    <div class="hr-shadow">
        <ul>
            <li>
                <a class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-6"
                   href="{{ route('add.all.prestashop') }}"> Add all products</a>
            </li>

            <li>
                <a class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2"
                   href="{{ route('update.all.price.prestashop') }}"> Update all prices</a>
            </li>
            <li>
                <a class="btn btn-custom-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2"
                   href="{{ route('update.all.quantity.prestashop') }}"> Update all quantity</a>
            </li>
        </ul>
    </div>
</div>
