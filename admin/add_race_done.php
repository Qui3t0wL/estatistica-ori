<?php
	require_once ('auth.php');
	require_once ('connect.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	$nome = $_POST['nome'];
	$local = $_POST['local'];
	$data = trim($_POST['date5']);
	$id_prova = trim($_POST['id_prova']);
	$id_distancia = trim($_POST['id_distancia']);
	$organizacao1 = $_POST['organizacao1'];
	$organizacao2 = $_POST['organizacao2'];
	
	if (($nome && $local && $data && $id_prova && $id_distancia && $organizacao1 && $organizacao2) != ''){
		$result = mysqli_query($link, "SELECT * FROM prova WHERE data_prova = '$data' AND organizacao = '$organizacao'") or die(mysqli_error($link));

		if (mysqli_num_rows($result) == 0) {
			$insert = mysqli_query($link, "INSERT INTO prova (nome_prova, local, data_prova, id_tipo_prova, id_distancia, organizacao) VALUES ('$nome', '$local', '$data', '$id_prova', '$id_distancia', '$organizacao')") or die(mysqli_error());
			echo '<br><br><br><center>Foi inserida com sucesso a prova: <br><b>'.$nome.'</b>, realizada em <b>'.$local.'</b> no dia <b>'.$data.'</b>, organizada pelo <b>'.$organizacao.'</b>.</center><br><br><br><meta http-equiv="refresh" content="3; ./dashboard.php" />';
		} else {
			echo '<br><br><br><center>J&aacute; existe uma prova no mesmo dia (<b>'.$data.'</b>) organizada pelo mesmo clube <b>('.$organizacao.')</b>.</center><br><br><br><meta http-equiv="refresh" content="3; ./add_race.php" /> ';
		}
	} else {
		echo '<br><br><br><center>Preencha todos os campos.</center><br><br><br><meta http-equiv="refresh" content="2; ./" /> ';
	}
	include ('../footer.php');
?>