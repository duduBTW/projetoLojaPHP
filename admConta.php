<!DOCTYPE html>
<html>
	<?php include('templetes/header.php'); ?>

	<?php 
		if (isset($_SESSION['usuario'])) {
			$erros = array('senha_adm'=>'');
			if (isset($_POST['submit'])) {
				$senhaAdm = mysqli_real_escape_string($conn, $_POST['senhaAdm']);
				$usuario = mysqli_real_escape_string($conn, $_SESSION['usuario']);

				$query = "SELECT usuario, id, fundos FROM usuarios WHERE usuario = 'adm' and senha = '$senhaAdm'";
				$result = mysqli_query($conn, $query);
				$row = mysqli_num_rows($result);

				if ($row == 1) {
					$queryEdit = "UPDATE usuarios SET tipo = 'adm' WHERE usuario = '$usuario'";
					if(mysqli_query($conn, $queryEdit)){
						header('Location: login.php');
					} else {
						echo 'Erro query' . mysqli_error($conn);
					}
					exit();
				} else {
					$erros['senha_adm'] = 'Senha errada';
				}
			}
		} else {
			header('Location: login.php');
		}
	 ?>

	<style type="text/css">
		.conteinerr{
			border-radius: 4px;
			border: 1px solid #cbb09c;
			margin: 20px auto;
			margin: 40px 50px 10px 50px;
			height: 500px;
		}
		.titulo{
			font-size: 40px;
			border-bottom: 0.5px dashed #cbb09c;
			width: 100%;
			padding: 20px;
		}
		.conteinerConteinerLogin{
			width: 100%
			height: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.conteiner-login{
			width: 400px;
		}
		.editIcon{
			cursor: pointer;
		}
		.btnEnviar{
			display: flex;
				align-items: center;
			justify-content: center;
		}
		.btns{
		    margin: 10px;
		}
	</style>

	<div class="conteinerr white ">
		
		<div class="center titulo grey-text">Virar Vendendor</div>
		<div class="conteinerConteinerLogin">
			<div class="conteiner-login">
				<div id="pog">
						<label>Senha Vendedor</label>
						<form action="admConta.php" method="POST">
							<input type="password" name="senhaAdm">
							<div class="red-text"> <?php echo htmlspecialchars($erros['senha_adm']) ?? ''; ?> </div>
							<div class="center">
								<a href="login.php" class="btn white brand-text center"> Voltar </a>
								<input type="submit" name="submit" value="Enviar" class="btn white brand-text">
							</div>
						</form>
				</div>
			</div>
			</div>
		</div>
</html>