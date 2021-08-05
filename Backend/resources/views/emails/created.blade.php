<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 50px;
        }

        .list > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .list > ul > li {
            text-align: left;
        }

        .list-item {
            font-weight: bold;
            margin-left: 90px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        li {
            list-style-type: none;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">

    <div class="content">
        <div class="title m-b-md">
            Organisations API
        </div>

        <div class="list">
            <h2>Hello {{$user->name}}!</h2>
            <h3>You Created Organisation:</h3>
            <ul>
                <li>
                    <span class="list-item">Name:</span> {{$organisation->name}}
                </li>
                <li>
                    <span class="list-item">Description:</span> {{$organisation->description}}
                </li>
                <li>
                    <span class="list-item">Trial End:</span> {{ \Carbon\Carbon::parse($organisation->trial_end)->format('d/m/Y')}}
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
