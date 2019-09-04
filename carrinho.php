 <!DOCTYPE html>
 <html>
 	<?php include('templetes/header.php'); ?>

<?php

	 if(isset($_SESSION['usuario'])){
	 	// Carrinho ainda está em desenvolvimento, quase nada do codigo dele está pronto no momento
		include('config/conectar_db.php');
			//Só mostra os itens
			$idUsuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);

			// Checar se foi comprado
			if(isset($_POST['comprar'])){
				// Variaveis que chegaram do POST comprar
				$valorProduto = mysqli_real_escape_string($conn, $_POST['valorProduto']);
				$idProduto =  mysqli_real_escape_string($conn, $_POST['id_deletar']); 
				$estoque =  mysqli_real_escape_string($conn, $_POST['estoque']);
				$estoque_numero =  mysqli_real_escape_string($conn, $_POST['estoque_numero']);


				// SQL adicionar item carrinho
				$sqlCarrinho = "INSERT INTO carrinho(id_usuario, id_compra, quantidade) VALUES('$idUsuario', '$idProduto', '$estoque_numero')";
				mysqli_query($conn, $sqlCarrinho);
			}

			// SQL pegar os itens do carrinho do usuario
			$sqlPegarCarrinho = "SELECT * FROM carrinho WHERE id_usuario = $idUsuario";
			$resultadoPegarCarrinho = mysqli_query($conn, $sqlPegarCarrinho);
			$carrinhoItens = mysqli_fetch_all($resultadoPegarCarrinho, MYSQLI_ASSOC);

			//Produtos
			$sqlProdutos = 'SELECT titulo, preco, id FROM produtos';
			$resultadoProdutos = mysqli_query($conn, $sqlProdutos);
			$produtos = mysqli_fetch_all($resultadoProdutos, MYSQLI_ASSOC);			
	} else {
		header('Location: login.php');
	}

?>

	<style type="text/css">
		.conteiner{
			display: flex;
			border-radius: 4px;
			border: 1px solid grey;
			align-items: center;
			margin: 15px;
		}
		.titulo{
			display: flex;
			width: 50%;
			padding: 10px;
		}
		.deletar{
			display: flex;
			width: 50%;
			justify-content: flex-end;
			padding: 10px;
		}
	</style>

	<h3 class="center">Carrinho!</h3>

	<?php foreach ($carrinhoItens as $item): ?>
		<?php foreach($produtos as $produto): ?>
			<?php if($produto['id'] == $item['id_compra']): ?>
				<div class="conteiner">
					<div class="titulo">
						<?php echo htmlspecialchars($produto['titulo']); ?>	
						<?php echo htmlspecialchars($item['quantidade']); ?>	
					</div>
				<form action="" method="POST" class="deletar">
				    <button type="submit" class="btn-floating btn waves-effect waves-light red">
				      <i class="material-icons">delete</i>
				    </button>
				</form>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endforeach; ?>
	</div>

</html>