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
	<h1>Cadastrar</h1>
	<form method="POST">
		<input type="text" name="nome" placeholder="Nome completo" maxlength="30">
		<input type="text" name="telefone" placeholder="Telefone" maxlength="30">
		<input type="email" name="email" placeholder="Usuário" maxlength="50">
		<input type="password" name="senha"placeholder="Senha" maxlength="15">
		<input type="password" name="confSenha"placeholder="Confirmar senha" maxlength="15">
		<input type="submit" value="CADASTRAR">
	</form>
	<?php
		if(isset($_POST['nome']))
		{
			$nome = addslashes($_POST['nome']);
			$telefone = addslashes($_POST['telefone']);
			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);
			$confirmarSenha = addslashes($_POST['confSenha']);
		
			if(!empty($nome) && !empty($telefone) && !empty($email) 
			   && !empty($senha) && !empty($confirmarSenha)){

			   	$conexao->conectar();
			    if($conexao -> getMsgErro() == ""){
			    	if($senha == $confirmarSenha){

			    		if($u -> cadastrar($nome,$telefone,$email,$senha,$conexao->getPdo())){
			    			?>
			    			<a href="index.php">Cadastro realizado com sucesso!&nbsp<strong>Faça o seu login</strong></a>
			    			<?php
			    		}else{
			    			 echo "Email já cadastrado!";
			    		}
			    	}else{
			    		echo "Senha e confirmar senha não correspondem!";
			    	}
			    }else{
			    	echo "Erro".$u->msgErro; 
			    }

			}else{
				 echo "Preencha todos os campos!";
			}
		}
	?>
</body>	
</html>