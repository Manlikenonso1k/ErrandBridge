<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    @php
      $assetUrl = static function (string $path): string {
          $path = ltrim($path, '/');
          $docRoot = realpath((string) request()->server('DOCUMENT_ROOT', ''));
          $publicRoot = realpath(public_path());

          if ($docRoot !== false && $publicRoot !== false && $docRoot === $publicRoot) {
              return url($path);
          }

          return url('public/' . $path);
      };
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ErrandBridge')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $assetUrl('assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $assetUrl('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $assetUrl('assets/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $assetUrl('assets/img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ $assetUrl('assets/img/favicons/manifest.json') }}">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ $assetUrl('assets/css/theme.css') }}" rel="stylesheet" />
    @livewireStyles
    @stack('styles')
  </head>
  <body>
    @yield('content')

    <script src="{{ $assetUrl('vendors/@popperjs/popper.min.js') }}"></script>
    <script src="{{ $assetUrl('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ $assetUrl('vendors/is/is.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ $assetUrl('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ $assetUrl('assets/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ethers@6.13.2/dist/ethers.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    @livewireScripts
    @stack('scripts')
  </body>
</html>
