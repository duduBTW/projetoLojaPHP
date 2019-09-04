<?php 
	session_start();
	if (isset($_SESSION['usuario'])) {
		include('config/conectar_db.php');
		$usuarioTipo =  mysqli_real_escape_string($conn, $_SESSION['usuario']);
		$sqlTipo = "SELECT tipo FROM usuarios WHERE usuario = '$usuarioTipo'";
		$resultTipo = mysqli_query($conn, $sqlTipo);
		$ususarioConctTipo = mysqli_fetch_assoc($resultTipo);
	}
	
?>

<head>
	<title>Loja Aleatoria</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style type="text/css">
		.brand{
			background: #cbb09c !important;
		}
		.brand-text{
			color: #cbb09c !important;
		}
		/*
		form{
			max-width: 460px;
			margin: 20px auto;
			padding: 20px;
		}
		*/
		
		.login{
			border-radius: 4px;
			border: 1px solid #cbb09c;
			max-width: 460px;
			margin: 20px auto;
			padding: 60px;
		}
		.btnsLogin{
			margin: 20px;
		}
		.adcFundos{
			margin-top: 10%;
			border-radius: 4px;
			border: 1px solid #cbb09c;
			width: 860px;
			margin: 20px auto;
			padding: 20px;
		}
		.borda{
			border-bottom: 1px #cbb09c solid;
			margin-bottom: 10px;
			padding-bottom: 25px;
		}
		.nav-drop{
			margin: 5px 0px 0px 0.5%;
			position: absolute;
			width: 140px;
			height: 121px;
			background-color: white;
			border-radius: 3px;
			border: 0.5px solid #cbb09c;
			box-shadow: 1px 1px 3px grey;
		}
		.nav-drop-iten{
			padding: 5px;
			line-height: 30px;
			color: rgba(0,0,0,0.87);
		}
		.nav-drop{
			display: none;
			transition: transform 5s;
		}
		.carrinho{
			line-height: 66px !important;
			height: 66px !important;
		}
		.hoverCarrinho:hover{
			color: white !important;
		}
		nav{
			padding: 0px 20px 0px 20px;
		}
		@keyframes navFade{
			from{
				opacity: 0;
				transform: translateY(-10%);
			}
			to{
				opacity: 1;
				transform: translateY(0%);
			}
		}
	</style>
	<style>
	    img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"] {
	        display: none;
	    }
	</style>
</head>
	<body class="grey lighten-4">
		<div class="navbar-fixed">
			<nav class="white">
			<div class="">
				<a href="index.php" class="brand-logo brand-text">Loja Aleatoria</a>
				<ul id="nav-mobile" class="right hide-on-small-and-down">

					<?php if(isset($_SESSION['usuario'])  && ($ususarioConctTipo['tipo'] === 'adm')): ?>
						<li><a href="add.php" class="btn brand z-depth-0">Adicionar Produto</a></li>
					<?php endif; ?>

					<?php if(!isset($_SESSION['usuario'])): ?>
						<li><a class="brand-text" href="login.php">Entrar</a></li>
					<?php else: ?>
						<li>
							<a href="#"><i class="material-icons carrinho grey-text center">shopping_cart</i></a>
						</li>
						<li>
							<a id="nav-login" class="brand-text">
								<div class="chip">
									<?php echo htmlspecialchars($_SESSION['usuario']); ?>
							    	<img src="./noProfPic.jpg" alt="Contact Person">
							    	R$: <?php echo $_SESSION['fundos']; ?>
							  	</div>
							</a>
							<div class="nav-drop center">
							  	<a href="login.php" class="nav-drop-iten">Perfil</a>
							  	<a href="historicoCompras.php" class="nav-drop-iten">Compas</a>
							  	<a href="editConta.php" class="nav-drop-iten">Editar</a>
							</div>
						</li>
					<?php endif; ?>

				</ul>
			</div>
			</nav>
		</div>
		<script type="text/javascript">
			const nav = document.querySelector('.nav-drop')
			const entrar = document.querySelector('#nav-login')

			entrar.addEventListener('click', () =>{
				if(nav.style.display !== "block"){
					nav.style.display = "block";
					nav.style.animation = "navFade 0.5s";
				} else {
					nav.style.display = "none";
				}
			})
		</script>