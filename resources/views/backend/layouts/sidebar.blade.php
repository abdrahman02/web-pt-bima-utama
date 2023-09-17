<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-category">Dashboard</li>
    <li
      class="nav-item {{ Request::is('input/client*') ? 'active' : '' }} {{ Request::is('input/suplier*') ? 'active' : '' }} {{ Request::is('input/barang*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#input" aria-expanded="false" aria-controls="input">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
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
    <li
      class="nav-item {{ Request::is('transaksi/pemakaian*') ? 'active' : '' }} {{ Request::is('transaksi/pembelian*') ? 'active' : '' }} {{ Request::is('transaksi/proyek*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#transaksi" aria-expanded="false" aria-controls="transaksi">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
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
    <li
      class="nav-item {{ Request::is('laporan/pemakaian*') ? 'active' : '' }} {{ Request::is('laporan/pembelian*') ? 'active' : '' }} {{ Request::is('laporan/proyek*') ? 'active' : '' }}">
      <a class="nav-link" data-bs-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="laporan">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
        <span class="menu-title">Laporan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="laporan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('laporan/pemakaian*') ? 'active' : '' }}"
              href="/laporan/pemakaian">Pemakaian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('laporan/pembelian*') ? 'active' : '' }}" href="#">Pembelian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('laporan/proyek*') ? 'active' : '' }}" href="#">Proyek</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
<!-- partial -->