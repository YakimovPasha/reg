<!DOCTYPE html>

    <html lang="ru">

    <?php 
        require_once("includes/connection.php"); 
    ?>


    <head>

        <title>Карточка товара</title>
        <?php 
            include("includes/header.php"); 
        ?>

    </head>


    <body>
        
        <?php 
            session_start();
            if (isset($_GET["exit"]))
            {
                if ($_GET["exit"] == "1")
                {
                    unset($_SESSION['login']);
                    unset($_SESSION['loginadm']);
                    echo "<script>self.location='products.php';</script>";
                };
            }
        ?>

        <?php
            if(!isset($_SESSION["loginadm"]) && !isset($_SESSION["login"]))
            {
                echo'<h2 align="right"><a href="login.php">Авторизоваться</a></h2>';
                echo'<h2 align="right"><a href="register.php">Зарегистрироваться</a></h2>';
                echo'<h2 align="right"><a href="tab.php">Список товаров</a></h2>';
            }
            if(isset($_SESSION["loginadm"]))
            {
                echo '<h2 align="right">Вы зашли как '.$_SESSION["loginadm"].' (Администратор)</h2>';
                echo'<h2 align="right"><a href="dobprod.php">Добавить продукт</a></h2>';
                echo'<h2 align="right"><a href="tab.php">Список товаров</a></h2>';
                echo '<h2 align="right"><a href="products.php?exit=1">Выход</a></h2>';
            }
            if(isset($_SESSION["login"]))
            {
                echo '<h2 align="right">Вы зашли как '.$_SESSION["login"].'</h2>';
                echo'<h2 align="right"><a href="tab.php">Список товаров</a></h2>';
                echo '<h2 align="right"><a href="products.php?exit=1">Выход</a></h2>';
            }
            echo '<hr size="5" color="blue">';
        ?>

        <?php
            $result = $con->query("SELECT name, id FROM `products`");
        ?>

        <center>
            <form method='GET'>
                <h1>Выберете продукт</h1><br>
                <select name ='product'>
                    <option disabled selected >Выберите продукт</option>
                    <?php 
                        foreach ($result as $resrow)
                        {
                            echo ("<option value=" .$resrow["id"] . ">" . $resrow["name"] . "</option>");
                        }
                    ?>
                </select>
                <input type='submit' name='productb' value='Выбрать'><br><br>
            </form>
        </center>

        <?php
            if(isset($_GET["productb"]))
            {
                $tab=mysqli_fetch_array(mysqli_query($con, "SELECT * FROM products WHERE id='".$_GET["product"]."'"));
            };
        ?>

        <?php
            if(isset($_GET["productb"])) echo "Название: ".$tab['name']."<br>";
                if(isset($_SESSION["loginadm"]) && isset($_GET["productb"]))
                {
                    echo'
                    <form method="POST" enctype="multipart/form-data">
                        Изменить наименование продукта:
                        <input type="text" required name="name" placeholder="наименование продукта">
                        <input type="submit" name="nameb" value="Отправить">
                    </form>
                    ';
                };
                if(isset($_POST["nameb"]))
                {
                    if (mysqli_query($con, "UPDATE products SET name = ('".$_POST["name"]."') WHERE id = '".$_GET["product"]."'") == true)
                    {
                        echo "<b style='color:#00FF00'>Данные успешно обновлены на сервере!</b><br>";
                    }
                    else
                    {
                        echo "<b style='color:#FF0000'>Произошла ошибка при загрузке данных на сервер! Обратитесь в тех. поддержку!</b><br>";
                    };
                };
            if(isset($_GET["productb"])) echo "Тип: ".$tab['type']."<br>";
                if(isset($_SESSION["loginadm"]) && isset($_GET["productb"]))
                {
                    echo'
                    <form method="POST" enctype="multipart/form-data">
                        Изменить тип продукта:
                        <input type="text" required name="type" placeholder="тип">
                        <input type="submit" name="typeb" value="Отправить">
                    </form>
                    ';
                };
                if(isset($_POST["typeb"]))
                {
                    if (mysqli_query($con, "UPDATE products SET type = ('".$_POST["type"]."') WHERE id = '".$_GET["product"]."'") == true)
                    {
                        echo "<b style='color:#00FF00'>Данные успешно обновлены на сервере!</b><br>";
                    }
                    else
                    {
                        echo "<b style='color:#FF0000'>Произошла ошибка при загрузке данных на сервер! Обратитесь в тех. поддержку!</b><br>";
                    };
                };
            if(isset($_GET["productb"])) echo "Краткое описание: ".$tab['opisanie']."<br>";
                if(isset($_SESSION["loginadm"]) && isset($_GET["productb"]))
                {
                    echo'
                    <form method="POST" enctype="multipart/form-data">
                        Изменить краткое описание:
                        <input type="text" required name="opisanie" placeholder="краткое описание">
                        <input type="submit" name="opisanieb" value="Отправить">
                    </form>
                    ';
                };
                if(isset($_POST["opisanieb"]))
                {
                    if (mysqli_query($con, "UPDATE products SET opisanie = ('".$_POST["opisanie"]."') WHERE id = '".$_GET["product"]."'") == true)
                    {
                        echo "<b style='color:#00FF00'>Данные успешно обновлены на сервере!</b><br>";
                    }
                    else
                    {
                        echo "<b style='color:#FF0000'>Произошла ошибка при загрузке данных на сервер! Обратитесь в тех. поддержку!</b><br>";
                    };
                };
            if(isset($_GET["productb"])) echo "Производитель: ".$tab['proizvoditel']."<br>";
                if(isset($_SESSION["loginadm"]) && isset($_GET["productb"]))
                {
                    echo'
                    <form method="POST" enctype="multipart/form-data">
                        Изменить наименование производителя:
                        <input type="text" required name="proizvoditel" placeholder="производитель">
                        <input type="submit" name="proizvoditelb" value="Отправить">
                    </form>
                    ';
                };
                if(isset($_POST["proizvoditelb"]))
                {
                    if (mysqli_query($con, "UPDATE products SET proizvoditel = ('".$_POST["proizvoditel"]."') WHERE id = '".$_GET["product"]."'") == true)
                    {
                        echo "<b style='color:#00FF00'>Данные успешно обновлены на сервере!</b><br>";
                    }
                    else
                    {
                        echo "<b style='color:#FF0000'>Произошла ошибка при загрузке данных на сервер! Обратитесь в тех. поддержку!</b><br>";
                    };
                };
            if(isset($_GET["productb"])) echo "Цена: ".$tab['price']."<br>";
                if(isset($_SESSION["loginadm"]) && isset($_GET["productb"]))
                {
                    echo'
                    <form method="POST" enctype="multipart/form-data">
                        Изменить цену:
                        <input type="text" required name="price" placeholder="цена">
                        <input type="submit" name="priceb" value="Отправить">
                    </form>
                    ';
                };
                if(isset($_POST["priceb"]))
                {
                    if (mysqli_query($con, "UPDATE products SET price = ('".$_POST["price"]."') WHERE id = '".$_GET["product"]."'") == true)
                    {
                        echo "<b style='color:#00FF00'>Данные успешно обновлены на сервере!</b><br>";
                    }
                    else
                    {
                        echo "<b style='color:#FF0000'>Произошла ошибка при загрузке данных на сервер! Обратитесь в тех. поддержку!</b><br>";
                    };
                };
            if(isset($_GET["productb"]))
            {
                $id = $_GET["product"];
                $tabr = 'productr_'.$id;
                $och = mysqli_fetch_array(mysqli_query($con, "SELECT AVG(rating) as avg FROM $tabr"));
                echo "Рейтинг: ".$och["avg"]."<br>";
                echo "<br>";
            }
            if(isset($_GET["productb"])) echo '<img src=files/'.$tab['file'].' style="width:500px"><br>';
                if(isset($_SESSION["loginadm"]) && isset($_GET["productb"]))
                {
                    echo'
                    <form method="POST" enctype="multipart/form-data">
                        Изменить фотографию продукта:
                        <input type="file" required name="filename"> 
                        <input type="submit" name="filenameb" value="Отправить">
                    </form>
                    ';
                };
                if(isset($_POST["filenameb"]))
                {
                    $types = array('image/gif', 'image/png', 'image/jpeg');
                    if (in_array($_FILES["filename"]["type"], $types))
                    {
                        unlink('files/'.$tab['file']);
                        if (move_uploaded_file($_FILES["filename"]["tmp_name"], 'files/'.$tab['file']))
                        {
                            echo "<b style='color:#00FF00'>Данные успешно обновлены на сервере!</b><br>";
                        }
                        else
                        {
                            echo "<b style='color:#FF0000'>Произошла ошибка при загрузке данных на сервер! Обратитесь в тех. поддержку!</b><br>";
                        };
                    }
                    else
                    {
                        echo "<b style='color:#FF0000'>Неверный формат файла! Убедитесь, что Вы загрузили файл в формате картинки!</b>";
                    };
                };
                echo "<br>";
        ?>

        <?php 
            if(isset($_GET["productb"]))
            {
                if(!isset($_SESSION["loginadm"])&&!isset($_SESSION["login"]))
                {
                    echo'Авторизуйтесь и Вы сможете оценить товар и оставить свой комментарий!;)';
                };
                if(isset($_SESSION["loginadm"])||isset($_SESSION["login"]))
                {
                    echo'
                    <form method="POST">
                        Оцените товар:<br>
							<select required name ="rating">
								<option value=1> 1 </option>
								<option value=2> 2 </option>
								<option value=3> 3 </option>
								<option value=4> 4 </option>
								<option value=5> 5 </option>
							</select>
                        <input type="submit" name="ratingb" value="Оценить!">
					</form>
                    ';
                    if(isset($_SESSION["loginadm"]))
                    {
                        $userid = mysqli_fetch_array(mysqli_query($con, "SELECT id  FROM users WHERE email = '".$_SESSION["loginadm"]."'"));
                    };
                    if(isset($_SESSION["login"]))
                    {
                        $userid = mysqli_fetch_array(mysqli_query($con, "SELECT id  FROM users WHERE email = '".$_SESSION["login"]."'"));
                    };
                    $id = $_GET["product"];
                    $tabr = 'productr_'.$id;
                    $tabo = 'producto_'.$id;
                    if(mysqli_num_rows(mysqli_query($con, "SELECT id  FROM $tabr WHERE userid = '".$userid["id"]."'")))
                    {
                        if(isset($_POST["ratingb"]))
                        {
                            $rati1 = mysqli_query($con, "UPDATE $tabr SET rating = ('".$_POST["rating"]."') WHERE userid = '".$userid["id"]."'");
                            $och = mysqli_fetch_array(mysqli_query($con, "SELECT AVG(rating) as avg FROM $tabr"));
                            $rati2 = mysqli_query($con, "UPDATE products SET rating = ('".$och['avg']."') WHERE id = $id");
                        };
                        $ratinguser = mysqli_fetch_array(mysqli_query($con, "SELECT rating  FROM $tabr WHERE userid = '".$userid["id"]."'"));
                        echo "Вы оценили этот продукт: ".$ratinguser["rating"];
                        echo "<br>";
                    }
                    else
                    {
                        if(isset($_POST["ratingb"]))
                        {
                            $rati1 = mysqli_query($con, "INSERT INTO $tabr (userid, rating, time) VALUES ('".$userid["id"]."', '".$_POST["rating"]."', NOW())");
                            $och = mysqli_fetch_array(mysqli_query($con, "SELECT AVG(rating) as avg FROM $tabr"));
                            $rati2 = mysqli_query($con, "UPDATE products SET rating = ('".$och['avg']."') WHERE id = $id");
                        };
                    }
                    echo "
                    <br>Ваш комментарий:
                    <form method='POST'>
                    <input type='text' name='comment' placeholder='Ваш комментарий' id='comment'> 
                    <input type='submit' name='commentb' value='Отправить'><br>
                    ";
                    if(isset($_POST["commentb"]) && isset($_POST["comment"]))
                    {
                        if(isset($_SESSION["usercomm"]))
                        {
                            if($_SESSION["usercomm"]!=$_POST["comment"])
                            {
                                $comme = mysqli_query($con, "INSERT INTO $tabo (userid, comment, time) VALUES ('".$userid["id"]."', '".$_POST["comment"]."', NOW())");
                                $_SESSION["usercomm"] = $_POST["comment"];
                            };                                                      
                        }
                        else
                        {
                            $comme = mysqli_query($con, "INSERT INTO $tabo (userid, comment, time) VALUES ('".$userid["id"]."', '".$_POST["comment"]."', NOW())");
                            $_SESSION["usercomm"] = $_POST["comment"];
                        };
                    };
                };
                echo'<h2>Комментарии:</h2>';
                $id = $_GET["product"];
                $tabo = 'producto_'.$id;
                $result = $con->query("SELECT comment FROM `$tabo`");
                foreach ($result as $resrow)
                {
                    echo "<b>".$resrow["comment"]."<b>";
                    echo "<br><br>";
                }
            };
        ?>
    
        <?php 
            if(isset($_GET["productb"]))
            {
                if(isset($_SESSION["loginadm"]))
                {
                    echo'
                    <form method="POST">
                        <h2>Работа с карточкой товара:</h2>
                        <button style="color:#FF0000" type="submit" name="delete" value="delete">Удалить</button>
                        <button style="color:#FFD700" type="submit" name="arhiv" value="arhiv">Архивировать</button>
                    </form>
                    ';
                };
                if(isset($_POST["delete"])||isset($_POST["delete1"]))
                {
                    echo'<b style="color:#FF0000">Вы уверены, что хотите удалить карточку товара?</b>';
                    echo'
                    <form method="POST">
                        <button style="color:#FF0000" type="submit" name="delete1" value="delete1">Удалить</button>
                        <button style="color:#00FF00" type="submit" name="otm" value="otm">Отмена</button>
                    </form>
                    ';
                    if(isset($_POST["delete1"]))
                    {
                        $crtabr = 'productr_'.$_GET["product"];
                        $crtabo = 'producto_'.$_GET["product"];
                        $idy = $_GET["product"];
                        $sql1 = "DROP TABLE `my_db`.`$crtabr`";
                        $sql2 = "DROP TABLE `my_db`.`$crtabo`";
                        $sql3 = "DELETE FROM `products` WHERE `products`.`id` = $idy";
                        unlink('files/'.$tab['file']);
                        if (($con->query($sql1) == TRUE) && ($con->query($sql2) == TRUE) && ($con->query($sql3) == TRUE))
                        {
                            echo'<b style="color:#00FF00">Карточка товара удалена успешно!</b>';
                            unset($_POST["delete"]);
                            unset($_POST["delete1"]);
                        }
                        else
                        {
                            echo'<b style="color:#FF0000">Произошла ошибка при выполнении запроса! Обратитесь в тех. поддержку!</b>';
                        };
                    };
                    if(isset($_POST["otm"]))
                    {
                        unset($_POST["delete"]);
                        unset($_POST["otm"]);
                    }
                };
            };
        ?>

        <?php 
            include("includes/footer.php"); 
        ?>

    </body>


</html>