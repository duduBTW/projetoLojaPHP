 <!DOCTYPE html>
 <html>
 	<?php include('templetes/header.php'); ?>

<?php

	if (isset($_SESSION['usuario'])){
		include('config/conectar_db.php');

			$id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']); 

			$sql = "SELECT * FROM compras WHERE id_usuario = '$id_usuario' ORDER BY data_comprado DESC";
			$resultado = mysqli_query($conn, $sql);
			$produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
	} else {
		header('Location: login.php');
	}

?>

	<style type="text/css">
		.itens{
			display: flex;
			padding: 30px;
			border-bottom: 1px dashed #cbb09c;
		}
		.itens:hover{
			background: #fffaf7;
			cursor: pointer;
		}
		.itens_header{
			display: flex;
			padding: 10px 30px 10px 30px;
			border-top: 1px solid #cbb09c;
			border-bottom: 1px solid #cbb09c;
			font-weight: bold;
		}
		.quantidade{
			width: 50%;
			display: flex;
			justify-content: flex-end;
		}
		.titulo{
			width: 50%;
			display: flex;
			justify-content: flex-start;
		}
		.preco{
			width: 10%;
			display: flex;
		}
		.qt{
			width: 40%;
			display: flex;
		}
	</style>

	<h3 class="center">Compras!</h3>

	<div class="white">
		
		<div class="itens_header">
				<div class="titulo">
					<div class="qt">Item</div>
					<div>Quantidade</div>
				</div>
				<div class="quantidade">
					<div class="preco"><div></div>Preço</div>
				</div>
				<!-- <div><?php// echo htmlspecialchars($produto['data_comprado']); ?></div> -->
			</div>
		<?php foreach ($produtos as $produto): ?>

			<a href="detalhesHistorico.php?id=<?php echo htmlspecialchars($produto['id_historico']); ?>" class="black-text">
			<div class="itens">
				<div class="titulo">
					<div class="qt"><?php echo htmlspecialchars($produto['titulo_produto']); ?></div>
					<div class=""><?php echo htmlspecialchars($produto['quantidade']); ?></div>
				</div>
				<div class="quantidade">
					<div class="preco"><div></div>R$: <?php echo htmlspecialchars(($produto['quantidade'] * $produto['preco_produto'])); ?></div>
				</div>
				<!-- <div><?php// echo htmlspecialchars($produto['data_comprado']); ?></div> -->
			</div>
			</a>

		<?php endforeach; ?>

	</div>

</html>