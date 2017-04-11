<?php

	session_start();
 	
 	if(isset($_POST['email']))
 	{
 		//udana walidacja
 		$ok=true;



 		//sprawdzenie loginu
 		$login = $_POST['login'];
 		//sprawdzenie dlugosci loginu
 		if(strlen($login)<3 || strlen($login)>20)
 		{
 			$ok=false;
 			$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków !";
		}
		//sprawdzanie znaków loginu
		if(ctype_alnum($login)==false)
		{
			$ok=false;
			$_SESSION['e_login']="Login może składać się tylko z liter i liczb(bez polskich znaków)";

		}

 		//sprawdzenie imienia
 		$imie = $_POST['imie'];
 		//sprawdzenie dlugosci imienia
 		if(strlen($imie)<3 || strlen($imie)>20)
 		{
 			$ok=false;
 			$_SESSION['e_imie']="Imie musi posiadać od 3 do 20 znaków !";
		}

		//sprawdzenie nazwiska
 		$nazwisko = $_POST['nazwisko'];
 		//sprawdzenie dlugosci nazwiska
 		if(strlen($nazwisko)<3 || strlen($nazwisko)>20)
 		{
 			$ok=false;
 			$_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 20 znaków !";
		}

		//sprawdzenie mail
		$email = $_POST['email'];
		$emailb = filter_var($email,FILTER_SANITIZE_EMAIL);
		if((filter_var($emailb,FILTER_VALIDATE_EMAIL)==false) || ($emailb!=$email))
		{
			$ok=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail";
		}


		//sprawdzenie hasla
 		$haslo1 = $_POST['haslo1'];
 		$haslo2 = $_POST['haslo2'];
 		//sprawdzenie dlugosci hasla
 		if(strlen($haslo1)<8 || strlen($haslo1)>20)
 		{
 			$ok=false;
 			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków !";
		}
		if($haslo1!=$haslo2)
		{
			$ok=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne !";
		}
		

		$haslo_hash=password_hash($haslo1,PASSWORD_DEFAULT);
		//regulamin
		
		if(!isset($_POST['regulamin']))
		{
			$ok=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}

		//Bot or not? Oto jest pytanie!
		$sekret = "6LeBlA0UAAAAAG4j4FQcpfeNDIcZojP5juN8dOs7";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		


		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT); //rzucamy wyjatki zamiast ostrzezen
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
					
				}
			else
			{
				//czy email juz istnieje
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

				if(!$rezultat) throw new Exception($polacznie->error);

				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0){

					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}

				//czy login juz istnieje
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$login'");

				if(!$rezultat) throw new Exception($polacznie->error);

				$ile_takich_loginow = $rezultat->num_rows;
				if($ile_takich_loginow>0){

					$wszystko_OK=false;
					$_SESSION['e_login']="Istnieje już uzytkownik o takim loginie!";
				}


				if($ok==true)
					{

					//Brawo,wszystko dobrze
					if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,'$imie','$nazwisko','$login','$haslo_hash','$email')"))
					{

						$_SESSION['udana_rejestracja']=true;
						header('Location:witam.php');

					}
					else
					{

						throw new Exception($polacznie->error);

					}

					}

				$polaczenie->close();
			}
		}
		catch(Exception $e)
		{
			echo'Błąd serwera! Przepraszam za niedogodności i proszę o rejestrację w innym terminie!';
		}
 	}



?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Załóż konto</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
    <link href="css/rej_css.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Advent+Pro&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>

<form method="POST">

	Imię: <br /> <input type="text" name="imie" /><br />

	<?php
	if(isset($_SESSION['e_imie']))
	{
		echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
		unset($_SESSION['e_imie']);
	}
	?> <br /> 

	Nazwisko: <br /> <input type="text" name="nazwisko" /><br /> <br /> 

	<?php
	if(isset($_SESSION['e_nazwisko']))
	{
		echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
		unset($_SESSION['e_nazwisko']);
	}
	?>
	Login: <br /> <input type="text" name="login" /><br />
	<?php
	if(isset($_SESSION['e_login']))
	{
		echo '<div class="error">'.$_SESSION['e_login'].'</div>';
		unset($_SESSION['e_login']);
	}
	?><br />
	Hasło: <br /> <input type="password" name="haslo1" /><br /> 
	<?php
	if(isset($_SESSION['e_haslo']))
	{
		echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
		unset($_SESSION['e_haslo']);
	}
	?><br />
	Powtórz hasło: <br /> <input type="password" name="haslo2" /><br /> <br /> 
	E-mail: <br /> <input type="text" name="email" /><br />
	<?php
	if(isset($_SESSION['e_email']))
	{
		echo '<div class="error">'.$_SESSION['e_email'].'</div>';
		unset($_SESSION['e_email']);
	}
	?><br /> 
	<label>
	<input type="checkbox" name="regulamin" /> Akceptuję regulamin
	</label>
	<?php
	if(isset($_SESSION['e_regulamin']))
	{
		echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
		unset($_SESSION['e_regulamin']);
	}
	?><br /><br />
	<div class="g-recaptcha" data-sitekey="6LeBlA0UAAAAANZ7bwqzKHu0wzMij-VLccECXVQR"></div>
	<?php
	if(isset($_SESSION['e_bot']))
	{
		echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
		unset($_SESSION['e_bot']);
	}
	?><br />

	<input type="submit" value="Zarejestruj się" /> 
	</form>
    <br />
     <footer>
   
	<a href="index.php">Masz już konto ? Zaloguj się !</a>
       
        </footer>
    

</body>
</html>