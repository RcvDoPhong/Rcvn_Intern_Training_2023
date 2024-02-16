@php
    $currentPage = explode('/', Request::path());
    if (is_numeric(end($currentPage))) {
        array_pop($currentPage);
    }

    $dir = ucwords(Request::path(), '/');
    $editPath = explode('/', $dir);

    // Check if path has User ID
    if (is_numeric(end($editPath))) {
        array_pop($editPath); // Remove it
        $dir = implode('/', $editPath);
    }

    $goBack = explode('.', Request::route()->getName());
    array_pop($goBack);
    $goBackUrl = implode('.', $goBack);
@endphp

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar-expand navbar-white navbar-light">
            <span class="nav-link">
                @if (!preg_match('(index|dashboard)', Request::route()->getName()))
                    <a href="{{ route($goBackUrl . '.index') }}">
                        <i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>
                    </a>
                @endif
                <span class="d-none d-md-inline font-weight-bold">{{ strtoupper(end($currentPage)) }}</span>
                <span class="ml-5 d-none d-md-inline float-right">
                    {{ str_replace('/', ' / ', $dir) }}
                </span>
            </span>
        </nav>
    </div>
</body>
