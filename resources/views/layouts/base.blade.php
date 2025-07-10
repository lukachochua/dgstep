<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'DGstep' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-blue text-gray-800 font-sans antialiased">
    {{ $slot }}
</body>

</html>
<!-- This is a base layout for the application. It includes the necessary meta tags, styles, and scripts. -->