<!DOCTYPE html>
<html>
	<?php include('templetes/header.php'); ?>

<?php 
	include('config/conectar_db.php');
	$erros = array('usuario'=>'', 'senha'=>'', 'erroLogin'=>'');
	$usuario = $senha = '';

	if (isset($_POST['submit'])) {
		$usuario = $senha = '';
		if (empty($_POST['usuario'])) {
			$erros['usuario'] = 'Usuario é obrigatorio';
		} else {
			$usuario = $_POST['usuario'];
		}
		if (empty($_POST['senha'])) {
			$erros['senha'] = 'Senha é obrigatoria';
		} else{
			$senha = $_POST['senha'];
		}

		if (!array_filter($erros)){
			$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
			$senha = mysqli_real_escape_string($conn, $_POST['senha']);
			
			$query = "SELECT usuario, id, fundos FROM usuarios WHERE usuario = '$usuario' and senha = md5('$senha')";

			$result = mysqli_query($conn, $query);
			$ususarioCeto = mysqli_fetch_assoc($result);

			$row = mysqli_num_rows($result);

			if ($row == 1) {
				$_SESSION['usuario'] = $ususarioCeto['usuario'];
				$_SESSION['id_usuario'] = $ususarioCeto['id'];
				$_SESSION['fundos'] = $ususarioCeto['fundos'];
				header('Location: login.php');
				exit();
			} else {
				$erros['erroLogin'] = 'Senha ou usuario incorreto';
			}
		}
	}

	if (isset($_POST['sair'])) {
		unset($_SESSION['usuario']);
		unset($_SESSION['id_usuario']);
		unset($_SESSION['fundos']);
		header('Location: login.php');
	}
	
 ?>

	<style type="text/css">
		.pog{
			margin: 40px 20px 10px 40px;
			display: flex;
			height: 100vh;
			border-top: 1px solid #cbb09c;
			border-bottom: 1.5px solid #cbb09c;
			border-radius: 3px;
		}
		.teste1{
			display: flex;
			width: 80%;
			border-left: 1px solid #cbb09c;
			border-radius: 3px;
			flex-direction: column;
		}
		.teste2{
			display: flex;
			flex-direction: column;
			width: 20%;
			align-items: center;
			justify-content: center;
			border-right: 1px solid #cbb09c;
		}
		.dinheiro-conta{
			margin: 50px;
		}
		.btn-adcFundos{
			max-width: 200px;
			margin-left: 50px;
		}
		.btn-rt{
			margin-bottom: 10px;
			width: 200px;
		}
		.usuario{
			border-bottom: 0.5px dashed #cbb09c;
			padding-bottom: 50px; 
		}
		.login-Tela{
			border-radius: 4px;
			border: 1px solid #cbb09c;
			max-width: 460px;
			margin: 54px auto;
			padding: 50px;
		}
	</style>

	<section class="grey-text">
		<?php if(!isset($_SESSION['usuario'])): ?>	
		<form action="login.php" method="POST" class="login-Tela white">
			<h4 class="center">Entrar</h4>
			<div class=" center red-text"> <?php echo htmlspecialchars($erros['erroLogin']); ?> </div>	
			<label>Usuario:</label>
			<input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
			<div class="red-text"> <?php echo htmlspecialchars($erros['usuario']); ?> </div>
			<label>Senha:</label>
			<input type="password" name="senha" value="<?php echo htmlspecialchars($senha); ?>">
			<div class="red-text"> <?php echo htmlspecialchars($erros['senha']); ?> </div>
			<div class="center btnsLogin">
				<input type="submit" name="submit" value="Entrar" class="btn brand z-depth-0">
				<a name="submit" href="criarConta.php" class="btn brand z-depth-0"> Criar conta </a>
			</div>
		</form>

		<?php else: ?>

			<div class="pog">
				<div class="teste1 white ">
						<h1 class="center usuario"><?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
						<h4 class="dinheiro-conta">Saldo atual: R$ <?php echo htmlspecialchars($_SESSION['fundos']); ?></h4>
						<a class="btn btn-adcFundos brand z-depth-0" href="./adcFundosValor.php">Adicionar fundos</a>
				</div>

				<div class="teste2 grey lighten-5">
					<a class="btn btn-rt brand z-depth-0" href="historicoCompras.php">Compras</a>
					<a class="btn btn-rt brand z-depth-0" href="editConta.php">Configurar conta</a>
					<form method="POST" action="login.php">
						<input type="submit" name="sair" value="Sair" class="btn btn-rt brand z-depth-0">	
					</form>
				</div>
			</div>
		
		<?php endif; ?>
	</section>
</html>