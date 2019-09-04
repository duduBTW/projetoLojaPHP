 <!DOCTYPE html>
 <html>
 	<?php include('templetes/header.php'); ?>

 	<?php 
	include('config/conectar_db.php');

	if (isset($_POST['deletar']) && isset($_SESSION['usuario'])) {
		$id_deletar = mysqli_real_escape_string($conn, $_POST['id_deletar']);

		$sql = "DELETE FROM produtos WHERE id = $id_deletar";

		if(mysqli_query($conn, $sql)){
			header('Location: index.php');
		} else {
			echo 'Erro query' . mysqli_error($conn);
		}

	}

	if (isset($_POST['comprar']) && isset($_SESSION['usuario'])) {
		$valorProduto = mysqli_real_escape_string($conn, $_POST['valorProduto']);
		$idUsuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);
		$idProduto =  mysqli_real_escape_string($conn, $_POST['id_deletar']); 
		$estoque =  mysqli_real_escape_string($conn, $_POST['estoque']);

		if (isset($_POST['estoque_numero'])) { // Checa para ver o estoque
			$estoque_numero =  mysqli_real_escape_string($conn, $_POST['estoque_numero']);
			$novo_valorProduto = $valorProduto * $estoque_numero;

			$sql = "UPDATE usuarios SET fundos = fundos - $novo_valorProduto WHERE id = $idUsuario";
			$sql2 = "UPDATE produtos SET estoque = estoque - $estoque_numero WHERE id = $idProduto";

			$sqlProdutos = 'SELECT titulo, preco, id FROM produtos ORDER BY data_adc';
			$resultado = mysqli_query($conn, $sqlProdutos);
			$produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

			foreach ($produtos as $produto) {
				if ($produto['id'] === $idProduto) {
					$produto_historico = htmlspecialchars($produto['titulo']);
					$produto_preco = htmlspecialchars($produto['preco']);

				}
			}

			$sqlHistorico1 = "INSERT INTO compras(id_usuario, id_compra, quantidade, titulo_produto, preco_produto) VALUES('$idUsuario', '$idProduto', '$estoque_numero', '$produto_historico', '$produto_preco')";

			$sqlVendidos = "UPDATE produtos SET vendidos = vendidos + $estoque_numero WHERE id = $idProduto";
		} else {
			$estoque_numero = 0;
			$novo_valorProduto = 0;
		}
		
		if ((($_SESSION['fundos'] -  $novo_valorProduto) >= 0) && ($estoque > 0)){
			if(mysqli_query($conn, $sql)){
				mysqli_query($conn, $sql2);
				mysqli_query($conn, $sqlHistorico1);	
				mysqli_query($conn, $sqlVendidos);	
				
				$_SESSION['fundos'] -=  $novo_valorProduto;
				header('Location: login.php');
				
			} else {
				echo 'Erro query' . mysqli_error($conn);
			}

		} elseif($estoque <= 0) { // Se o estoque for menor que 0
			$semEstoque = true; 
		} else {
			$valorParaAdiconar = abs($_SESSION['fundos'] -  $novo_valorProduto);
			$valorTotalAdiconar = abs($_SESSION['fundos'] +  $valorParaAdiconar);
			$adicionarDinheiro = true;
		}
		
	} elseif(isset($_POST['comprar'])) {
		$semContaComprar = true; //Se você não esta logado
	}

	if (isset($_GET['id'])) {
		$id = mysqli_real_escape_string($conn, $_GET['id']);

		//SQL
		$sql = "SELECT * FROM produtos WHERE id = $id";

		//Resultado
		$result = mysqli_query($conn, $sql);

		//Transforma result em array
		$product = mysqli_fetch_assoc($result); //Produto para checar as coisas
		mysqli_free_result($result);
		mysqli_close($conn);
	}

 ?>


 	<style type="text/css">
 		.adcProduto{
			border-radius: 4px;
			border: 1px solid #cbb09c;
			margin: 20px auto;
			margin: 40px 50px 10px 50px;
			padding: 50px;
			height: 70vh;
			width: 100%;
		}
		.comprarProduto{
			border-radius: 2px;
			border-top: 1px solid #cbb09c;
			border-right: 1px solid #cbb09c;
			border-bottom: 1px solid #cbb09c;
			margin: 20px auto;
			margin: 40px 50px 10px 0px;
			height: 90vh;
			width: 60%;
			display: flex;
			align-items: flex-start;
			justify-content: flex-start;
		}
		.imgProduto{
			display: flex;
			width: 40%;
			border-top: 1px solid #cbb09c;
			border-left: 1px solid #cbb09c;
			border-bottom: 1px solid #cbb09c;
			margin: 40px 0px 10px 50px;
			border-radius: 2px;
		}
		.imgProdutoDim{
			width:100%;
    		height: 90vh;
		}
		.titulo{
			border-bottom: 0.5px dashed #cbb09c;
			width: 100%;
			padding-bottom: 20px;
		}
		.preco{
			padding-bottom: 5px;
			font-weight: bold;
		}
		.estoque{
			padding-bottom: 5px;
		}
		.estoque_numero{
			max-width: 200px;
			align-items: flex-end;
		}
		.botoes{
			margin: 10px 0px 10px 0px;
			padding: 20px 35px;
			line-height: 2px !important;
		}
		.wow{
			width: 100%;
		}
		.errorAlert{
			display: flex;
			height: 70vh;
			width: 100%;
			align-items: center;
			justify-content: center;
			flex-direction: column;
		}
		.conteiner-geral{
			width: 100%;
			display: flex;
		}
		h1{
			margin: 0;
			padding: 0;
			color: red;
		}
		h2{
			margin: 0;
			margin-bottom: 23px;
			padding: 0;
		}
		.btns{
			margin-top: 50px;
		}
 	</style>


	<div class="conteiner-geral">
		<?php if(isset($product)): ?>

			<div class="imgProduto">
				<img class="imgProdutoDim" src="./error.jpg">
			</div>
			<div class="comprarProduto white center">
			<div class="wow">
				<h4 class="titulo center" ><?php echo htmlspecialchars($product['titulo']); ?></h4>
				<h4 class="preco">R$: <?php echo htmlspecialchars($product['preco']); ?></h4>
				<?php if($product['estoque'] > 0): ?>

					<h6 class="estoque">Estoque: <?php echo htmlspecialchars($product['estoque']); ?></h6>
				<?php else: ?>
					<h6 class="estoque grey-text">Estoque esgotado</h6>

				<?php endif; ?>

				<form action="comprar.php" method="POST" class="">
					<?php if($product['estoque'] > 0): ?>
					<input 
						type="number" 
						name="estoque_numero" 
						max="<?php echo $product['estoque']; ?>"
						min="1"
						value="1"
						class="estoque_numero"
						onkeydown="return false"
					>
					<?php else: ?>
						<div></div>
					<?php endif; ?>
					<input 
						type="hidden" 
						name="id_deletar" 
						value="<?php echo $product['id']; ?>"
					>
					<input 
						type="hidden" 
						name="valorProduto" 
						value="<?php echo $product['preco']; ?>"
					>
					<input 
						type="hidden" 
						name="estoque" 
						value="<?php echo $product['estoque']; ?>"
					>
					<br>
					<?php if(isset($_SESSION['usuario'])  && ($ususarioConctTipo['tipo'] === 'adm')): ?>
					<input 
						type="submit" 
						name="deletar" 
						value="Deletar" 
						class="brand-text btn white botoes"
					>
					<?php endif; ?>
					<input 
						type="submit" 
						name="comprar" 
						value="Comprar"
						class="brand-text btn white botoes"
					>
				</form>
					<a href="index.php" class="brand-text btn white"> &#8617</a>
				<div class="brand-text">Adicionado: <?php echo htmlspecialchars($product['data_adc']); ?></div>

				<?php if(isset($_SESSION['usuario'])  && ($ususarioConctTipo['tipo'] === 'adm')): ?>
					<div class="grey-text">Vendidos: <?php echo htmlspecialchars($product['vendidos']); ?></div>
				<?php endif; ?>
			</div>
		<?php elseif(isset($semContaComprar)): ?> <!-- Tela que vai aparecer se você tentar comprar algo sem conta -->
			
			<div class="errorAlert">
				<h1>!</h1>
				<h2>É preciso estar logado para realizar uma compra</h2>
				<a href="login.php" class="brand-text btn white"> &#8617 Entrar</a>
			</div>

		<?php elseif(isset($semEstoque)): ?> <!-- Tela que vai aparecer se você tentar comprar algo que sem estoque -->

			<div class="errorAlert">
				<h1>!</h1>
					<h2>Estoque esgotado</h2>
				<a class="btn white brand-text" href="comprar.php?id=<?php echo $idProduto; ?>">&#8617</a>
			</div>

		<?php elseif(isset($confirmarCompra)): ?> 
			<!-- Tela que vai aparecer se você tentar comprar algo que sem dinheiro o bastante na conta, que perguntara se você deseja adicionar os fundos necessarios para finalizar a compra -->
		<div class="center">
			<h4>Confirmar compra do item por R$: <?php echo htmlspecialchars($valorProduto); ?> </h4>

			<a class="btn white brand-text" href="index.php">Cancelar</a>
			<a class="btn white brand-text" href="login.php">Confirmar Compra</a>
		</div>
		
		<?php elseif(isset($adicionarDinheiro)): ?>

			<div class="adcProduto white">
				<h5>Seu saldo: <div class="right">
					R$: <?php echo htmlspecialchars($_SESSION['fundos']); ?></div>
				</h5>
				<h5 class="borda">
					Valor adicional: <div class="right">R$: <?php echo htmlspecialchars($valorParaAdiconar); ?></div>
				</h5>
				<h5>
					Total: <div class="right green-text">R$: <?php echo htmlspecialchars($valorTotalAdiconar); ?></div>
				</h5>

				<form class="center" action="comprarDefinitivo.php" method="POST">
					<input 
						type="hidden" 
						name="valorProduto" 
						value="<?php echo htmlspecialchars($valorProduto) ?>"
					>
					<input 
						type="hidden" 
						name="valorParaAdiconar" 
						value="<?php echo htmlspecialchars($valorParaAdiconar); ?>"
					>
					<input 
						type="hidden" 
						name="estoque_numero" 
						value="<?php echo htmlspecialchars($estoque_numero); ?>"
					>
					<input 
						type="hidden" 
						name="novo_valorProduto" 
						value="<?php echo htmlspecialchars($novo_valorProduto); ?>"
					>
					<input 
						type="hidden" 
						name="estoque" 
						value="<?php echo htmlspecialchars($estoque); ?>"
					>
					<input 
						type="hidden" 
						name="idProduto" 
						value="<?php echo htmlspecialchars($idProduto) ?>"
					>
					<a 
						href="index.php" 
						class="brand-text btn white btns"
					>
					Cancelar</a>
					<input 
						type="submit" 
						name="comprar" 
						value="Finalizar compra" 
						class="brand-text btn white btns"
					>
				</form>
			</div>
			

		<?php else: ?>  <!-- Tela que vai aparecer se você tentar acessar um produto que não existe -->

			<div class="errorAlert">
				<h1>!</h1>
				<h4>Esse produto não existe</h4>
				<a 
					href="index.php" 
					class="brand-text btn white"
				> 
				&#8617</a>
			</div>

		<?php endif; ?>
	</div>


</html>