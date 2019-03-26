<ul class="navbar-nav">
  <a class="navbar-brand d-none d-md-block">{{ config('app.name', 'UpSales') }}</a>
  @guest
  @else
  @if (Gate::allows('module', 'principal'))
    @if(Request::path() == 'home' || Request::path() == '/')
      <li class="nav-item nav-link active">Principal</li>
    @else
      <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Principal</a></li>
    @endif
    @if($submenu && ReqUtils::isCurrentMenu('home'))
      <div class="navbar-nav pl-2">@yield('header')</div>
    @endif
  @endif
    @if (Gate::allows('module', 'administration'))
      @if(Request::path() == 'administration')
        <li class="nav-item nav-link active">Administración</li>
      @else
        <li class="nav-item"><a class="nav-link" href="{{route('administration')}}">Administración</a></li>
      @endif
      @if($submenu && ReqUtils::isCurrentMenu('administration'))
        <div class="navbar-nav pl-2">@yield('header')</div>
      @endif
    @endif
    @if (Gate::allows('module', 'security'))
      @if(Request::path() == 'security')
        <li class="nav-item nav-link active">Seguridad</li>
      @else
        <li class="nav-item"><a class="nav-link" href="{{route('security')}}">Seguridad</a></li>
      @endif
      @if($submenu && ReqUtils::isCurrentMenu('security'))
        <div class="navbar-nav pl-2">@yield('header')</div>
      @endif
    @endif
    @if (!is_null(Request::get('modulesMenuItem')))
      @foreach(Request::get('modulesMenuItem') as $menuItem)
        <li class="nav-item"><a class="nav-link" href="{{$menuItem['url']}}">{{$menuItem['text']}}</a></li>
      @endforeach
    @endif
   @endguest
</ul>
