<!DOCTYPE html>
<html>
    <head>
        <title>Book Records</title>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
            }

            .container {
                width:100%;
                text-align: left;
                display: table-cell;
            }

            .content {
                text-align: left;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    </head>
    <body>

        <div class="container">

            <div class="content">
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <br/>
                @yield('content')
            </div>
        </div>
    </body>
</html>
