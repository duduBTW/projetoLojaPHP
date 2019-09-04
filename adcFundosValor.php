 <!DOCTYPE html>
 <html>
	<?php include('templetes/header.php'); ?>

	<?php 

	if (!isset($_SESSION['usuario'])) {
		header('Location: login.php');
	}

	 ?>

 	<style type="text/css">
 		.adcFundos{
			display: flex;
			max-width: 600px;
			height: 80vh;
			align-items: center;
			justify-content: center;
		}
 	</style>

 	<div class="adcFundos center white">
 		<form method="POST" action="adcFundos.php">
			<h4>Adicionar Fundos</h4>
			<input onkeypress="return event.charCode >= 48" min="0" type="number" name="adcFundos">
			<a href="login.php" class="btn brand center z-depth-0">Cancelar</a>
			<input value="Adicionar" type="submit" name="enviarAdc" class="btn brand center z-depth-0">
		</form>	
 	</div>

 </body>
 </html>