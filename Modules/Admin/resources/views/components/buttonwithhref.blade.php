@if (checkRoleHasPermission())
    <a href="{{ $route }}" class="btn btn-{{ $type }} text-white">
        <i class="fas fa-{{ $icon }} mr-2"></i>
        @if ($title)
            <span>{{ $title }}</span>
        @endif
    </a>
@endif
