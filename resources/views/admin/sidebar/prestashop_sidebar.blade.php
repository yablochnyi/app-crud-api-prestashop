<!-- Side navigation -->
<div class="sidenav">
    <div class="action">
        PrestaShop
    </div>
    <div class="hr-shadow">
        <ul>
            <li>
                <a class="btn btn-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-6"
                   href="{{ route('add.all.prestashop') }}"> Add all products</a>
            </li>

            <li>
                <a class="btn btn-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2"
                   href="{{ route('update.all.price.prestashop') }}"> Update all prices</a>
            </li>
            <li>
                <a class="btn btn-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all mt-2"
                   href="{{ route('update.all.quantity.prestashop') }}"> Update all quantity</a>
            </li>
        </ul>
    </div>
</div>

<style>
    .hr-shadow {
        margin: 20px 0;
        padding: 20px;
        height: 10px;
        border: none;
        border-top: 1px solid #333;
        box-shadow: 0 10px 10px -10px #8c8b8b inset;
    }
    /* The sidebar menu */
    .action {
        text-transform: uppercase;
        font-size: 15px;
        color: white;
        letter-spacing: 3px;
        font-weight: bold;
        padding: 26px
    }
    .sidenav {
        height: 100%; /* Full-height: remove this if you want "auto" height */
        width: 280px; /* Set the width of the sidebar */
        position: fixed; /* Fixed Sidebar (stay in place on scroll) */
        z-index: 1; /* Stay on top */
        top: 0; /* Stay at the top */
        right: 0;
        background-color: #111; /* Black */
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 40px;
        /*padding: 30px;*/
    }
    /* The navigation menu links */
    .sidenav a {
        /*box-shadow: 1px 1px 8px #ffffff;*/

        /*padding: 6px 8px 6px 16px;*/
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
    }
    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
        color: #f1f1f1;
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }
</style>
