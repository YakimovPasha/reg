<!DOCTYPE html>

    <html lang="ru">

    <?php 
        require_once("includes/connection.php"); 
    ?>


    <head>

        <title>Регистрация</title>
        <?php 
            include("includes/header.php"); 
        ?>

    </head>


    <?php
        include("includes/reg.php")
    ?>

    <?php 
        if (!empty($message)) 
        {
            echo $message;
        }
    ?>


    <body>
        
        <?php
            if (isset($_SESSION['login']) || isset($_SESSION['loginadm']))
            {
                echo "<script>self.location='products.php';</script>";
            }
            else
            {
                echo'
                <div class="container mregister">
                <div id="login">
                <h1>Регистрация</h1>
                <form action="register.php" id="registerform" method="post" name="registerform">
                    <p><label for="user_login">E-mail<br>
                    <input class="input" id="email" name="email" size="32" type="email" value=""></label></p>
                    <p><label for="user_pass">Login<br>
                    <input class="input" id="login" name="login" size="32" type="text" value=""></label></p>
                    <p><label for="user_pass">Пароль<br>
                    <input class="input" id="password" name="password" size="32" type="password" value=""></label></p>
                    <p><label for="user_pass">Пароль повторно<br>
                    <input class="input" id="password1" name="password1" size="32" type="password" value=""></label></p>
                    <p class="submit"><input class="button" id="register" name= "register" type="submit" value="Зарегистрироваться"></p>
                    <p class="regtext">Уже зарегистрированы? <a href= "login.php">Войти в систему</a>!</p>
                </form>
                </div>
                </div>
                ';
            }
        ?>

        <?php 
            include("includes/footer.php"); 
        ?>

    </body>


</html>