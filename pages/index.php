<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="css\login.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <script src="js/axios.min.js" charset="utf-8"></script>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="//cdn.rawgit.com/placemarker/jQuery-MD5/master/jquery.md5.js"></script>
    
  </head>
  <body>
    <div class="login-box">
        <div id="app">
            <form>
                <h1>Login</h1>

                
                <div class="textbox">
                    <i class="fas fa-user"></i>
                    <input v-model="contact.email" type="text"
                         placeholder="Username" id="email">
                </div>

                <span class="alert">{{error.email}}</span></br>
                <span class="alert">{{error.password}}</span>

                <div class="textbox">
                    <i class="fas fa-lock"></i>
                    <input v-model="contact.password" type="password"
                         placeholder="Password" id="password">
                </div>

                <input v-on:click="send"  type="button" class="btn" value="Sign in">
            </form>
        </div>
    </div>
    <script src="js/vue-login.js" charset="utf-8"></script>
  </body>
</html>