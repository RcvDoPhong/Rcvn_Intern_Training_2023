@php
    $constantsClass = Modules\Admin\App\Constructs\Constants::class;
    $routeLists = $constantsClass::ROUTE_LISTS;
@endphp
@foreach ($routeLists as $pathKey => $route)
    @if ($route['permission'] === '' || checkRoleHasPermission($route['permission']))
        <li class="nav-item">
            <a href="{{ route($route['link']) }}"
                class="nav-link {{ str_contains(Request::path(), "$pathKey") ? 'active' : '' }}">
                <i class="{{ $route['icon'] }} mr-2"></i>
                <p>{{ $route['name'] }}</p>
            </a>
        </li>
    @endif
@endforeach
