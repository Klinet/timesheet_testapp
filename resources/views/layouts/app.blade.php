<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js"></script>
</head>
<body class="bg-gray-100">
<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="text-xl font-bold"><a href="/">My Laravel App</a></div>
            <div>
                <a href="{{ route('projects.create') }}" class="ml-4 text-gray-700 hover:text-gray-900">New project
                    [+]</a>
            </div>
        </div>
    </div>
</nav>
<div class="container mx-auto px-4 mt-20">
    @yield('content')
</div>
</body>
</html>
