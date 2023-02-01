<header>

        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"> Library </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" href="#">Books</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Add Book</a></li>
                                <li><a class="dropdown-item" href="#">Books</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" href="#">Blog</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Add Author</a></li>
                                <li><a class="dropdown-item" href="#">Author</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Log In</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

</header>
