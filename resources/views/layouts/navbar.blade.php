<div class="jumbotron text-center mb-0">
    <h1 class="font-weigth-bold banner-text">JUAN’S AUTO PAINT</h1>
</div>
<nav class="navbar navbar-expand-sm main-bg p-3 ">
    <ul class="navbar-nav text-uppercase">
        <li class="nav-item {{ Request::is('/')  ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('index') }}">New Paint Job</a>
        </li>
        <li class="nav-item {{ Request::is('/')  ? '' : 'active' }}">
            <a class="nav-link" href="{{ route('show') }}">Paint Jobs</a>
        </li>
    </ul>
</nav>