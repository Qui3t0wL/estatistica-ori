<?php
	//require_once ('auth.php');
	require_once ('connect.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	$nome = $_POST['nome'];
	$local = $_POST['local'];
	$organizacao1 = $_POST['organizacao1'];
	$organizacao2 = $_POST['organizacao2'];
	
	if($organizacao2 == "NULL"){$organizacao2 = null;}

	if (($nome && $local && $organizacao1) != ''){
		$result = mysqli_query($link, "SELECT * FROM event WHERE event_name = '$nome' AND local = '$local' AND id_club_org1 = '$organizacao1'") or die(mysqli_error($link));

		if (mysqli_num_rows($result) == 0) {
			$insert = mysqli_query($link, "INSERT INTO event (event_name, local, id_club_org1, id_club_org2) VALUES ('$nome', '$local', '$organizacao1', '$organizacao2')") or die(mysqli_error($link));
			echo '<br><br><br><center>Foi inserida com sucesso a prova: <br><b>'.$nome.'</b>, realizada em <b>'.$local.'</b>, organizada pelo <b>'.$organizacao.'</b>.</center><br><br><br><meta http-equiv="refresh" content="2; ./dashboard.php" />';
		} else {
			echo '<br><br><br><center>J&aacute; existe um mesmo evento (<b>'.$nome.'</b>) organizada pelo mesmo clube <b>('.$organizacao1.')</b>.</center><br><br><br><meta http-equiv="refresh" content="2; ./add_race.php" /> ';
		}
	} else {
		echo '<br><br><br><center>Preencha todos os campos.</center><br><br><br><meta http-equiv="refresh" content="2; ./" /> ';
	}
	include ('../footer.php');
?>