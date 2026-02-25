<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">
        
        @auth
            @include('Components.aside')
        @endauth

        <main class="flex-1 flex flex-col">
            
            @guest
                <div class="flex-1 flex items-center justify-center p-6">
                    @yield('content')
                </div>
            @else
                <div class="p-8">
                    @if(session('message'))
                        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                            {{ session('message') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            @endguest

        </main>
    </div>

</body>
</html>