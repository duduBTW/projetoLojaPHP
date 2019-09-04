 <!DOCTYPE html>
 <html>
 	<?php include('templetes/header.php'); ?>

<?php 

	if (isset($_GET['id'])){
		include('config/conectar_db.php');
		$id_historico = mysqli_real_escape_string($conn, $_GET['id']);

		$sql = "SELECT * FROM compras WHERE id_historico = $id_historico";

		//Resultado
		$result = mysqli_query($conn, $sql);

		//Transforma result em array
		$product = mysqli_fetch_assoc($result); //Produto para checar as coisas
		mysqli_free_result($result);
		mysqli_close($conn);

		if($product['id_usuario'] !== $_SESSION['id_usuario']){
			header('Location: login.php');
		}
	} else{
		header('Location: login.php');
	}

?>

	<style type="text/css">
		h1{
			margin: 0px;
			padding: 0px;
		}
		.tela{
			max-width: 100%;
    		height: 80vh;
    		margin: 25px;
			border-radius: 3px;
			border: 1px solid #cbb09c;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
		.btns{
			margin: 10px;
		}
	</style>

	<div class="tela white">
		<h1><?php echo htmlspecialchars($product['titulo_produto']); ?></h1>
		<h3>Preço total: R$ <?php echo htmlspecialchars(($product['quantidade'] * $product['preco_produto'])); ?></h3>

			<?php if($product['quantidade'] > 1): ?>

			<h6>Preço unidade: R$ <?php echo htmlspecialchars($product['preco_produto']); ?></h6>
			<h6>Quantidade comprada: <?php echo htmlspecialchars($product['quantidade']); ?></h6>

			<?php endif; ?>

		<h5><?php echo htmlspecialchars($product['data_comprado']); ?></h5>
		<a href="historicoCompras.php" class="btn btns white grey-text"> &#8617 Voltar </a>

	</div>

</html>
