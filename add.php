
<!DOCTYPE html>
<html>
	<?php include('templetes/header.php'); ?>

<?php 

	if (isset($_SESSION['usuario']) && (($ususarioConctTipo['tipo'] === 'adm'))) {
		include('config/conectar_db.php');

		$errors = array('titulo' =>'', 'preco'=>'', 'estoque'=>'');
		$titulo = $preco = $estoque = '';

		if(isset($_POST['submit'])){

			//Checar Titulo
			if(empty($_POST['titulo'])){
				$errors['titulo'] =  "Nome do produto é obrigatorio <br />";
			} else{
				$titulo = $_POST['titulo'];
				if(!preg_match('/^[a-zA-Z\s]+$/', $titulo)){
					$errors['titulo'] = "Nome do produto so pode ter letras e espaços";
				}
			}

			//Checar engrdientes
			if(empty($_POST['preco'])){
				$errors['preco'] = "preço é obrigatorio <br />";
			} else {
				$preco = $_POST['preco'];
			}

			if(empty($_POST['estoque'])){
				$errors['estoque'] = "estoque é obrigatorio <br />";
			} else {
				$estoque = $_POST['estoque'];
			}

			if(!array_filter($errors)){
				$id_usuario = mysqli_real_escape_string($conn, $_SESSION['id_usuario']);
				$titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
				$preco = mysqli_real_escape_string($conn, $_POST['preco']);
				$estoque = mysqli_real_escape_string($conn, $_POST['estoque']);

				//Criar SQL que vai adicionar
				$sql = "INSERT INTO produtos(titulo, id_usuario, preco, estoque) VALUES('$titulo', '$id_usuario', '$preco', '$estoque')";

				// Salvar no banco de dados e checar
				if(mysqli_query($conn, $sql)){
					header('Location: index.php');
				} else {
					echo "Erro" . mysqli_error($conn);
				}

				header('Location: index.php');
			}
		}	// Fim da validação
	} else {
		header('Location: login.php');
	}

?>


	<section class="conteiner grey-text login white">
		<h4 class="center">Adicionar Produto</h4>
		<form class="white" action="add.php" method="POST">
			<label>Nome do Produto:</label>
			<input autocomplete="off" type="text" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>">
			<div class="red-text"> <?php echo $errors['titulo']; ?> </div>
			<label>Preço:</label>
			<input autocomplete="off" type="number" name="preco" value="<?php echo htmlspecialchars($preco); ?>">
			<div class="red-text"> <?php echo $errors['preco']; ?> </div>
			<label>Estoque:</label>
			<input autocomplete="off" min="1" type="number" name="estoque" value="<?php echo htmlspecialchars($estoque); ?>">
			<div class="red-text"> <?php echo $errors['estoque']; ?> </div>
			<div class="center">
				<input type="submit" name="submit" value="Enviar" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templetes/footer.php'); ?>
</html>