<div class="header">
	<div class="container">

        @if(Auth()->user())
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="/"><div class="header__logo-img"></div></a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        @if(Auth()->user()->role == 'User' && Auth()->user()->step_register == 'done')
                            <li class="nav-item {{ (request()->is('profile*')) ? 'active' : '' }}">
                                <a href="{{ route('profile') }}" class="nav-link">Profile</a>
                            </li>
                            <li class="nav-item {{ (request()->is('projects*')) ? 'active' : '' }}">
                                <a href="{{ route('projects', 'skip=true') }}" class="nav-link">Projects</a>
                            </li>
                        @endif
                        @if(Auth()->user()->role == 'Admin')
                            <li class="nav-item {{ (request()->is('users*')) ? 'active' : '' }}">
                                <a href="{{ route('users') }}" class="nav-link">Users</a>
                            </li>
                            <li class="nav-item {{ (request()->is('manager*')) ? 'active' : '' }}">
                                <a href="{{ route('manager') }}" class="nav-link">Project Manager</a>
                            </li>
                        @endif
                        @if(Auth()->user())
                            <li class="nav-item nav-link">
                                Hello, {{ Auth()->user()->first_name }} {{ Auth()->user()->last_name }} <a href="{{ route('logout') }}" >[Exit]</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        @endif

	</div>
</div>
