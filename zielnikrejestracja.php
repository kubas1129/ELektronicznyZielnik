<?php

session_start();


if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    header('Location: zielnik.php');
    exit();
}

//sprawdzamy czy cokolwiek sie przesłało
if(isset($_POST['email']))
{
     
    $validateOK = true;
    
    //walidacja loginu
    $login = $_POST['login'];
    
    if(strlen($login) < 3 || strlen($login) > 20)
    {
        $validateOK = false;
        $_SESSION['error_login'] ="Login musi posiadać od 3-20 znaków!";
    }
    
    
    if(ctype_alnum($login)==false)
    {
        $validateOK=false;
        $_SESSION['error_login']="Login musi składać się jedynie z liter i cyfr!";
    }
    
    $email=$_POST['email'];
    
    $emailB= filter_var($email, FILTER_SANITIZE_EMAIL);
    
    if(filter_var($emailB, FILTER_VALIDATE_EMAIL)==false || $emailB!=$email)
    {
        $validateOK=false;
        $_SESSION['error_email']="Niepoprawny adres email!";
    }
    
    //Walidacja hasła
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];
    
    if(strlen($haslo1) < 8 || strlen($haslo1) > 20)
    {
        $validateOK=false;
        $_SESSION['error_haslo'] ="Hasło musi posiadać od 8-20 znaków!";
    }
    
    if($haslo1!=$haslo2)
    {
        $validateOK=false;
        $_SESSION['error_haslo']="Podane hasła są różne!";
    }
    
    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
    
    
    if(!isset($_POST['regulamin']))
    {
        $wszystko_OK=false;
        $_SESSION['error_regulamin']="Potwierdź akceptację regulaminu!";
    }
    
    
    
    //Walidacja captcha
    $secretCaptcha = "6LdTmjYUAAAAAA7li3L2gd_JZDEJnrcaJ_-QEAnx";
    
    $captchaCheck = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretCaptcha.'&response='.$_POST['g-recaptcha-response']);
    
    $captchaResponse = json_decode($captchaCheck);
    
    if($captchaResponse->success==false)
    {
        $validateOK=false;
        $_SESSION['error_captcha']="Potwierdź że nie jesteś botem";
    }
    
    //Połączenie
    require_once "mysqlconnect.php";
    
    mysqli_report(MYSQLI_REPORT_STRICT);
    
    try
    {
        $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
        
        if($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //sprawdzenie czy mail juz istnieje
            $result = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
            
            if(!$result) throw new Exception($polaczenie->error);
            
            $resultsFound = $result->num_rows;
            
            if($resultsFound > 0)
            {
                $validateOK=false;
                $_SESSION['error_email']="Podany email istnieje już w bazie!";
            }
            
            
            //sprawdź czy login już istnieje 
            $result = $polaczenie->query("SELECT id FROM uzytkownicy WHERE login='$login'");
            
            if(!$result) throw new Exception($polaczenie->error);
            
            $resultsFound = $result->num_rows;
            
            if($resultsFound > 0)
            {
                $validateOK=false;
                $_SESSION['error_login'] = "Istnieje już konto o podanym loginie!";
            }
            
            
            //Jeśli wszystko poszło OK
            if($validateOK==true)
            {
                if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,'$login','$haslo_hash','$email',0)"))
                {
                    $_SESSION['registrationSuccess']=true;
                    header('Location: regSuccess.php');
                }
                else
                {
                    throw new Exception($polaczenie->error);
                }
            }
            
            $polaczenie->close();
        }        
    }
    catch(Exception $e)
    {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
    }    
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
    <script>
            if(document.getElementById('pagestyle'))
            {
                delete document.getElementById('pagestyle'); //Usuwamy gdy juz jest żeby nie było duplikacji        
            }
            var head = document.getElementsByTagName('head')[0],
            link = document.createElement('link');
            link.id = 'pagestyle';
            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.href = localStorage['pageStyle'] || 'css/main.css';
            head.appendChild(link);
    </script>
    <link rel="stylesheet" href="css/fontello.css"/>
    
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Lobster|Ubuntu:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
    <script>
        function switchToLight()
        {
            localStorage['pageStyle'] = 'css/mainlight.css';
            var head = document.getElementsByTagName('head')[0],
            link = document.createElement('link');
            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.href = localStorage['pageStyle'] || 'css/main.css';
            head.appendChild(link);
            return link;
        }
        
         function switchToDark()
        {
            localStorage['pageStyle'] = 'css/main.css';
            var head = document.getElementsByTagName('head')[0],
            link = document.createElement('link');
            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.href = localStorage['pageStyle'] || 'css/main.css';
            head.appendChild(link);
            return link;
        }
    </script>

</head>

<body>
    
    <header id="top">
    
        <img src="img/ziola.jpg"/> 
        
        <nav class="nav">
            <ul class="menu">
                <li><a href="index.php">Strona główna</a></li>
                <li><a href="zielnik.php">Zielnik</a></li>
                <li><a href="przepisy.php">Receptury</a></li>
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
                        
                        <header>
                            <h1>Logowanie w serwisie Elektroniczny zielnik</h1><br /> 
                        </header>
                        
                        <div class="logowanie">
                        
                            <form method="post" >
                                
                                Login:<br />
                                <input type="text" name="login"/><br />
                                
                                <?php
                                
                                if(isset($_SESSION['error_login']))
                                {
                                    echo'<div class="error">'.$_SESSION['error_login'].'</div>';
                                    unset($_SESSION['error_login']);
                                }
                                
                                ?>
                                
                                Adres email:<br />
                                <input type="text" name="email"/><br />
                                
                                <?php
                                
                                if(isset($_SESSION['error_email']))
                                {
                                    echo'<div class="error">'.$_SESSION['error_email'].'</div>';
                                    unset($_SESSION['error_email']);
                                }
                                
                                ?>
                                
                                Hasło:<br />
                                <input type="password" name="haslo1"/><br />
                                
                                <?php
                                
                                if(isset($_SESSION['error_haslo']))
                                {
                                    echo'<div class="error">'.$_SESSION['error_haslo'].'</div>';
                                    unset($_SESSION['error_haslo']);
                                }
                                
                                ?>
                                
                                Powtórz hasło:<br />
                                <input type="password" name="haslo2"/><br />
                                <label><input type="checkbox" name="regulamin" />Akceptuję regulamin</label><br /> 
                                
                                <?php
                                
                                if(isset($_SESSION['error_regulamin']))
                                {
                                    echo'<div class="error">'.$_SESSION['error_regulamin'].'</div>';
                                    unset($_SESSION['error_regulamin']);
                                }
                                
                                ?>
                                
                                <div class="g-recaptcha" data-sitekey="6LdTmjYUAAAAAKl4q0jr_sOJLLf7Hz6PL6kGNdCS"></div><br />
                                
                                <?php
                                
                                if(isset($_SESSION['error_captcha']))
                                {
                                    echo'<div class="error">'.$_SESSION['error_captcha'].'</div>';
                                    unset($_SESSION['error_captcha']);
                                }
                                
                                ?>
                                
                                <input class="registButton" type="submit" value="Zarejestruj się"/>
                            
                            </form>                     
                        
                        </div>
                        
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

                                                    if($x >= $result->num_rows-4) echo '<li><a href="#">'.$row['name'].'</a></li>';

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
                                        echo '<h5 style="font-size: 12px;">Aby zobaczyć <a href="zielniklogowanie.php" style="text-decoration: none; color: #3e3e3e;">zaloguj</a> się!</h5>';
                                    } 
                                                     
                                ?>
                            </ol>
                            
                        </div>
                        
                        <div class="ad">
                        
                            
                            
                        </div>
                        
                        <div id="styleSwitcher">
                            <br />
                            <button onclick="switchToLight()">Light</button>
                            <button onclick="switchToDark()">Dark</button>
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
                    <a href="zielnikdodaj.php"><div title="Dodaj roślinę" class="the-icons span3"><i class="demo-icon icon-plus-circled"></i></div></a>
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