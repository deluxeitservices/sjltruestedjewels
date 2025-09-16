<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SJL Trusted Jewels</title>
    <link href="{{ URL::asset('/css/bootstrap.min.css') }}?t=2" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('/css/owl.carousel.min.css') }}?t=2?t=2">
    <link rel="stylesheet" href="{{ URL::asset('/css/owl.theme.default.min.css') }}?t=2?t=2">
    <link rel="icon" href="{{ asset('./assets/image/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
     <link  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easyzoom/2.5.2/easyzoom.min.css">
    <link rel="stylesheet" href="https://icodefy.com/Tools/iZoom/js/Vendor/fancybox/helpers/jquery.fancybox-thumbs.css">
    <link rel="stylesheet" href="{{ URL::asset('/css/zoom.css') }}?t=2?t=2">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
      rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('./css/common.css') }}??t=2" />

    
  </head>
<body>
    @include('partials._header')
    @yield('content')
    @include('partials._footer')
    @stack('scripts')
 </body>

</html>