<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- <li class="nav-item nav-profile">
            <div class="nav-link d-flex">
                <div class="profile-image">
                    <img src="https://via.placeholder.com/37x37" alt="image">
                </div>
                <div class="profile-name">
                    <p class="name">
                        Edwin Harring
                    </p>
                    <p class="designation">
                        Manager
                    </p>
                </div>
            </div>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard') }}">
                <i class=" mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#masterdataMenu" aria-expanded="false" aria-controls="masterdataMenu">
                <i class="mdi mdi-key-variant menu-icon"></i>
                <span class="menu-title">Master Data</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="masterdataMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/bank') }}">Bank</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/currency') }}">Currency</a></li>
                </ul>
            </div>
        </li>
       
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#transactionMenu" aria-expanded="false" aria-controls="transactionMenu">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Transaction</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="transactionMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/kursRate') }}">Kurs Rate</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/scrapKurs') }}">Scrap Kurs</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#memberMenu" aria-expanded="false" aria-controls="transactionMenu">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Member</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="memberMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/member') }}">Member</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/topup') }}">Top Up</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>