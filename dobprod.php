<!DOCTYPE html>
    <html lang="ru">

    <?php 
        require_once("includes/connection.php"); 
    ?>

    <head>

        <title>Добавление контента</title>
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
                unset($_SESSION['loginadm']);
                echo "<script>self.location='products.php';</script>";
            };
        };
        if (isset($_SESSION['loginadm']))
        {
            echo '<h2 align="right">Вы зашли как '.$_SESSION["loginadm"].' (Администратор)</h2>';
            echo'<h2 align="right"><a href="products.php">Вернуться на страницу продукции</a></h2>';
            echo '<h2 align="right"><a href="dobprod.php?exit=1">Выход</a></h2>';
            echo '<hr size="5" color="blue">';
            echo '
                <form method="POST" enctype="multipart/form-data">
                    Добавить продукт:
                    <br> тип: <br>
                    <input type="text" required name="type" placeholder="тип продукта">
                    <br> наименование продукта: <br>
                    <input type="text" required name="name" placeholder="наименование продукта"> 
                    <br> краткое описание: <br>
                    <input type="text" required name="opisanie" placeholder="краткое описание"> 
                    <br> производитель: <br>
                    <input type="text" required name="proizvoditel" placeholder="производитель"> 
                    <br> цена: <br>
                    <input type="text" required name="price" placeholder="цена"> 
                    <br> фотография продукта: <br>
                    <input type="file" required name="filename"> 
                    <br><br>
                    <input type="submit" name="send" value="Отправить">
                </form>
            ';
        }
        else
        {
            echo '<h1>Вам не хватает прав для добавления продукции, обратитесь в тех. поддержку!</h1>';
        };
        $types = array('image/gif', 'image/png', 'image/jpeg');
        if(isset($_POST['send']))
        {
            if(!mysqli_num_rows(mysqli_query($con,"SELECT id FROM products WHERE name = '".$_POST["name"]."'")))
            {
                if (in_array($_FILES["filename"]["type"], $types))
                {
                    $result1 = mysqli_query($con, "INSERT INTO products (type, name, opisanie, proizvoditel, price, file) VALUES ('".$_POST["type"]."','".$_POST["name"]."','".$_POST["opisanie"]."','".$_POST["proizvoditel"]."','".$_POST["price"]."','".$_FILES["filename"]["name"]."')");
                    $path = pathinfo($_FILES["filename"]["name"]);
                    $id = mysqli_fetch_array(mysqli_query($con, "SELECT id FROM products WHERE name='".$_POST["name"]."'"));
                    $put = $id["id"].'.'.$path["extension"];
                    $result2 = mysqli_query($con, "UPDATE products SET file = '$put' WHERE id = '".$id["id"]."'");
                    if (($result2 == true) && ($result1 == true) && (move_uploaded_file($_FILES["filename"]["tmp_name"], 'files/'.$id["id"].'.'.$path["extension"])))
                    {
                        $crtabr = 'productr_'.$id["id"];
                        $crtabo = 'producto_'.$id["id"];
                        $sql1 = "DROP TABLE `my_db`.`$crtabr`";
                        $sql2 = "CREATE TABLE `my_db`.`$crtabr` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `userid` INT(11) NOT NULL , `rating` INT(11) NOT NULL , `time` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
                        $sql3 = "DROP TABLE `my_db`.`$crtabo`";
                        $sql4 = "CREATE TABLE `my_db`.`$crtabo` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `userid` INT(11) NOT NULL , `comment` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `time` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
                        if (($con->query($sql2) == TRUE) && ($con->query($sql4) == TRUE))
                        {
                            echo "<b style='color:#00FF00'>Данные успешно загружены на сервер!</b>";
                        } 
                        else 
                        {
                            echo "<b style='color:#FF0000'>Ошибка создания таблицы: ".$con->error."</b>";
                        }                        
                    }
                    else
                    {
                        echo "<b style='color:#FF0000'>Произошла ошибка при загрузке данных на сервер! Обратитесь в тех. поддержку!</b>";
                    };
                }
                else
                {
                    echo "<b style='color:#FF0000'>Неверный формат файла! Убедитесь, что Вы загрузили файл в формате картинки!</b>";
                };
            };
        }
        else
        {
            echo "<b style='color:#FF0000'>Товар с таким названием уже существует!</b>";
        };
    ?>


</html>