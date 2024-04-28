<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('home') }}">
                <i class="bi bi-house-door"></i>
                <span>Home</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('produk.index') }}">
                <i class="bi bi-basket"></i>
                <span>Produk</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('satuan.index') }}">
                <i class="bi bi-cart-fill"></i>
                <span>Satuan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('user.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('penjualan.index') }}">
                <i class="bi bi-table"></i>
                <span>Penjualan</span>
            </a>
        </li>

    </ul>

</aside>
