<?php
$email_p = 0;
$login_p = 0;
$password_p = 0;
if(isset($_POST["email"]))
{
    if(preg_match("/^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$/", $_POST["email"]))
    {
        if(!mysqli_num_rows(mysqli_query($con,"SELECT id FROM users WHERE email = '".$_POST["email"]."'")))
        {
            $email_p = 1;
        }
        else
        {
            echo "<b style='color:#FF0000'>Указанный E-mail уже зарегистрирован в системе!</b>";
        };
    }
    else
    {
        echo "<b style='color:#FF0000'>E-mail введён неправильно!</b>";
    };
};

if(isset($_POST["login"]))
{
    if(preg_match("/^[a-zA-Z]{1}[a-zA-Z0-9_]{5,}$/", $_POST["login"]))
    {
        if(!mysqli_num_rows(mysqli_query($con,"SELECT id From users WHERE login='".$_POST["login"]."'")))
        {
            $login_p = 1;
        }
        else
        {
            echo "<b style='color:#FF0000'>Указанный логин уже зарегистрирован в системе!</b>";
        };
    }
    else
    {
        echo "<b style='color:#FF0000'>Введённый логин не соответствует требованиям!</b>";
    };
};

if(isset($_POST["password"]) && isset($_POST["password1"]))
{
    if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,155}$/", $_POST["password"]))
    {
    if($_POST["password"] == $_POST["password1"])
    {
        $password_p = 1;
    }
    else
    {
        echo "<b style='color:#FF0000'>Пароли не совпадают!</b>";
    };
    }
    else
    {
    echo "<b style='color:#FF0000'>Пароль не удовлетворяет требованиям! (Пароль должен содержать строчные и заглавные английские буквы, цифры и спец. сиволы, также длина должна быть не менее 8 символов.)</b>";
    };
}
else
{
    if(isset($_POST["password"]) && !isset($_POST["password1"]))
    {
    echo "<b style='color:#FF0000'>Введите пароль повторно!</b>";
    }; 
};

if($email_p == 1 && $login_p == 1 && $password_p == 1)
{
    $result = mysqli_query($con, "INSERT INTO users (email, login, password) VALUES ('".$_POST["email"]."','".$_POST["login"]."','".$_POST["password"]."')");
    if ($result == false)
    {
        echo "<b style='color:#FF0000'>Ошибка выполнения запроса взаимодействия с БД!</b>";
    }
    else
    {
        echo "<b style='color:#00FF00'>Регистрация завершена успешно!</b>";
    };
};
?>