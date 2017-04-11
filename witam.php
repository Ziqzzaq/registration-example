<?php

	session_start();
	
	if ((isset($_SESSION['udanarejestracja'])))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}

	
	//usuwamy błędy rejestracji
	if(isset($_SESSION['e_imie']))unset($_SESSION['e_imie']);
	if(isset($_SESSION['e_nazwisko']))unset($_SESSION['e_nazwisko']);
	if(isset($_SESSION['e_login']))unset($_SESSION['e_login']);
	if(isset($_SESSION['e_haslo']))unset($_SESSION['e_haslo']);
	if(isset($_SESSION['e_email']))unset($_SESSION['e_email']);
	if(isset($_SESSION['e_regulamin']))unset($_SESSION['e_regulamin']);
	if(isset($_SESSION['e_bot']))unset($_SESSION['e_bot']);
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Strona główna</title>
</head>

<body>
	
	Dzięki za rejestrację ! Możesz się już zalogować ! 
	
	<a href="index.php">Zaloguj się na swoje konto!</a>
	<br /><br />
	
	

</body>
</html>

