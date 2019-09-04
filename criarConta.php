<?php  

	include('config/conectar_db.php');
	$erros = array('usuario'=>'', 'senha'=>'', 'confirmar_senha'=>'');
	$usuario = $senha = $confirmar_senha = '';


	if(isset($_POST['submit'])){
		if (mb_strlen($_POST['usuario']) < 4) {
			$erros['usuario'] = 'Usuario deve ter no minimo 4 letras';
			$usuario = $_POST['usuario'];
		} 

		//Confirmar Usuario
		if (empty($_POST['usuario'])) {
			$erros['usuario'] = 'Usuario é obrigatorio';
		} else {
			$usuario = $_POST['usuario'];
		}

		//Confirmar Senha
		if (empty($_POST['senha'])) {
			$erros['senha'] = 'Senha é obrigatoria';
		} else{
			$senha = $_POST['senha'];
		}

		//Confirmar Confirmar Senha (Isso parece confuso, mas faz sentido LUL)
		if (empty($_POST['confirmar_senha'])) {
			$erros['confirmar_senha'] = 'Confirmar senha é obrigatorio';
		} else {
			$confirmar_senha = $_POST['confirmar_senha'];
		}

		if(!($_POST['senha'] === $_POST['confirmar_senha'])){
			$erros['confirmar_senha'] = 'Senha e confirmar senha devem ser iguais';
		}

		
			$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
			$senha = mysqli_real_escape_string($conn, $_POST['senha']);

			$query = "SELECT usuario, id, fundos FROM usuarios WHERE usuario = '$usuario'";

			$result = mysqli_query($conn, $query);
			$ususarioIgual = mysqli_fetch_assoc($result);

			$row = mysqli_num_rows($result);

			if ($row == 1) { //Se for igual
				$erros['usuario'] = 'Usuario ja existe';
			} else {
				if (!array_filter($erros)) {
				//Criar SQL
				$sql = "INSERT INTO usuarios(usuario, senha) VALUES('$usuario', md5('$senha'))";

				//Salvar no banco de dados
				if (mysqli_query($conn, $sql)){
					header('Location: login.php');
				} else {
					echo "Erro" . mysqli_error($conn);
				}
			}
			
		}
	}

 ?>

<!DOCTYPE html>
<html>
	<?php include('templetes/header.php'); ?>

	<section class="conteiner grey-text login white">
		<h4 class="center">Criar conta</h4>
		<form action="criarConta.php" method="POST">
			<label>Usuario:</label>
			<input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
			<div class="red-text"> <?php echo $erros['usuario']; ?> </div>
			<label>Senha:</label>
			<input type="password" name="senha" value="<?php echo htmlspecialchars($senha); ?>">
			<div class="red-text"> <?php echo $erros['senha']; ?> </div>
			<label>Confirmar Senha:</label>
			<input type="password" name="confirmar_senha" value="<?php echo htmlspecialchars($confirmar_senha); ?>">
			<div class="red-text"> <?php echo $erros['confirmar_senha']; ?> </div>
			<div class="center btnsLogin">
				<input type="submit" name="submit" value="Criar" class="btn brand z-depth-0">
				<a name="submit" href="login.php" class="btn brand z-depth-0"> Voltar </a>
			</div>
		</form>
	</section>


	<?php include('templetes/footer.php'); ?>
</html>