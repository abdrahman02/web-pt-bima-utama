<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-category">Dashboard</li>
    <li class="nav-item {{ Request::is('input/*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#input" aria-expanded="false" aria-controls="input">
        <i class="menu-icon mdi mdi-desktop-mac"></i>
        <span class="menu-title">Input</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="input">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('input/client*') ? 'active' : '' }}"
              href="{{ route('client.index') }}">Pelanggan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('input/suplier*') ? 'active' : '' }}" href="/input/suplier">Suplier</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('input/barang*') ? 'active' : '' }}" href="/input/barang">Barang</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Request::is('transaksi/*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#transaksi" aria-expanded="false" aria-controls="transaksi">
        <i class="menu-icon mdi mdi-cart-outline"></i>
        <span class="menu-title">Transaksi</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="transaksi">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('transaksi/proyek*') ? 'active' : '' }}"
              href="/transaksi/proyek">Proyek</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('transaksi/pemakaian*') ? 'active' : '' }}"
              href="/transaksi/pemakaian">Pemakaian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('transaksi/pembelian*') ? 'active' : '' }}"
              href="/transaksi/pembelian">Pembelian</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Request::is('laporan/*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="laporan">
        <i class="menu-icon mdi mdi-clipboard-text"></i>
        <span class="menu-title">Laporan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="laporan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('laporan/buy*') ? 'active' : '' }}" href="/laporan/buy">Pembelian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('laporan/project*') ? 'active' : '' }}" href="/laporan/project">Proyek</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
<!-- partial -->