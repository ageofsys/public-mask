<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>공공 마스크정보 - @yield('title')</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .remain-stat-plenty { color: #28a745; } /*100개 이상(녹색): 'plenty'*/
        .remain-stat-some { color: #ffc107; } /*30개 이상 100개미만(노랑색): 'some' */
        .remain-stat-few { color: #dc3545; } /*2개 이상 30개 미만(빨강색): 'few' */
        .remain-stat-empty { color: #6c757d; } /*1개 이하(회색): 'empty'*/

        body {
            padding-top: 56px;
        }
    </style>

    @stack("styles")
</head>
<body>

@include("shared.nav")

<main>
    <div class="container-fluid">
        @yield("content")
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
@stack("scripts")
</body>
</html>
