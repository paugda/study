<?php
	session_start();
	if(isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Zaloguj się do panelu dietetyka</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
      <form class="form-signin" action="" method="POST" role="form">
	<?php
	require_once('config.php'); //wczytanie bazy danych
	//logowanie do administratora
	if(isset($_POST['inputLogin']) && isset($_POST['inputPassword']))
	{	
		$stmt = $db->prepare('SELECT * FROM users WHERE login=:login AND haslo=:haslo');
		$stmt->bindValue(':login', $_POST['inputLogin'], SQLITE3_TEXT);
		$stmt->bindValue(':haslo', md5($_POST['inputPassword']), SQLITE3_TEXT);
		
		$result = $stmt->execute();
		if($result->fetchArray())
		{
			header('Location: index.php');
			session_start();
			$_SESSION['zalogowany'] = true;
		}
		else
		{
			echo '<div class="alert alert-danger"><strong>Błąd!</strong> Niepoprawny login lub hasło do panelu.</div>';	
		}
	}
		
	?>
	  <img class="mb-1" src="img/start.jpg" alt="" width="100" height="100">
      <h1 class="h3 mb-3 font-weight-normal">Zaloguj się</h1>
      <label for="inputLogin" class="sr-only">Login</label>
      <input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="Login dietetyka" required autofocus>
      <label for="inputPassword" class="sr-only">Hasło</label>
      <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Hasło dietetyka" required>
	  
      <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj się</button>
    </form>
  </body>
</html>
