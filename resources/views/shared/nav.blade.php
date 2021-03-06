@php
    $routeName = Route::currentRouteName();
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top border-b">
    <div class="container">
        <a class="navbar-brand" href="/">공적 마스크 판매처별 현황</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item @if($routeName == "search.index") active @endif">
                    <a class="nav-link" href="{{ route("search.index") }}">지도로 검색</a>
                </li>
                <li class="nav-item @if($routeName == "stores.index" || $routeName == "welcome") active @endif">
                    <a class="nav-link" href="{{ route("stores.index") }}">표로 검색</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
