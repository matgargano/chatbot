<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Our Site</title>

    <!-- Fonts -->
    <link href="css/app.css" rel="stylesheet" type="text/css">

    <!-- Styles -->

</head>
<body>
<div class="container outer-wrap">

    @yield('content')
</div>
<script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script>
    var apiBase;
    @if($api_base)apiBase = '{{ $api_base }}';@endif
</script>
<script src="js/app.js"></script>
</body>
</html>
