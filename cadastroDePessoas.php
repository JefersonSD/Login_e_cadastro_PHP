	<?php
	require_once 'CLASSES/pessoa.php';
	$pessoa = new Pessoa;
	require_once 'CLASSES/endereco.php';
	$endereco = new Endereco;
	require_once 'CLASSES/conexaoBanco.php';
	$conexao = new Conexao("projeto_funag","localhost","root","");	
	?>
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<title>Cadastro de pessoas e endereços</title>
		<style type="text/css">
			input{
				display: block;
				width: 450px;
			}
			input[type="submit"]{
				width: 250px;
			}

			.btn2{
				position: absolute;
				left: 465px;
				width: 150px;
			}
			.div{
				display: inline-block;
				background-color: red;
			}
		</style>	
	</head>
	<body>
		<h2>Informações pessoais</h2>
		<hr>
		<form method="POST">
			<input type="text" placeholder="Nome completo" name="nome" maxlength="50">
			<input type="text" placeholder="RG" name="rg" maxlength="10">
			<input type="text" placeholder="Data de Nascimento" name="dataN" maxlength="10">
			<hr>
			<h2>Endereço</h2>
			<hr>
			<input type="text" placeholder="Rua" name="rua" maxlength="50">
			<input type="text" placeholder="CEP" name="cep" maxlength="10">
			<input type="text" placeholder="Cidade" name="cidade" maxlength="30">
			<input type="text" placeholder="UF" name="uf" maxlength="2"><br>
			<input type="submit" value="Cadastrar">
			<hr>
		</form>

		<?php
		if(isset($_POST['nome']))
		{
			$pessoa->setNomeCompleto(addslashes($_POST['nome']));
			$pessoa->setIdentidade(addslashes($_POST['rg']));
			$pessoa->setDataDeNascimento(addslashes($_POST['dataN']));
			$endereco->setRua(addslashes($_POST['rua']));
			$endereco->setCep(addslashes($_POST['cep']));
			$endereco->setCidade(addslashes($_POST['cidade']));
			$endereco->setUf(addslashes($_POST['uf']));
			
			if(!empty($pessoa->getNomeCompleto()) && !empty($pessoa->getIdentidade()) && !empty($pessoa->getDataDeNascimento()) 
				&& !empty($endereco->getRua()) && !empty($endereco->getCep()) && !empty($endereco->getCidade()) && !empty($endereco->getUf())){
				$conexao->conectar();
			if($conexao->getMsgErro() == ""){
				if($pessoa->cadastrarPessoa($pessoa->getNomeCompleto(),$pessoa->getIdentidade(),$pessoa->getDataDeNascimento(),$conexao->getPdo())){
					$endereco->cadastrarEndereco($endereco->getRua(),$endereco->getCidade(),$endereco->getCep(), $endereco->getUf(),$pessoa->getIdentidade(),$conexao->getPdo()); 
					echo "Cadastro realizado com sucesso!";

				}else{
					echo "Pessoa já possui cadastro no banco de dados!";
				}
			}else{
				echo "Erro".$conexao->getMsgErro(); 
			}

		}else{
			echo "Preencha todos os campos!";
		}
	}

	?>
	<h2>Buscar pessoas</h2>
	<form method="GET">
		<div class="div">
			<input type="text" name="busca" size="50" placeholder="Insira o rg da pessoa">
		</div>
		<div class="div">
			<button class="btn">Buscar</button>
		</div>

	</form>
	<br>
	<?php

	if(isset($_GET['busca'])){
		if(!isset($_GET['busca'])){
			header("Location: cadastroDePessoas.php");
			exit;
		}else{
			$busca = "%".trim($_GET['busca'])."%";
			if(strcmp($busca,"%%") > 0){
				$conexao->conectar();
				$pdo = $conexao->getPdo();
				$sql = $pdo->prepare("SELECT * FROM pessoa WHERE identidade LIKE :busca");
				$sql->bindParam(":busca", $busca, PDO::PARAM_STR);
				$sql->execute();
				$resultado = $sql->fetchall(PDO::FETCH_ASSOC);
			}else{
				if(isset($_GET['busca'])){
					?>
					<label>Deve haver ao menos um parâmetro para a busca!</label>
					<?php
				}
				exit;	
			}
		}	

		if(count($resultado)){
			foreach ($resultado as $_resultado) {
				?>
				<label>Nome: <?php echo $_resultado["nome"]?></label>
				<form method="POST">
					<button class="btn2" name="button">Novo endereço</button>
				</form>
				<br>
			<?php }} else { ?>
				<label>Não foram encontrados resultados com os parâmetros informados!</label>	
			<?php } ?>

		<?php } ?>

		<?php

		if(isset($_POST['button'])){
			?>	
			<h2>Novo Endereço</h2>
			<form method="POST">
				<hr>
				<input type="text" placeholder="Rua" name="n_rua" maxlength="50">
				<input type="text" placeholder="CEP" name="n_cep" maxlength="10">
				<input type="text" placeholder="Cidade" name="n_cidade" maxlength="30">
				<input type="text" placeholder="UF" name="n_uf" maxlength="2"><br>
				<input type="submit" value="Cadastrar novo endereço">
				<hr>
			</form>
		<?php } 
		if(isset($_POST['n_rua']))
		{
			$novoEndereco = new Endereco;
			$novoEndereco->setRua(addslashes($_POST['n_rua']));
			$novoEndereco->setCep(addslashes($_POST['n_cep']));
			$novoEndereco->setCidade(addslashes($_POST['n_cidade']));
			$novoEndereco->setUf(addslashes($_POST['n_uf']));

			if(!empty($novoEndereco->getRua()) && !empty($novoEndereco->getCep()) && !empty($novoEndereco->getCidade()) && !empty($novoEndereco->getUf())){
				$conexao->conectar();
				if($conexao->getMsgErro() == ""){

					$novoEndereco->cadastrarNovoEndereco($novoEndereco->getRua(),$novoEndereco->getCidade(),$novoEndereco->getCep(), $novoEndereco->getUf(), $_resultado["id_pessoa"] ,$conexao->getPdo()); 
					echo "Cadastro realizado com sucesso!";

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