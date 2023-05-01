<header>

        <nav class="navbar navbar-expand-lg bg-danger">
            <div class="container">
                <a class="navbar-brand" href="{{ route('library') }}"> Library </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"> Products </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#"> Events </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropbtn" aria-current="page" href="{{ route('my_information') }}"> My Profile </a>
                            <div class="dropdown-content">
                                <a href="{{ route('my_information') }}">My Information</a>
                                <a href="{{ route('Orders') }}">Orders</a>
                                <a href="{{ route('logout') }}">Log Out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

</header>
