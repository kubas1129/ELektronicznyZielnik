<?php

session_start();


//sprawdzamy czy cokolwiek sie przesłało
if(isset($_POST['name']))
{
     
    $validateOK = true;
    
    //walidacja loginu
    $name = $_POST['name'];
    
    if(strlen($name) == 0)
    {
        $validateOK = false;
        $_SESSION['e_name'] ="Nazwa receptury jest pusta!";
    }
    
    
    $description=$_POST['description'];
    
    if(strlen($description) == 0)
    {
        $validateOK = false;
        $_SESSION['e_desc'] ="Opis jest pusty!";
    }
    
    $recipe=$_POST['recipe'];
    
    if(strlen($recipe) == 0)
    {
        $validateOK = false;
        $_SESSION['e_recipe'] ="Przepis jest pusty!";
    }
    
    
    if(!($_FILES['userfile']['error']==UPLOAD_ERR_OK))
    {
        $validateOK = false;
        $_SESSION['e_file']="Nieudana próba przesłania zdjęcia!";
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
            //sprawdzenie czy receptura o podanej nazwie nie istnieje
            $result = $polaczenie->query("SELECT id FROM receptury WHERE name='$name'");
            
            if(!$result) throw new Exception($polaczenie->error);
            
            $resultsFound = $result->num_rows;
            
            if($resultsFound > 0)
            {
                $validateOK=false;
                $_SESSION['e_name']="Receptura o podanej nazwie istnieje już w bazie!";
            }
            
                        
            //Jeśli wszystko poszło OK
            if($validateOK==true)
            {
                
                $img=addslashes(file_get_contents($_FILES['userfile']['tmp_name']));
                
                if($polaczenie->query("INSERT INTO receptury VALUES (NULL,'$name','$description','{$_FILES['userfile']['name']}','$recipe')"))
                {
                    header('Location: zielnik.php');
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
                            <h1>Dodawanie rośliny</h1><br /> 
                        </header>
                        
                        <div class="logowanie">
                        
                            <form enctype="multipart/form-data" action=
                                "<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                                
                                Nazwa:<br />
                                <input type="text" name="name"/><br />
                                
                                <?php
                                
                                if(isset($_SESSION['e_name']))
                                {
                                    echo'<div class="error">'.$_SESSION['e_name'].'</div>';
                                    unset($_SESSION['e_name']);
                                }
                                
                                ?>
                                
                    
                                Opis:<br />
                                <textarea rows="20" cols="60" name="description">                   
                                </textarea><br />
                                
                                <?php
                                
                                if(isset($_SESSION['e_description']))
                                {
                                    echo'<div class="error">'.$_SESSION['e_description'].'</div>';
                                    unset($_SESSION['e_description']);
                                }
                                
                                ?>
                                
                                Szczegółowy opis:<br />
                                <textarea rows="20" cols="60" name="recipe">                   
                                </textarea><br />
                                
                                <?php
                                
                                if(isset($_SESSION['e_recipe']))
                                {
                                    echo'<div class="error">'.$_SESSION['e_recipe'].'</div>';
                                    unset($_SESSION['e_recipe']);
                                }
                                
                                ?>
                                            
                                
                                Zdjęcie:<br />
                                <input name="userfile" type="file"/>
                                
                                <?php
                                
                                if(isset($_SESSION['e_file']))
                                {
                                    echo'<div class="error">'.$_SESSION['e_file'].'</div>';
                                    unset($_SESSION['e_file']);
                                }
                                                            
                                ?>
                                                        
                      
                                <input class="registButton" type="submit" value="Dodaj"/>
                                
                                
                            
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