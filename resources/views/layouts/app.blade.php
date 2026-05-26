<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Payroll Management System') }}</title>

    {{-- Bootstrap 5 CSS & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%230d6efd' width='100' height='100'/><text x='50' y='70' font-size='60' font-weight='bold' fill='white' text-anchor='middle' font-family='Arial'>₱</text></svg>">
    
    <style>
        body { 
            background-color: #f8f9fa; 
        }
        
        /* Offset main content on desktop to make room for the 280px fixed sidebar */
        @media (min-width: 992px) {
            #main-content {
                margin-left: 280px;
            }
        }
    </style>
</head>
<body>

    {{-- SIDEBAR NAVBAR --}}
    @include('partials.navbar') 

    {{-- MAIN CONTENT AREA --}}
    <main id="main-content" class="p-4 p-md-5 min-vh-100">    

        {{-- SUCCESS ALERT --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ERROR ALERT --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- INJECTED PAGE CONTENT --}}
        @yield('content')

    </main>

    {{-- Bootstrap 5 JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>