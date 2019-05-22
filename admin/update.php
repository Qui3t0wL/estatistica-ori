<?php 
	require_once('connect.php');
	//require ('functions.php');
	include ('./../header.php');
	include ('./menu_lateral.php');

	$prova = $_POST['prova'];
    //$id_tipo_prova = trim($_POST['id_tipo_prova']);
	//$org1 = $_POST['org1'];
    //$org2 = $_POST['org2'];
    $id_tipo_dist = trim($_POST['td']);
    
    $sql = mysqli_query($link, "UPDATE race SET id_dist = $id_tipo_dist WHERE id_race= $prova");
    echo '<br><br><br><center>Foi atualizada a prova!</center><br><br><br><meta http-equiv="refresh" content="1; ./update_race.php" />';
    /*
	if (($org2) != 0){
        $sql = mysqli_query("UPDATE race SET id_org1 = $org1 , id_org2 = $org2 , id_race_type = $id_tipo_prova WHERE id_race= $prova");
        echo '<br><br><br><center>Foi atualizada a prova!</center><br><br><br><meta http-equiv="refresh" content="1; ./update_race.php" />';
	} else {
        $sql = mysqli_query("UPDATE race SET id_org1 = $org1 , id_race_type = $id_tipo_prova WHERE id_race= $prova");
        echo '<br><br><br><center>Foi atualizada a prova!</center><br><br><br><meta http-equiv="refresh" content="1; ./update_race.php" />';
		}
*/
	include ('./../footer.php');?>