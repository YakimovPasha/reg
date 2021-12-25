<!DOCTYPE html>
    <html lang="ru">

    <?php 
        require_once("includes/connection.php"); 
    ?>

    <head>

        <title>Авторизация</title>
        <?php 
            include("includes/header.php"); 
        ?>

    </head>
    
    <?php
        session_start();
        if (isset($_GET["exit"]))
        {
            if ($_GET["exit"] == "1")
            {
                session_unset();
            };
        }
        if (isset($_SESSION['login']) || isset($_SESSION['loginadm']))
        {
            echo "<script>self.location='products.php';</script>";
        }
        else
        {
            require_once("includes/connection.php");
            include("includes/header.php");	
            include("includes/aut.php");
            include("includes/razmaut.php");
        }
    ?>


</html>