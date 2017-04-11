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
	<title>Strona główna</title>



<body>

<form method="POST">

	Obecne hasło: <br /> <input type="password" name="password" /><br />
	<?php
	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
			$pass = $_POST['password'];
			$login = $_SESSION['login'];

			if ($rezultat  = @$polaczenie->query(
			sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
			mysqli_real_escape_string($polaczenie,$login))))
			{
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow>0)
				{
					$wiersz = $rezultat->fetch_assoc();

					$pass_hash=password_hash($pass,PASSWORD_DEFAULT);
				}
			}
		}
				?>

Nowe hasło: <br /> <input type="password" name="password2" /><br />


				<?php
				$pass2 = $_POST['password2'];

					if (password_verify($pass, $wiersz['pass']))
					{

						$pass2_hash=password_hash($pass2,PASSWORD_DEFAULT);
						if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,NULL,NULL,NULL,'$pass2_hash',NULL)"))
						{


							echo "udało się zmienić hasło ! ";

						}

					}




?>
<input type="submit" value="Zmień hasło" />
</form>

  </body>
  </html>
