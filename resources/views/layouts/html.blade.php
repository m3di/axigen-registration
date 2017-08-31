<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
@stack('html-metas')
<title>@stack('html-title')</title>
@stack('html-styles')
@stack('html-scripts')
</head>
<body>
@yield('html-body')
</body>
</html>