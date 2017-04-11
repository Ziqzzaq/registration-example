<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: gra.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
   
    <link href="css/index_css.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<title>Strona główna</title>
</head>

<body>
	
	
	
	 <nav>
         <h1>Zaloguj się ! </h1>
         <div class="form_error">
         <form action="zaloguj.php" method="post">
	   <div class="login">
		Login:  <input type="text" name="login" /> </div>
         
        <div class="haslo">
            Hasło:  <input type="password" name="haslo" /></div>
		<input type="submit" value="Zaloguj się" />
	
	</form>
        
         <?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>
             </div>
             
    </nav>
	
	
    <footer>
   
	<a href="rejestracja.php">Nie masz konta ? Załóż je za darmo!</a>
       
        </footer>
    
	


</body>
</html>

