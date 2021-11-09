<?php
	require_once 'CLASSES/usuarios.php';
	$u = new Usuario;
	require_once 'CLASSES/conexaoBanco.php';
	$conexao = new Conexao("projeto_funag","localhost","root","");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Login usuario</title>
	<style type="text/css">
		input{
			display: block;
		}
	</style>	
</head>
<body>
	<h1>Entrar</h1>
	<form method="POST">
		<input type="email" placeholder="E-mail" name="email" maxlength="50">
		<input type="password" placeholder="Senha" name="senha" maxlength="15">
		<input type="submit" value="ACESSAR">
		<a href="cadastro.php">Ainda não possui cadastro?<strong>Cadastre-se</strong></a>
	</form>
		
		<?php

		if(isset($_POST['email']))
		{
			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);
		
			if(!empty($email) && !empty($senha)){
				$conexao->conectar();
				if($conexao->getMsgErro() == ""){
					if($u->logar($email,$senha,$conexao->getPdo())){
							header("location: telaDeCadastro.php");
					}else{

						echo "Email e/ou senha incorretos!"; 
					}
				}else{

					echo "Erro".$conexao->getMsgErro();
				}
			}else{

				echo "Preencha todos os campos!";
			}
		}
	?>
</body>
</html>