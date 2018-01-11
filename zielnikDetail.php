<?php

session_start();

if(!isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'])==false)
{
    header('Location: zielnikrejestracja.php');
    exit();
}
elseif((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==false))
{
    header('Location: zielniklogowanie.php');
    exit();
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
    <link rel="stylesheet" href="css/detailStyle.css"/>
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
                <li><a href="zielnik.php">Zielnik</a></li>
                <li><a href="przepisy.php">Przepisy</a></li>
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
                            
                            <?php
                                
                                    if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
                                    {
                                        require_once "mysqlconnect.php";

                                        mysqli_report(MYSQLI_REPORT_STRICT);

                                        try
                                        {
                                            $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name); 

                                            if($polaczenie->connect_errno!=0)
                                            {
                                                throw new Exception(mysqli_connect_errno());
                                            }
                                            else
                                            {
                                                $result = $polaczenie->query(sprintf('SELECT * FROM receptury WHERE  id='.$_SESSION['idDetail'].'', mysqli_real_escape_string($polaczenie,$_SESSION['sql_login'])));

                                                $resultFound = $result->num_rows;


                                                

                                                while($row = $result->fetch_assoc())
                                                {

                                                    echo '<div class="recipy" id="'.$row['name'].'">
                                                        <h1 class="recipyTextH">'.$row['name'].'</h1>
                                                        <img class="recipyImage" src="img/'.$row['image'].'" />
                                                        <div class="recipyText">
                                                        <p>'.$row['description'].' </p>
                                                        <div style="clear: both;"></div>
                                                        </div>
                                                        <br />
                                                        <p class="recipeTextP" style="font-size: 22px; color: #deeade;">Szczegółowy opis:</p>
                                                        <p class="recipeTextP">'.$row['recipe'].' </p>
                                                        </div>';
                                                    break;
                                                }

                                                unset($_SESSION['blad']);
                                                $result->close();
                                            }   

                                            $polaczenie->close();
                                        }
                                        catch(Exception $e)
                                        {
                                            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
                                        }
                                    }
                                     else
                                    {
                                        echo '<h5 style="font-size: 12px;">Aby zobaczyć <a href="zielniklogowanie.php" style="text-decoration: none; color: #3e3e3e;">zaloguj</a> się!</h5>';
                                    } 
                                                     
                                ?>
                            
                            
                        </header>
                        
                    </div>
                    
                    <div class="rightside">
                    
                        <div class="entry">
                        
                            <h5>Ostatnio dodane:</h5>
                            <ol class="entrylist">
                                <?php
                                
                                    if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
                                    {
                                        require_once "mysqlconnect.php";

                                        mysqli_report(MYSQLI_REPORT_STRICT);

                                        try
                                        {
                                            $polaczenie = @new mysqli($host,$db_user,$db_password,$db_name); 

                                            if($polaczenie->connect_errno!=0)
                                            {
                                                throw new Exception(mysqli_connect_errno());
                                            }
                                            else
                                            {
                                                $result = $polaczenie->query(sprintf("SELECT * FROM receptury", mysqli_real_escape_string($polaczenie,$_SESSION['sql_login'])));

                                                $resultFound = $result->num_rows;


                                                $x = 0;

                                                while($row = $result->fetch_assoc())
                                                {

                                                    if($x >= $result->num_rows-4) echo '<li><a href="zielnik.php">'.$row['name'].'</a></li>';

                                                    $x++;
                                                }

                                                unset($_SESSION['blad']);
                                                $result->close();
                                            }   

                                            $polaczenie->close();
                                        }
                                        catch(Exception $e)
                                        {
                                            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
                                        }
                                    }
                                     else
                                    {
                                        echo '<h5 style="font-size: 12px;">Aby zobaczyć <a href="zielniklogowanie.php" style="text-decoration: none; color: #b2c4b2;">zaloguj</a> się!</h5>';
                                    } 
                                                     
                                ?>
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
                    
                    <label class="fixedbuttonRec">
                    <a href="przepisdodaj.php"><div title="Dodaj przepis" class="the-icons span3"><i class="demo-icon icon-plus-circled"></i></div></a>
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
        else
        {
            echo '<label class="fixedbuttonLogin">
                    <a href="zielniklogowanie.php"><div title="Zaloguj się" class="the-icons span3"><i class="demo-icon icon-lock-open-alt"></i></div></a>
                    </label>';
        }
    
    ?>
    
    <footer>
        
        <div class="info">
            Wszelkie prawa zastrzeżone &copy; Dziękuję za wizytę.
        </div>
        
    </footer>
    
</body>
    
</html>