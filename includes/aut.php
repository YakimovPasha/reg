<?php
$email_p = 0;
$password_p = 0;
if(isset($_POST["email"]))
{
    if(preg_match("/^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$/", $_POST["email"]))
    {
        if(mysqli_num_rows(mysqli_query($con,"SELECT id FROM users WHERE email = '".$_POST["email"]."'")))
        {
        $email_p = 1;
        }
        else
        {
        echo "<b style='color:#FF0000'>Указанный E-mail не зарегистрирован в системе!</b>";
        }
    }
    else
    {
        if(preg_match("/^[a-zA-Z]{1}[a-zA-Z0-9_]{5,}$/", $_POST["email"]))
        {
            if(mysqli_num_rows(mysqli_query($con,"SELECT id From users WHERE login='".$_POST["email"]."'")))
            {
            $email_p = 1;
            }
            else
            {
            echo "<b style='color:#FF0000'>Указанный логин не зарегистрирован в системе!</b>";
            }
        }
        else
        {
            echo "<b style='color:#FF0000'>E-mail или логин введён неверно!</b>";
        }
    };
};


if(isset($_POST["password"]))
{
    if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,155}$/", $_POST["password"]))
    {
        $p = mysqli_fetch_array(mysqli_query($con, "SELECT password FROM users WHERE email='".$_POST["email"]."'"));
        if($p['password'] == $_POST["password"])
        {
            $password_p = 1;
            $pr = mysqli_fetch_array(mysqli_query($con, "SELECT admin FROM users WHERE email='".$_POST["email"]."'"));
            if($pr['admin'] == 1)
            {
                $admin_p = 1;
            };
        }
        else
        {
        echo "<b style='color:#FF0000'>Пароли введён неверно!</b>";
        }
    }
    else
    {
        echo "<b style='color:#FF0000'>Введённый пароль не соответствует требованиям! (Пароль должен содержать строчные и заглавные английские буквы, цифры и спец. сиволы, также длина должна быть не менее 8 символов.)</b>";
    }
}
else
{
    if(isset($_POST["password"]))
    {
        echo "<b style='color:#FF0000'>Введите пароль!</b>";
    }
}

if($email_p == 1 AND $password_p == 1)
{
    if($admin_p == 1)
    {
        $_SESSION["loginadm"] = $_POST["email"];
        echo "<script>self.location='products.php';</script>";
    }
    else
    {
        $_SESSION["login"] = $_POST["email"];
        echo "<script>self.location='products.php';</script>";
    }
};
?>