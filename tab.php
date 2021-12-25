<!DOCTYPE html>

    <html lang="ru">

    <?php 
        require_once("includes/connection.php"); 
    ?>

    <head>

        <title>Продукция</title>
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
                    echo "<script>self.location='tab.php';</script>";
                };
            }
        ?>

        <?php
            if(!isset($_SESSION["loginadm"]) && !isset($_SESSION["login"]))
            {
                echo'<h2 align="right"><a href="login.php">Авторизоваться</a></h2>';
                echo'<h2 align="right"><a href="register.php">Зарегистрироваться</a></h2>';
                echo'<h2 align="right"><a href="products.php">Карточки товаров</a></h2>';
            }
            if(isset($_SESSION["loginadm"]))
            {
                echo '<h2 align="right">Вы зашли как '.$_SESSION["loginadm"].' (Администратор)</h2>';
                echo'<h2 align="right"><a href="dobprod.php">Добавить продукт</a></h2>';
                echo'<h2 align="right"><a href="products.php">Карточки товаров</a></h2>';
                echo '<h2 align="right"><a href="tab.php?exit=1">Выход</a></h2>';
            }
            if(isset($_SESSION["login"]))
            {
                echo '<h2 align="right">Вы зашли как '.$_SESSION["login"].'</h2>';
                echo'<h2 align="right"><a href="products.php">Карточки товаров</a></h2>';
                echo '<h2 align="right"><a href="tab.php?exit=1">Выход</a></h2>';
            }
            echo '<hr size="5" color="blue">';
        ?>

        <?php
            $result = $con->query("SELECT name, id FROM `products`");
        ?>

        <form method='POST'>
            <h1>Выберете фильтр:</h1><br>
            <select name ='filter'>
                <option>Выберите фильтр</option>
                <option value="tip">Тип</option>
                <option value="pr">Производитель</option>
            </select>
            <input type="text" required name="tippr" placeholder="тип/производитель">
            <input type='submit' name='filterb' value='Выбрать'>
        </form>

        <form method='POST'>
            <input type='submit' name='filterbs' value='Сбросить фильтр'><br><br>
        </form>

        <form method='POST'>
            <h1>Выберете метод сортировки:</h1><br>
            <select name ='sortm'>
                <option>Выберите метод сортировки</option>
                <option value="che">По цене</option>
                <option value="reit">По рейтингу</option>
            </select>
            <select name ='sorts'>
                <option>Выберите способ сортировки</option>
                <option value="vozr">По возрастанию</option>
                <option value="ybblv">По убыванию</option>
            </select>
            <input type='submit' name='sortb' value='Выбрать'>
        </form>

        <form method='POST'>
            <input type='submit' name='sortbs' value='Сбросить сортировку'><br><br>
        </form>

        <form method='POST'>
            <h1>Выберете количество отображаемых товаров на странице:</h1><br>
            <select name ='pag'>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
            <input type='submit' name='pagb' value='Выбрать'>
        </form>

        <?php
        if(isset($_POST["filterb"]))
        {
            $_SESSION["filter"] = $_POST["filter"];
            $_SESSION["tippr"] = $_POST["tippr"];
            $_SESSION["filterb"] = $_POST["filterb"];
        };
        if(isset($_POST["sortb"]))
        {
            $_SESSION["sortm"] = $_POST["sortm"];
            $_SESSION["sorts"] = $_POST["sorts"];
            $_SESSION["sortb"] = $_POST["sortb"];
        };
        if(isset($_POST["filterbs"]))
        {
            unset($_SESSION["filter"]);
            unset($_SESSION["tippr"]);
            unset($_SESSION["filterb"]);
        };
        if(isset($_POST["sortbs"]))
        {
            unset($_SESSION["sortm"]);
            unset($_SESSION["sorts"]);
            unset($_SESSION["sortb"]);
        };
        if(isset($_POST["pagb"]))
        {
            $_SESSION["pag"] = $_POST["pag"];
            $_SESSION["pagb"] = $_POST["pagb"];
        };
        if(!isset($_SESSION["pagb"]))
        {
            $_SESSION["pag"] = 5;
        };
        echo "На странице показано: ".$_SESSION["pag"]." товаров.<br><br>";
        $tab1 = $con->query("SELECT * FROM `products`");
        $k = 0;
        $count_pages = 0;
        while($row1 = $tab1->fetch_assoc())
        {
            if($k < $_SESSION["pag"])
            {
                $k = $k + 1;
            };
            if($k == ($_SESSION["pag"] - 1))
            {
                $k = 0;
                $count_pages = $count_pages + 1;
            };            
        };
        if($k != 0)
        {
            $count_pages = $count_pages + 1;
        };
        $active = 1;
        $count_show_pages = 10;
        $url = "tab.php";
        $url_page = "tab.php?page=";
        if ($count_pages > 1) 
        { 
            $left = $active - 1;
            $right = $count_pages - $active;
            if ($left < floor($count_show_pages / 2)) 
            {
                $start = 1;
            }
            else 
            {
                $start = $active - floor($count_show_pages / 2);
            };
            $end = $start + $count_show_pages - 1;
            if ($end > $count_pages) 
            {
                $start -= ($end - $count_pages);
                $end = $count_pages;
                if ($start < 1) 
                {
                    $start = 1;
                };
            };
        if(isset($_GET["page"]))
        {
            $active = $_GET["page"];
        };
        ?>

        <div>
            <span>Страницы: </span>
            <?php if ($active != 1) { ?>
            <a href="<?=$url?>" title="Первая страница">&lt;&lt;&lt;</a>
            <a href="<?php if ($active == 2) { ?><?=$url?><?php } else { ?><?=$url_page.($active - 1)?><?php } ?>" title="Предыдущая страница">&lt;</a>
            <?php } ?>
            <?php for ($i = $start; $i <= $end; $i++) { ?>
            <?php if ($i == $active) { ?><span><?=$i?></span><?php } else { ?><a href="<?php if ($i == 1) { ?><?=$url?><?php } else { ?><?=$url_page.$i?><?php } ?>"><?=$i?></a><?php } ?>
            <?php } ?>
            <?php if ($active != $count_pages) { ?>
            <a href="<?=$url_page.($active + 1)?>" title="Следующая страница">&gt;</a>
            <a href="<?=$url_page.$count_pages?>" title="Последняя страница">&gt;&gt;&gt;</a>
            <?php } ?>
        </div>
        <?php } ?>

        <?php
        if(isset($_SESSION["filterb"]))
        {
            $fl1 = 0;
            if($_SESSION["filter"] == 'tip')
            {
                $sravn1 = "WHERE type like ";
                $fl1 = 1;
                echo "<p>Применён фильтр: тип ".$_SESSION["tippr"].".</p>";
            };
            if($_SESSION["filter"] == 'pr')
            {
                $sravn1 = "WHERE proizvoditel like ";
                $fl1 = 1;
                echo "<p>Применён фильтр: производитель ".$_SESSION["tippr"].".</p>";
            };
            if($fl1 == 1)
            {
                $sravn =  $sravn1."'".$_SESSION["tippr"]."'";
            }
            else
            {
                echo "<p style='color:#FF0000'>Выберете фильтр!</p>";
                $sravn = " ";
            };
        }
        else
        {
            $sravn = " ";
        };
        if(isset($_SESSION["sortb"]))
        {
            $fl2=0;
            if($_SESSION["sortm"] == 'che')
            {
                $sort1 = "ORDER BY price ";
                $fl2 = 1;
                if($_SESSION["sorts"] == 'ybblv')
                {
                    $sort = $sort1."DESC";
                    echo "<p>Отсортировано: по цене по убыванию.</p>";
                }
                else
                {
                    $sort = $sort1."ASC";
                    echo "<p>Отсортировано: по цене по возрастанию.</p>";
                };
            };
            if($_SESSION["sortm"] == 'reit')
            {
                $sort1 = "ORDER BY rating ";
                $fl2 = 1;
                if($_SESSION["sorts"] == 'vozr')
                {
                    $sort = $sort1."ASC";
                    echo "<p>Отсортировано: по рейтингу по возрастанию.</p>";
                }
                else
                {
                    $sort = $sort1."DESC";
                    echo "<p>Отсортировано: по рейтигну по убыванию.</p>";
                };
            };
            if($fl2 == 0)
            {
                echo "<p style='color:#FF0000'>Выберете метод сортировки!</p>";
                $sort = " ";
            };
        }
        else
        {
            $sort = " ";
        };
        echo "<table border 1><tr><td>Наименование продукта</td><td>Тип продукта</td><td>Производитель</td><td>Цена</td><td>Рейтинг (из 5 баллов)</td><td>Описание</td></tr>";
        $tab1 = $con->query("SELECT * FROM `products` ".$sravn." ".$sort);
        $sch = 0;
        while($row1 = $tab1->fetch_assoc())
        {
            $sch = $sch + 1;
            $sch1 = $active * $_SESSION["pag"];
            $sch2 = ($active - 1) * $_SESSION["pag"];
            if(($sch <= $sch1) && ($sch > $sch2))
            {
                $id = mysqli_fetch_array(mysqli_query($con, "SELECT id FROM products WHERE name='".$row1['name']."'"));
                $ssbllka = 'products.php?product='.$id["id"].'&productb=Выбрать';
                echo "<tr><td><a href='".$ssbllka."'>".$row1['name']."</a></td><td>".$row1['type']."</td><td>".$row1['proizvoditel']."</td><td>".$row1['price']."</td><td>".$row1['rating']."</td><td>".$row1['opisanie']."</td></tr>";
            };
        };
        echo "</table>";
        ?>

        <?php 
            include("includes/footer.php"); 
        ?>

    </body>


</html>