 <!DOCTYPE html>
 <html>
 	<?php include('templetes/header.php'); ?>
 	<?php 

	//adcFundos=11&adcFundos=22
	
	include('config/conectar_db.php');
	if (!isset($_POST['enviarAdc'])) {
		header('Location: login.php');
	}
	/*
	if (isset($_POST['enviarAdc'])) {
		$novoDinheiro = mysqli_real_escape_string($conn, $_POST['adcFundos']);
		$id = mysqli_real_escape_string($conn, $_SESSION['id_usuario']); 
		$sql = "UPDATE usuarios SET fundos = fundos + $novoDinheiro WHERE id = $id";

		if(mysqli_query($conn, $sql)){
			$_SESSION['fundos'] += $_POST['adcFundos'];
			header('Location: login.php');
		} else {
			echo 'Erro query' . mysqli_error($conn);
		}
	}
	*/

 ?>

 <style type="text/css">
 	.adcFundoss{
			transform: translateY(50%);
			align-items: center;
			justify-content: center;
			padding: 30px;
			margin: 0px 40px 0px 40px;
			border: 1px solid #cbb09c;
			border-radius: 3px;
		}
	
 </style>

 	<div class="center adcFundoss white">
 		<h2><?php echo htmlspecialchars($_SESSION['usuario']); ?> deseja adicionar R$: <?php echo htmlspecialchars($_POST['adcFundos']); ?></h2>
 		<br/>
 			<a class="brand-text btn white center btns" href="login.php">Cancelar</a> 
	 	<div class="btn white center">
			<a class="brand-text btns" href="adcFundosDefinitivo.php?fundos=<?php echo $_POST['adcFundos']; ?>&id_user=<?php echo $_SESSION['id_usuario']?>">Adicionar</a>
		</div>
 	</div>	
 </body>
 </html>