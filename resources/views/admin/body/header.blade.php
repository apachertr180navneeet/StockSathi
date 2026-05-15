<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <span style="font-size: 18px; font-weight: 700;">SA</span>
                    </span>
                    <span class="logo-lg">
                        <span style="font-size: 18px; font-weight: 700;">StockSathi Admin</span>
                    </span>
                </a>
                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <span style="font-size: 18px; font-weight: 700; color: #fff;">SA</span>
                    </span>
                    <span class="logo-lg">
                        <span style="font-size: 18px; font-weight: 700; color: #fff;">StockSathi Admin</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
            @php
                $id = Auth::user()->id;
                $profileData = App\Models\User::find($id);
            @endphp

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ !empty($profileData->photo) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ $profileData->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="bx bx-user font-size-16 align-middle me-1"></i> Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="bx bx-wallet font-size-16 align-middle me-1"></i> My Wallet
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="bx bx-lock-open font-size-16 align-middle me-1"></i> Lock screen
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
