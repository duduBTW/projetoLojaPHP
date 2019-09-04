<?php 

	//conetar para a database
	// usuario e senha aqui <-

	//Checar a conexão
	if(!$conn){//Se a conexão for um sucesso isso sera true, mas com a negação ira executar se a coneção falhar
		echo "Erro na conexão". mysqli_connect_error();
	}

 ?>