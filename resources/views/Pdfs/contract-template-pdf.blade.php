<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <title>emergency Market</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        background-color: #FDFDFD;
      }
      .contract {
        width: 90%;
        margin: auto;
      }
      .contract ul, .contract ol {
        list-style-position: outside;
        padding-left: 20px;
      }
      .contract-title {
        text-align: center;
        font-size: 22px;
        color: #000000d9;
        font-weight: 600;
        font-family: 'Poppins';
        text-transform: uppercase;
        margin: 50px 0px 20px;
      }
      .contract-content {
        text-align: justify;
        font-size: 16px;
        font-family: 'inter';
        line-height: 25px;
      }
      .contract hr {
        background-color: black;
        height: 1px;
        margin-bottom: 10px;
      }

      .contract > img {
        width: 150px;
      }
    </style>
</head>

<body class="antialiased">
  <div class="contract">
    <h1 class="contract-title">{{ $contract->name }}</h1>
    <hr>
    <div class="contract-content">
      {!! $contract->content !!}
    </div>
  </div>
</body>
</html>
