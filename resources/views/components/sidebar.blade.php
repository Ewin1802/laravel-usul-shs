<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        {{-- <div class="sidebar-brand">
            <a href="">USAHA</a>
        </div> --}}
        <div class="sidebar-brand">
            <a href="#">
                <img src="{{ asset('img/logo_usaha.png') }}" alt="Logo Usaha" style="height: 60px;">
            </a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">USAHA</a>
        </div>



        <ul class="sidebar-menu">
            <li class="menu-header">Akses Umum</li>

            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}" class="nav-link">
                    <i class="fab fa-windows"></i><span>Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->roles == 'SKPD')
                <li class="menu-header">Upload Surat</li>

                <li class="nav-item {{ Request::is('documents*', 'docs_user*') ? 'active' : '' }}">
                    <a href="{{ route('documents.index') }}" class="nav-link">
                        <i class="fas fa-file-alt"></i>
                        <span>Upload Surat Usulan<Br>(Pdf Maks 500 Kb)</span>
                    </a>
                </li>

                <li class="menu-header">Input Data</li>

                <li class="nav-item {{ Request::is('shs*') && !Request::is('shs/admin_shs') && !Request::is('shs/export_shs') ? 'active' : '' }}">
                    <a href="{{ route('shs.index') }}" class="nav-link">
                        <i class="fas fa-fire"></i><span>Usul SSH (Barang)</span>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('sbu*') && !Request::is('sbu/admin_sbu') && !Request::is('sbu/export_sbu') ? 'active' : '' }}">
                    <a href="{{ route('sbu.index') }}" class="nav-link">
                        <i class="fas fa-fire"></i><span>Usul SBU (Jasa/Honor)</span>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('asb*') && !Request::is('asb/admin_asb') && !Request::is('asb/export_asb') ? 'active' : '' }}">
                    <a href="{{ route('asb.index') }}" class="nav-link">
                        <i class="fas fa-fire"></i><span>Usul ASB (Kegiatan)</span>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('hspk*') && !Request::is('hspk/admin_hspk') && !Request::is('hspk/export_hspk') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="nav-link text-muted" tabindex="-1" aria-disabled="true" style="pointer-events: none; color: rgb(198, 17, 17);">
                        <i class="fas fa-fire"></i><span>Usul HSPK</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->roles == 'ADMIN')
                <li class="menu-header">Akses Admin</li>

                    <li class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" class="nav-link">
                            <i class="fas fa-users"></i><span>User</span>
                        </a>
                    </li>

                    <!-- Dropdown for Dokumen Dasar -->
                    <li class="nav-item dropdown {{ Request::is('satuan*','kelompok*','belanja*','skpd*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-database"></i><span>Dokumen Dasar</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Satuan Barang dan Jasa -->
                            <li class="{{ Request::is('satuan*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('satuan.index') }}">Satuan Barang dan Jasa</a>
                            </li>
                            <!-- Rekening Kelompok -->
                            <li class="{{ Request::is('kelompok*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('kelompok.index') }}">Rekening Kelompok</a>
                            </li>
                            <!-- Rekening Belanja -->
                            <li class="{{ Request::is('belanja') || Request::is('belanja/*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('belanja.index') }}">Rekening Belanja</a>
                            </li>

                            <!-- Rekening Belanja API -->
                            <li class="{{ Request::is('belanjaApi') || Request::is('belanjaApi/*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('belanjaApi.index') }}">Rekening Belanja API</a>
                            </li>
                            <!-- Data SKPD -->
                            <li class="{{ Request::is('skpd*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('skpd.index') }}">Data SKPD</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Menu Admin Proses Usulan -->
                    <li class="nav-item dropdown {{ Request::is('shs/admin_shs','sbu/admin_sbu','asb/admin_asb', 'hspk/admin_hspk','admin/docs_admin') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-cog"></i>
                            <span>Proses Usulan</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ Request::is('shs/admin_shs') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('shs.admin_shs') }}">Usulan SSH</a>
                            </li>
                            <li class="{{ Request::is('sbu/admin_sbu') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('sbu.admin_sbu') }}">Usulan SBU</a>
                            </li>
                            <li class="{{ Request::is('asb/admin_asb') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('asb.admin_asb') }}">Usulan ASB</a>
                            </li>
                            <li class="{{ Request::is('hspk/admin_hspk') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('hspk.admin_hspk') }}">Usulan HSPK</a>
                            </li>
                            <li class="{{ Request::is('admin/docs_admin') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('docs_admin') }}">Doc. Surat Usulan</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Export SSH -->

                    <li class="nav-item {{ Request::is('shs/export_shs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('shs.export_shs') }}">
                            <i class="fas fa-spinner "></i><span>Export SSH</span>
                        </a>
                    </li>

                    <!-- Export SBU -->
                    <li class="nav-item {{ Request::is('sbu/export_sbu') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('sbu.export_sbu') }}">
                            <i class="fas fa-spinner "></i><span>Export SBU</span>
                        </a>
                    </li>

                    <!-- Export ASB -->
                    <li class="nav-item {{ Request::is('asb/export_asb') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('asb.export_asb') }}">
                            <i class="fas fa-spinner "></i><span>Export ASB</span>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('hspk/export_hspk') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('hspk.export_hspk') }}">
                            <i class="fas fa-spinner "></i><span>Export HSPK</span>
                        </a>
                    </li>
                </li>
            @endif
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://www.instagram.com/bmdbolmut/"
               class="btn btn-primary btn-lg btn-block btn-icon-split">
               <i class="fas fa-rocket"></i> Tentang Kami
            </a>
        </div>
    </aside>
</div>
