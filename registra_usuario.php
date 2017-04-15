<?php

	require_once('db.class.php');

	$usuario = $_POST['usuario'];
	$email = $_POST['email'];
	$senha = md5($_POST['senha']);
	$usuario_existe = false;
	$email_existe = false;


	$objDb = new db();
	$link = $objDb->conecta_mysql();


	//verificar se o usuário já existe
	$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";

	if ($resultado_id = mysqli_query($link, $sql)){
		# code...
		$dados_usuario = mysqli_fetch_array($resultado_id);

		if ($dados_usuario['usuario']) {
			# code...
			$usuario_existe = true;
		}//end if ($dados_usuario['usuario'])

	} else {
		# code...
		echo "Erro ao tentar localizar o registro de usuário";
	}//end if ($resultado_id = mysqli_query($link, $sql))


	//verificar se o e-mail já existe
	$sql = "SELECT * FROM usuarios WHERE email = '$email'";

	if ($resultado_id = mysqli_query($link, $sql)){
		# code...
		$dados_usuario = mysqli_fetch_array($resultado_id);

		if ($dados_usuario['email']) {
			# code...
			$email_existe = true;
		}

	} else {
		# code...
		echo "Erro ao tentar localizar o registro de usuário";
	}//end if ($resultado_id = mysqli_query($link, $sql))


	//caso usuário ou email exista...
	if ($usuario_existe || $email_existe) {
		# code...
		$retorno_get = '';

		if ($usuario_existe) $retorno_get.= 'erro_usuario=1&';
		if ($email_existe) $retorno_get.= 'erro_email=1&';

		header('Location: inscrevase.php?'.$retorno_get);
		die();

	}//end if ($usuario_existe || $email_existe)


	//inserindo usuário no banco
	$sql = " insert into usuarios(usuario, email, senha) values ('$usuario', '$email', '$senha') ";

	//executar a query
	if(mysqli_query($link, $sql)){
		header('Location: index.php');
	} else {
		echo 'Erro ao registrar o usuário!';
	}//end if(mysqli_query($link, $sql))


?>
