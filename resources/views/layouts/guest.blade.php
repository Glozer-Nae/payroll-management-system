<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Payroll Management System') }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%230d6efd' width='100' height='100'/><text x='50' y='70' font-size='60' font-weight='bold' fill='white' text-anchor='middle' font-family='Arial'>₱</text></svg>">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    @yield('content')

</body>

</html>