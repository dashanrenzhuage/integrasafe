<!DOCTYPE html>
<html>
<head>
    <title>404 Not Found</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" type="text/css" rel="stylesheet">
    <link href="{{ asset('/img/integrasafe-logo-enchanted.png') }}" sizes="32x32" type="image/png" rel="icon">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }

        .subtitle {
            font-size: 45px;
            margin-bottom: 30px;
        }

        .links {
            font-size: 35px;
            margin-bottom: 40px;
        }

        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            vertical-align: middle;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title"><strong>404 - Not Found</strong></div>
        <div class="subtitle"><strong>We're sorry, it looks like you've reached the wrong page</strong></div>
        <div class="links">
            <strong>
                Were you trying to reach: <a href="https://integrasafe.net">Integrasafe Homepage</a>?
            </strong>
        </div>
        <div class="loader" align="center"></div>
    </div>
</div>
</body>
</html>
