<?php

session_start();

if(!isset($_SESSION['registrationSuccess']))
{
    header('Location: index.php');
    exit();
}
else
{
    unset($_SESSION['registrationSuccess']);
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    
    <meta charset="utf-8"/>
    <title>Elektroniczny zielnik - twój zielnik w internecie!</title>
    <meta name="description" content="Wszystko czego chciałbyś się dowiedzieć o ziołach i ich sposobie przyrządzania. Zapraszam do przeglądania!"/>
    <meta name="keywords" content="zielnik, zdrowie, fit, przyrządzanie"/>
    <meta name="author" content="Jakub Pałka"/>
    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="css/main.css"/>
    
    
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Lobster|Ubuntu:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">

</head>

<body>
    
    <header id="top">
    
        <img src="img/ziola.jpg"/> 
        
        <nav class="nav">
            <ul class="menu">
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="zielniklogowanie.php">Zielnik</a></li>
                <li><a href="omnie.php">O mnie</a></li>
                <li><a href="kontakt.php">Kontakt</a></li>                
            </ul>        
        </nav>

        <div class="userinfo">
            
            <?php
            
                if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true)
                {
                    echo '<p>User : '.$_SESSION['sql_login'];
                }
                else
                {
                    echo "<p>User: Guest</p>";
                }
            
            ?>        
        
        </div>
        
        <div style="clear: both"></div>
            
    </header>
    
    <div class="container">
        
        <main>
        
            <article>
                
                <section>
                                    
                    <div class="leftside">
                        
                        Dziękujemy za rejestrację w serwisie! 
                        Możesz już zalogować się na swoje konto.
                        <br />
                        <a class="registButton" href="zielniklogowanie.php">Zaloguj się na konto!</a>
                        
                    </div>
                    
                    <div style="clear: both"></div>
                    
                </section>
                
            </article>
            
        </main>
            
    </div>
    
    <footer>
        
        <div class="info">
            Wszelkie prawa zastrzeżone &copy; Dziękuję za wizytę.
        </div>
        
    </footer>
    
</body>
    
</html>