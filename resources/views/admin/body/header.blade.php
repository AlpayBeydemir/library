<header>

        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}"> Dashboard </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" href="#">Books</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('add.book') }}">Add Book</a></li>
                                <li><a class="dropdown-item" href="{{ route('book') }}">Books</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" href="#">Categories</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('add.category') }}">Add Category</a></li>
                                <li><a class="dropdown-item" href="{{ route('category') }}">Categories</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" role="button" data-bs-toggle="dropdown" href="#">Author</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('add.author') }}">Add Author</a></li>
                                <li><a class="dropdown-item" href="{{ route('author') }}">Author</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Reg. Student</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">My Information</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

</header>
