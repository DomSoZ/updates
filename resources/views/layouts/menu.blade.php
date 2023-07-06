@section('menu')
<!-- Navbar -->
<div class="container-fluid my-2 shadow-sm bg-white boderBottom--Rosa">
    <nav class="navbar ms-3 navbar-light navbar-expand-lg bg-white">
        <button class="pill me-5" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample"><i class="fas fa-bars"></i></button>
        <div class="container-fluid">
            <div class="me-auto">
                <img class="logo-header" src="http://ui.michoacan.gob.mx/static/media/LogoGobMich-Artboard1.21e8f905786dd1536f8c.png" alt="logo">
            </div>
            <div class="vr"></div>
            <div class="btn-group">
                <div class="ms-3 dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{Auth::user()->name}}
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <button type="submit" class="dropdown-item" form="logoutModal">
                            Salir
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<form id="logoutModal" name="logoutModal" method="POST" action="{{ route('logout') }}" hide>
    @csrf
</form>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title GibsonItalic" id="offcanvasExampleLabel">Mesa de Ayuda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="menu_item"><a href=" {{ route('busqueda') }}" class="nav-link">
                <i class="fas fa-chart-bar" style="font-size: 23px;"></i>
                Dashboard
            </a>
        </div>
    </div>
</div>
@endsection