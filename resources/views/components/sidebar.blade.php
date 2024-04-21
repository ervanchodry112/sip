<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('home') }}">
                <i class="bi bi-house-door"></i>
                <span>Home</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#master-data" data-bs-toggle="collapse" href="#">
                <i class="bi bi-database"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-data" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('produk.index') }}">
                        <i class="bi bi-circle"></i><span>Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('satuan.index') }}">
                        <i class="bi bi-circle"></i><span>Satuan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}">
                        <i class="bi bi-circle"></i><span>Users</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-cart-fill"></i>
                <span>Pembayaran</span>
            </a>
        </li><!-- End Profile Page Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-table"></i>
                <span>Penjualan</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-bank"></i>
                <span>Profil Toko</span>
            </a>
        </li><!-- End Profile Page Nav -->


    </ul>

</aside>
