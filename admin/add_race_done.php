<?php
	//require_once ('auth.php');
	require_once ('connect.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	$data = trim($_POST['data']);
	$id_prova = trim($_POST['id_prova']);
	$id_distancia = trim($_POST['id_distancia']);
	$etapa = $_POST['stage'];
	$evento = $_POST['evento'];

	$dateTime = new DateTime($data);
	$formatted_date=date_format ( $dateTime, 'Y-d-m' );
	
	if (($evento && $data && $id_prova && $id_distancia && $etapa) != ''){
		//vai buscar epoca da prova
		$epoca = mysqli_query($link, "SELECT DISTINCT id_season FROM race r, event e WHERE r.id_event = e.id_event AND e.id_event = '$evento' ") or die(mysqli_error($link));
		$sea = mysqli_fetch_assoc($epoca);
		$s = $sea['id_season'];

		$result = mysqli_query($link, "SELECT * FROM race WHERE date = '$data' AND id_event = '$evento' AND id_race_type = '$id_prova' AND id_dist = '$id_distancia' AND stage = '$etapa' ") or die(mysql_error($link));

		if (mysqli_num_rows($result) == 0) {
			
			$insert = mysqli_query($link, "INSERT INTO race (id_season, date, id_event, id_race_type, id_dist, stage) VALUES ('$s', '$formatted_date', '$evento', '$id_prova', '$id_distancia', '$etapa')") or die(mysqli_error($link));
			echo '<br><br><br><center>Foi inserida com sucesso a etapa <b>'.$etapa.'</b>, de <b>'.$id_distancia.'</b> no dia <b>'.$data.'</b>.</center><br><br><br><meta http-equiv="refresh" content="3; ./dashboard.php" />';
		} else {
			echo '<br><br><br><center>J&aacute; existe uma prova no mesmo dia (<b>'.$data.'</b>).</center><br><br><br><meta http-equiv="refresh" content="3; ./add_race.php" /> ';
		}
	} else {
		echo '<br><br><br><center>Preencha todos os campos.</center><br><br><br><meta http-equiv="refresh" content="2; ./" /> ';
	}
	include ('../footer.php');
?>