<div class="navbar-container ">
    <nav class="navbar navbar-expand-lg bg-white navbar-light" data-sticky="top">
        <div class="container">
            <a class="navbar-brand fade-page" href="/">
                <img src="/assets/img/logo.svg" alt="Leap">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 17C3 17.5523 3.44772 18 4 18H20C20.5523 18 21 17.5523 21 17V17C21 16.4477 20.5523 16 20 16H4C3.44772 16 3 16.4477 3 17V17ZM3 12C3 12.5523 3.44772 13 4 13H20C20.5523 13 21 12.5523 21 12V12C21 11.4477 20.5523 11 20 11H4C3.44772 11 3 11.4477 3 12V12ZM4 6C3.44772 6 3 6.44772 3 7V7C3 7.55228 3.44772 8 4 8H20C20.5523 8 21 7.55228 21 7V7C21 6.44772 20.5523 6 20 6H4Z"
                          fill="#212529" />
                </svg>

            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <div class="py-2 py-lg-0">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="/home" class="nav-link dropdown-toggle" data-toggle="dropdown-grid" aria-expanded="false" aria-haspopup="true">Мои сайты</a>

                        </li>
						
						
						

                    </ul>
                </div><a href="/logout" class="btn btn-primary ml-lg-3" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </div>
    </nav>
</div>