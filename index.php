<?php

session_start();

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
    <link rel="stylesheet" href="css\main.css"/>
    <link rel="stylesheet" href="css/fontello.css"/>
    
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
        
        <div style="clear: both;"></div>
            
    </header>
        
    <div class="container">
        
        <main>
        
            <article>
                
                <section>
                                    
                    <div class="leftside">
                        
                        <header>
                        <h1>Witaj w elektronicznym zielniku!</h1>
                            <p>Zawitałeś tutaj przez przypadek? <br /> A może szukasz zapomnianych receptur zielarskich? Dobrze trafiłeś! <br /></p>
                        </header>
                        
                        <div class="opis">
                            
                            <img src="img/lecznicze1.jpg"/>
                           
                        <br />
                        <p>Staram się dodawać sprawdzone i najlepsze receptury wprost od himalajskich mnichów u których szkoliłem swoje umięjętności przez dwa lata. Te wyspecjalizowane przepisy zawierają wiele rzadkich i niekiedy niedostępnych gatunków ziół, ale nie zrażaj się! Każdą z tych roślin udało mi się wychodować w ogródku. To naprawdę niesamowite, jak wiele możemy w tej materii zrobić sami. A więc do dzieła, zarejestruj się i przejdź do zakładki "Zielnik" aby rozpocząć swoją przygodę z niesamowitymi eliksirami prosto z twojego ogródka.</p>
                        
                        </div>
                        
                    </div>
                    
                    <div class="rightside">
                    
                        <div class="entry">
                        
                            <h5>Ostatnio dodane:</h5>
                            <ol class="entrylist">
                                <li><a href="#">Eliksir życia</a></li>
                            </ol>
                            
                        </div>
                        
                        <div class="ad">
                        
                            
                            
                        </div>
                        
                    </div>
                    
                    <div style="clear: both"></div>
                    
                </section>
                
            </article>
            
        </main>
            
    </div>
    
    <?php
    
        if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true)
        {
            if(isset($_SESSION['sql_adminright']) && $_SESSION['sql_adminright']==true)
            {
                echo '<label class="fixedbuttonAdd">
                    <a href="zielnikdodaj.php"><div title="Dodaj recepturę" class="the-icons span3"><i class="demo-icon icon-plus-circled"></i></div></a>
                    </label>

                    <label class="fixedbuttonLogout">
                    <a href="logout.php"><div title="Wyloguj się" class="the-icons span3"><i class="demo-icon icon-link-ext-alt"></i></div></a>  
                    </label>';
            }
            else
            {
                echo '<label class="fixedbuttonLogout">
                <a href="logout.php"><div title="Wyloguj się" class="the-icons span3"><i class="demo-icon icon-link-ext-alt"></i></div></a>  
                </label>';
            }
        }
    
    ?>
    
    <footer>
        
        <div class="info">
            Wszelkie prawa zastrzeżone &copy; Dziękuję za wizytę.
        </div>
        
        <div class="userbuttons">
        
        </div>
        
                    
    </footer>
    
</body>
    
</html>