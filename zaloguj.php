<?php

session_start();


if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
{
    header('Location: zielniklogowanie.php');
    exit();
}

require_once "mysqlconnect.php";

mysqli_report(MYSQLI_REPORT_STRICT);

$login = $_POST['login'];
$haslo = $_POST['haslo'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8");

try
{
    $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name); 
    
    if($polaczenie->connect_errno!=0)
    {
        throw new Exception(mysqli_connect_errno());
    }
    else
    {
        $result = $polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE login='%s'", mysqli_real_escape_string($polaczenie,$login)));
        
        $resultFound = $result->num_rows;
        
        if($resultFound == 1)
        {
            $userData = $result->fetch_assoc();
            
            $_SESSION['zalogowany'] = true;
            $_SESSION['sql_login'] = $userData['login'];
            $_SESSION['sql_adminright'] = $userData['adminright'];
            $_SESSION['sql_email'] = $userData['email'];
            
            unset($_SESSION['blad']);
            $result->close();
            header('Location: zielnik.php');
            exit();
        }
        else
        {
            $_SESSION['blad'] = '<span style="color:red">Nieprawidlowy login lub haslo!</span>';
            
            header('Location: zielniklogowanie.php');
        }
        
    }   
    
    $polaczenie->close();
}
catch(Exception $e)
{
    echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
}

?>
