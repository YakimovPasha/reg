<body>

    <div class="container mlogin">
    <div id="login">
    <h1>Вход</h1>
    <form action="" id="loginform" method="post"name="loginform">
        <p><label for="user_login">E-mail или login<br>
        <input class="input" id="email" name="email" size="36" type="text" value=""></label></p>
        <p><label for="user_pass">Пароль<br>
        <input class="input" id="password" name="password" size="36" type="password" value=""></label></p> 
        <p class="submit"><input class="button" name="login"type= "submit" value="Войти"></p>
        <p class="regtext">Еще не зарегистрированы?<a href= "register.php">Зарегистрироваться</a>!</p>
    </form>
    </div>
    </div>

    <?php 
        include("includes/footer.php"); 
    ?>

</body>