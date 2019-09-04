<!DOCTYPE html>
<html>
	<?php include('templetes/header.php'); ?>

	<?php 

	include('config/conectar_db.php');

	if (isset($_GET['fundos'])) {
		$novoDinheiro = mysqli_real_escape_string($conn, $_GET['fundos']);
		$id = mysqli_real_escape_string($conn, $_GET['id_user']); 
		$sql = "UPDATE usuarios SET fundos = fundos + $novoDinheiro WHERE id = $id";

		if(mysqli_query($conn, $sql)){
			$_SESSION['fundos'] +=  $_GET['fundos'];
			header('Location: login.php');
		} else {
			echo 'Erro query' . mysqli_error($conn);
		}
	} else {
		header('Location: login.php');
	}

?>
</html>