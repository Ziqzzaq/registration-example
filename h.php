<?php
session_start();

if(!isset($_SESSION['zalogowany']))
{
	header('Location:index.php');
	exit();
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
      <link href="css/h_css.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<title>Strona główna</title>

	<script type="text/javascript" src="js/timer.js"></script>

</head>
    <div class="calosc">
    <div class="kolor">
 <form method="post" action="h.php">
        Tło 1 
    	<input type="submit" name="color" value="img/1.jpg" />
        Tło 2
        <input type="submit" name="color" value="img/2.png" />
        Tło 3
        <input type="submit" name="color" value="img/3.png" />
    </form>
     <?php
    if ( isset( $_POST['color'] ) )
    {
    	$color = $_POST['color'];
    }
    ?>
        </div>

    <body onload="odliczanie(); " style="background-image:url(<?php echo $color ?>)"> 
   <nav>
    <div class="napis">
	<?php
		echo"<p>Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko'].' ! [ <a href="logout.php">Wyloguj się</a> ]';
	 ?>
        </div>
	 <div id="zegar" class="zegar"></div>
</nav>
    </body>
    </div>
</html>
