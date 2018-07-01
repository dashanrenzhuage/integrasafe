<!DOCTYPE html>
<html>
    <head>
        <title>Maintenance Mode</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" type="text/css" rel="stylesheet">

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
                <div class="title"><strong>Our site is currently undergoing maintenance.</strong></div>
                <div class="subtitle"><strong>We will be back online shortly!</strong></div>
                <div class="loader" align="center"></div>
            </div>
        </div>
    </body>
</html>
