<?php 

	include('config/conectar_db.php');

	$sql = 'SELECT titulo, preco, id FROM produtos ORDER BY data_adc';
	$resultado = mysqli_query($conn, $sql);
	$produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

	$sql2 = 'SELECT titulo, preco, id FROM produtos ORDER BY vendidos DESC';
	$resultado2 = mysqli_query($conn, $sql2);
	$produtos2 = mysqli_fetch_all($resultado2, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
	<?php include('templetes/header.php'); ?>
	<style type="text/css">
		.itens{
			margin: 20px;
			width: 280px;
			height: 365px;
			display: flex;
		    flex-direction: column;
		    justify-content: flex-end;
		    border: 1px solid #cbb09c;
		    border-radius: 3px;
		    transition: 0.2s;
		    background-image: url(./error.jpg);
		    background-repeat: no-repeat;
  			background-size: 278.5px 265px;
		}
		.itens:hover {
		    transform: scale(1.03, 1.03);
		    transition: 0.2s;
		    box-shadow: 10px 15px 20px rgba(0, 0, 0, 0.2); 
		}
		.itens:active {
		    transform: scale(1.02, 1.02);
		    transition: 0.2s;
		    box-shadow: 5px 8px 10px rgba(0, 0, 0, 0.2); 
		}
		.pog{
			display: flex;
			flex-wrap: wrap;
		    justify-content: center;
		    align-content: flex-start;
		}
		.detalhes{
			border-top: 1px solid #cbb09c;
		}
		h5{
			margin: 0px;
			padding: 10px;
		}
		.botao{
			text-transform: uppercase;
			padding: 5px;
		}
		.subTitulo{
			color: grey;
		}
		.subTitulo:after{
		    content: "";
		    display: block;
		    margin: 10px 0;
		    width: 100px;
		    height: 3px;
		    background: #000;
		}
	</style>
	<h3 class="center">Produtos!</h3>
	<div class="">
		<h5 class="subTitulo">Novos</h5>
		<div class="pog">
			
			<?php foreach ($produtos as $produto) { ?>
				<div class="itens white">
					<a href="comprar.php?id=<?php echo $produto['id']; ?>" class="brand-text">
						<h5 class="center"><?php echo htmlspecialchars($produto['titulo']); ?></h5>
					<div class="center">R$: <?php echo htmlspecialchars($produto['preco']); ?></div>
					<a 
					class="brand-text center botao detalhes" 
					href="comprar.php?id=<?php echo $produto['id']; ?>"
					>Detalhes</a>
					</a>
				</div>
			<?php } ?>
			
			<?php if(count($produtos) === 0): ?>
				<h3 class="grey-text">Sem produtos disponveis</h3>
			<?php endif; ?>

		</div>
		<h5 class="subTitulo">Mais vendidos</h5>
		<div class="pog">
			
			<?php foreach ($produtos2 as $produto2) { ?>
				<div class="itens white">
					<a href="comprar.php?id=<?php echo $produto2['id']; ?>" class="brand-text">
						<h5 class="center"><?php echo htmlspecialchars($produto2['titulo']); ?></h5>
					<div class="center">R$: <?php echo htmlspecialchars($produto2['preco']); ?></div>
					<a 
					class="brand-text center botao detalhes" 
					href="comprar.php?id=<?php echo $produto['id']; ?>"
					>Detalhes</a>
					</a>
				</div>
			<?php } ?>
		</div>	
	</div>

	<?php include('templetes/footer.php'); ?>
</html>