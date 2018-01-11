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


if(isset($_GET['idv']))
{
    $_SESSION['idDetail'] = $_GET['idv'];
    header('Location: zielnikDetail.php');
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
        
        <div style="clear: both;"></div>
            
    </header>
    
    <div class="container">
        
        <main>
        
            <article>
                
                <section>
                                    
                    <div class="leftside">
                        
                        <header>
                            <h1>Receptury</h1><br /> 
                        </header>
                        
                        <?php

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
                                $result = $polaczenie->query(sprintf("SELECT * FROM przepisy", mysqli_real_escape_string($polaczenie,$_SESSION['sql_login'])));

                                $resultFound = $result->num_rows;

                                $idname='one';
                            
                                                        
                                while($row = $result->fetch_assoc())
                                {
                            
                                                                    
                                    echo '<div class="recipy" id="'.$idname.'">
                                        <img class="recipyImage" src="img/'.$row['image'].'" />
                                        <div class="recipyText">
                                        <h1>'.$row['name'].'</h1>
                                        <p>'.$row['recipe'].'</p>
                                        </div>
                                        <div style="clear: both;"></div>
                                        </div>';
                                    switch($idname)
                                    {
                                        case 'one': $idname='two'; break;
                                        case 'two': $idname='three';break;
                                        case 'three': $idname='four';break;
                                        case 'four': $idname='none';break;
                                        default: $idname='none';break;
                                    }
                                                    
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

                        ?>
                        
                        
                    
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
                                                $id='#one';

                                                while($row = $result->fetch_assoc())
                                                {

                                                    if($x >= $result->num_rows-4) echo '<li><a href="'.$id.'">'.$row['name'].'</a></li>';

                                                    $x++;
                                                    
                                                    switch($id)
                                                    {
                                                        case '#one': $id='#two'; break;
                                                        case '#two': $id='#three';break;
                                                        case '#three': $id='#four';break;
                                                        case '#four': $id='#';break;
                                                        default: $id='#';break;
                                                    }
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
                                        //echo '<li><p>Aby zobaczyć ostatnio dodane musisz być zalogowany!</p></li>';
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
    
    ?>
    
    <footer>
        
        <div class="info">
            Wszelkie prawa zastrzeżone &copy; Dziękuję za wizytę.
        </div>
        
    </footer>
    
</body>
    
</html>