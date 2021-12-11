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
			*{
				margin: 0px;
				padding: 0px;
			}
			input{
				display: block;
				height: 55px;
				width: 400px;
				margin: 10px;
				border-radius: 30px;
				border:1px solid;
				font-size: 16pt;

			}
			div#corpo-form{
				width: 420px;
				margin: 150px auto 0px auto;
			}

			div#corpo-form h1{
				text-align: center;
				padding: 20px;
			}

			a{
				display: block;
				text-align: center;
			}

			div.msg-erro{
				width: 400px;
				margin: 10px auto;
				padding: 10px;
				background-color: rgba(250,128,114,.3);
				text-align: center;
				
			}
		</style>	
	</head>
	<body>
		<div id="corpo-form">
		<h1>Entrar</h1>
		<form method="POST">
			<input type="email" placeholder="E-mail" name="email" maxlength="50">
			<input type="password" placeholder="Senha" name="senha" maxlength="15">
			<input type="submit" value="ACESSAR">
			<a href="cadastro.php">Ainda não possui cadastro?<strong>Cadastre-se
			</strong></a>
		</form>
		</div>

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
							?>
							<div class="msg-erro">
								Email e/ou senha incorretos!
							</div>
							<?php
						}
					}else{
						?>
							<div class="msg-erro">
								<?php echo "Erro".$conexao->getMsgErro();?>
							</div>
						<?php
					}
				}else{
						?>
							<div class="msg-erro">
								Preencha todos os campos!
							</div>
						<?php
				}
			}
		?>
	</body>
	</html>