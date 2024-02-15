<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('admin_assets/images/favicon.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Show Banner</title>
</head>

<body>
    <div class="d-flex flex-column align-items-center" style="margin-top: 20px;">
        <img src="{{ asset('admin_assets/banner_ad/' . $data->banner) }}" class="rounded"
            style="max-width: 100%; height: auto;"
            alt="A generic square placeholder image with rounded corners in a figure.">
        <p class="text-center mt-3" style="font-size: 20px; font-family: 'Arial', sans-serif; color: #333;">
            {{ $data->content }}</p>
    </div>

</body>

</html>
