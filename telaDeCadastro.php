<?php

session_start();
if(!isset($_SESSION['id_usuario'])){
	header("location: index.php");
	exit;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Sistema de cadastro</title>
	<style type="text/css">
		input{
			height: 50px;
			display: block;
			width: 150px;
		}
		img,h1{
			display: inline-block;	
		}
		.btnsair{
			position: absolute;
			bottom: 12px;
			padding: 10px;
			width: 150px;
			left: 75px;
		}
		.container{
			display: inline-block;	
			height: 30vh;
			position: absolute;
			border: solid 2px gray;
		}
		.botao1,.botao2{
			display: inline-block;
		}
		
	</style>
</head>
<body>
	<img src="IMAGEM/funag.jpg" height="200px" width="200px">
	<div class="container">
		<h1>Sistema de cadastro</h1>
		<div class="menu">
			<a href="cadastroDePessoas.php"><div class="botao1"><input type="submit" value="Casdastrar"></div></a>
			<a href="gerarRelatorioPdf.php"><div class="botao2"><input type="submit" value="Relatório"></div></a>
		</div>
		<a href="sair.php"><button class="btnsair">Sair</button></a>	
	</div>	
</body>
</html>




