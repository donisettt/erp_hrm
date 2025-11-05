@php
    $isMasterDataActive =
        Request::is('karyawan*') ||
        Request::is('supplier*') ||
        Request::is('customer*') ||
        Request::is('spbu*') ||
        Request::is('material*');
@endphp

<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <i class="fas fa-cubes me-2"></i> ERP HRM
        </a>
    </div>

    <ul class="nav flex-column sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-home fa-fw me-3"></i><span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">

            <a class="nav-link" href="#masterDataCollapse" data-bs-toggle="collapse" role="button"
                aria-expanded="{{ $isMasterDataActive ? 'true' : 'false' }}" aria-controls="masterDataCollapse">
                <i class="fas fa-database fa-fw me-3"></i><span>Master Data</span>
                <i class="fas fa-chevron-down fa-xs ms-auto"></i>
            </a>

            <div class="collapse {{ $isMasterDataActive ? 'show' : '' }}" id="masterDataCollapse">
                <ul class="nav flex-column ms-4">

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('karyawan*') ? 'active' : '' }}"
                            href="{{ route('karyawan.index') }}">Data Karyawan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('supplier*') ? 'active' : '' }}"
                            href="{{ route('supplier.index') }}">Data Supplier</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('customer*') ? 'active' : '' }}"
                            href="{{ route('customer.index') }}">Data Customer</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('spbu*') ? 'active' : '' }}"
                            href="{{ route('spbu.index') }}">Data SPBU</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('material*') ? 'active' : '' }}"
                            href="{{ route('material.index') }}">Data Material</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#transaksiCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="transaksiCollapse">
                <i class="fas fa-exchange-alt fa-fw me-3"></i><span>Transaksi</span>
                <i class="fas fa-chevron-down fa-xs ms-auto"></i>
            </a>
            <div class="collapse" id="transaksiCollapse">
                <ul class="nav flex-column ms-4">
                    <li class="nav-item"><a class="nav-link" href="#">Pemasukan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pengeluaran</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#laporanCollapse" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="laporanCollapse">
                <i class="fas fa-file-alt fa-fw me-3"></i><span>Laporan</span>
                <i class="fas fa-chevron-down fa-xs ms-auto"></i>
            </a>
            <div class="collapse" id="laporanCollapse">
                <ul class="nav flex-column ms-4">
                    <li class="nav-item"><a class="nav-link" href="#">Laporan Pemasukan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Laporan Pengeluaran</a></li>
                </ul>
            </div>
        </li>

    </ul>
</nav>
