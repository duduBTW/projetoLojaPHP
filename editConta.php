<!DOCTYPE html>
<html>
	<?php include('templetes/header.php'); ?>

	<?php 
		if (isset($_SESSION['usuario'])) {
			$erros = array('novoUsuario'=>'');

			include('config/conectar_db.php');
				if (isset($_POST['submit'])) {
				$novoNome = mysqli_real_escape_string($conn, $_POST['novoNome']);
				$id = mysqli_real_escape_string($conn, $_SESSION['id_usuario']); 

				$query = "SELECT usuario, id, fundos FROM usuarios WHERE usuario = '$novoNome'";
				$result = mysqli_query($conn, $query);
				$row = mysqli_num_rows($result);

				$sql = "UPDATE usuarios SET usuario = '$novoNome' WHERE id = $id";

				if ($row == 1){
					$erros['novoUsuario'] = 'Usuario já existe.';
					$jaVisitado = true;
				} else {
					if(mysqli_query($conn, $sql)){
						$_SESSION['usuario'] = $novoNome;
						header('Location: login.php');
					} else {
						echo 'Erro query' . mysqli_error($conn);
					}
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
		.virarVendedor{
			position: absolute;
			margin: 10px;
			display: flex;
			width: 100%
			min-height: 500px;
			justify-content: flex-start;
			align-items: flex-start;
		}
	</style>

	<div class="conteinerr white ">
		<div class="center titulo grey-text">Editar Conta</div>
			<div class="virarVendedor">
				<a class="btn btn-rt brand z-depth-0" href="admConta.php">Virar Vendedor</a>
			</div>
		<div class="conteinerConteinerLogin">
			<div class="conteiner-login">
				<div id="pog">
					<?php if(!isset($jaVisitado)): ?>
						<label>Usuario</label>
						<h6><?php echo htmlspecialchars($_SESSION['usuario']); ?> <i onclick="pog()" class="material-icons right editIcon">create</i></h6>
						<div class="center">
							<a href="login.php" class="btn btns white grey-text"> &#8617 Voltar </a>
						</div>
					<?php else: ?>
						<form action="editConta.php" method="POST"> 
							<label>Novo usuario</label> 
							<input type="text" value="<?php echo htmlspecialchars($novoNome); ?>" name="novoNome" placeholder="Novo usuario...">
							<div class="red-text"><?php echo htmlspecialchars($erros['novoUsuario']);?></div>
							<div class="btnEnviar"> 
							<a href="editConta.php" class="btn btns white grey-text"> Cancelar </a>
							<input type="submit" name="submit" class="btn white grey-text" value="Salvar alterações">
							</div>
						</form>
					<?php endif; ?>
				</div>
			</div>
			</div>
		</div>

		<script type="text/javascript">
			function pog(){
				document.getElementById('pog').innerHTML = '<form action="editConta.php" method="POST"> <label>Novo usuario</label> <input type="text" value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>" name="novoNome" placeholder="Novo usuario..."> <div class="btnEnviar"> <a href="editConta.php" class="btn white grey-text"> Cancelar </a> <input type="submit" name="submit" class="btn btns white grey-text" value="Salvar alterações"> </div> </form>';
			}
		</script>
</html>