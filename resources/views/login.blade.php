<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script> 
    <title></title>
  </head>
  <body>
    <div id="app">
    <el-container>
        <el-header>
          <login-header></login-header>
        </el-header>
        <el-container>
          <el-main>
          <user-login></user-login>
          </el-main>
        </el-container>
      </el-container>
      
    </div>
  </body>
  <script src="{{ asset('js/app.js') }}"></script>
</html>
