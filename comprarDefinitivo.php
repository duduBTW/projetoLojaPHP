 <!DOCTYPE html>
 <html>
 	<?php include('templetes/header.php'); ?>

 	<?php

 	include('config/conectar_db.php');

	if (isset($_POST['valorParaAdiconar'])) {
		$valorParaAdiconar = mysqli_real_escape_string($conn, $_POST['valorParaAdiconar']);
		$id = mysqli_real_escape_string($conn, $_SESSION['id_usuario']); 
		$valorProduto = mysqli_real_escape_string($conn, $_POST['valorProduto']);
		$idProduto = mysqli_real_escape_string($conn, $_POST['idProduto']);
		$estoque_numero = mysqli_real_escape_string($conn, $_POST['estoque_numero']);
		$estoque = mysqli_real_escape_string($conn, $_POST['estoque']);
		$novo_valorProduto = mysqli_real_escape_string($conn, $_POST['novo_valorProduto']);
		$produto_historico = '';

		$sqlProdutos = 'SELECT titulo, preco, id FROM produtos ORDER BY data_adc';
		$resultado = mysqli_query($conn, $sqlProdutos);
		$produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

		foreach ($produtos as $produto) {
			if ($produto['id'] === $idProduto) {
				$produto_historico = htmlspecialchars($produto['titulo']);
				$produto_preco = htmlspecialchars($produto['preco']);

			}
		}

		$sql = "UPDATE usuarios SET fundos = fundos + $valorParaAdiconar, fundos = fundos - $novo_valorProduto WHERE id = $id";
		$sql2 = "UPDATE produtos SET estoque = estoque - $estoque_numero WHERE id = $idProduto";
		$sqlHistorico1 = "INSERT INTO compras(id_usuario, id_compra, quantidade, titulo_produto, preco_produto) VALUES('$id', '$idProduto', '$estoque_numero', '$produto_historico', '$produto_preco')";
			$sqlVendidos = "UPDATE produtos SET vendidos = vendidos + $estoque_numero WHERE id = $idProduto";

		if(mysqli_query($conn, $sql)){
			$_SESSION['fundos'] +=  $valorParaAdiconar;
			$_SESSION['fundos'] -=  $novo_valorProduto;

			mysqli_query($conn, $sql2);
			mysqli_query($conn, $sqlHistorico1);
			mysqli_query($conn, $sqlVendidos);	
			
		} else {
			echo 'Erro query' . mysqli_error($conn);
		}

		header('Location: login.php');
	} else {
		header('Location: index.php');
	}

 ?>

 </html>