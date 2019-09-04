<?php 
	include('config/conectar_db.php');
	session_start();
	
	if (isset($_POST['submit'])) {
		$erros = array('usuario'=>'', 'senha'=>'');
		$usuario = $senha = '';
		if (empty($_POST['usuario'])) {
			$erros['usuario'] = 'Usuario é obrigatorio';
			$usuario = $_POST['usuario'];
		}

		if (empty($_POST['senha'])) {
			$erros['senha'] = 'Senha é obrigatoria';
			$usuario = $_POST['senha'];
		}

		if (!array_filter($erros)){
			$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
			$senha = mysqli_real_escape_string($conn, $_POST['senha']);
			
			$query = "SELECT usuario, id, fundos FROM usuarios WHERE usuario = '$usuario' and senha = md5('$senha')";

			$result = mysqli_query($conn, $query);
			$ususarioCeto = mysqli_fetch_assoc($result);

			$row = mysqli_num_rows($result);

			print_r($ususarioCeto['id']);

			if ($row == 1) {
				$_SESSION['usuario'] = $ususarioCeto['usuario'];
				$_SESSION['id_usuario'] = $ususarioCeto['id'];
				$_SESSION['fundos'] = $ususarioCeto['fundos'];
				header('Location: login.php');
				exit();
			} else {
				header('Location: login.php');
			}
		} else {
			header('Location: login.php');
		}
	}

	if (isset($_POST['sair'])) {
		unset($_SESSION['usuario']);
		unset($_SESSION['id_usuario']);
		unset($_SESSION['fundos']);
		header('Location: login.php');
	}
	header('Location: login.php');
	
 ?>