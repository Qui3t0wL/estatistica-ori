<?php

function new_csv_version($file) {
	require_once "./../admin/connect.php";

	$handler = fopen("./../files/prova_".$file.".csv", "r");
	$data = fgetcsv($handler, 1000, ";");

	if ($data[0] == "OE0014") {
		return 1;
	} else {
		return 0;
	}
}

/**
 * @author Filipe Dias
 * @copyright Junho 2012
 * 
 * Esta fun��o verifica se fiz a prova e faz update a tabela.
 * Basicamente procura pelo meu nome e pelo meu peitoral.
 *
 */

function verifica_atleta($prova, $new, $link) {

	require_once "./../admin/connect.php";
	
	$dados = array();
	$handler = fopen("./../files/prova_".$prova.".csv", "r");
	
		// verifica que tipo de ficheiro e'
		if ($new == 1) {
			while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
				if($data[4] == "3555" AND ($data[6] == "Filipe" AND $data[5] == "Dias")){
					for ($k=0; $k <= sizeof($data); $k++){
						if(!isset($data[$k])){
							$dados[$k] = null;
						}else
							$dados[$k] = $data[$k];
					}
					//vai buscar o id do escalao
					$escaloes = mysqli_query($link, "SELECT id_class, class_desc FROM class") or die(mysqli_error($link));
					while ($esc = mysqli_fetch_assoc($escaloes)) {
						// verifica se o escalao esta na base de dados
						if ($dados[25] == $esc['class_desc']) {
							// verifica se fiz MP
							if ($dados[14] == 0) {
								$id_cl = $esc['id_class'];
								$length = str_replace(",",".",$dados[54]);
								$sql_insert = mysqli_query($link, "INSERT INTO results(id_race, id_class, length, controls, climb, classif, mytime, mp) VALUES('$prova','$id_cl','$length','$dados[56]','$dados[55]','$dados[57]','$dados[13]','0')") or die(mysqli_error($link));
							} else {
								$id_cl = $esc['id_class'];
								$length = str_replace(",",".",$dados[54]);
								$sql_insert = mysqli_query($link, "INSERT INTO results(id_race, id_class, length, controls, climb, classif, mytime, mp) VALUES('$prova','$id_cl','$length','$dados[56]','$dados[55]','$dados[57]','$dados[13]','1')") or die(mysqli_error($link));
							}
						}
					}
					$f=1; break;
				} else { $f=0;}
			}
		} else {
			while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
				if($data[2] == "3555" AND ($data[4] == "Filipe" AND $data[3] = "Dias")){
				
					for ($k=0; $k <= sizeof($data); $k++){
						if(!isset($data[$k])){
							$dados[$k] = null;
						}else
							$dados[$k] = $data[$k];
					}
					//vai buscar o id do escalao
					$escaloes = mysqli_query($link, "SELECT id_class, class_desc FROM class") or die(mysqli_error($link));
					while ($esc = mysqli_fetch_assoc($escaloes)) {
						
						if ($dados[18] == $esc['class_desc']) {
							// verifica se fiz MP
							if ($dados[12] == 0) {
								$id_cl = $esc['id_class'];
								$length = str_replace(",",".",$dados[40]);
								$sql_insert = mysqli_query($link, "INSERT INTO results(id_race, id_class, length, controls, climb, classif, mytime, mp) VALUES('$prova','$id_cl','$length','$dados[42]','$dados[41]','$dados[43]','$dados[11]','0')") or die(mysql_error($link));
							} else {
								$id_cl = $esc['id_class'];
								$length = str_replace(",",".",$dados[40]);
								$sql_insert = mysqli_query($link, "INSERT INTO results(id_race, id_class, length, controls, climb, classif, mytime, mp) VALUES('$prova','$id_cl','$length','$dados[42]','$dados[41]','$dados[43]','$dados[11]','1')") or die(mysql_error($link));
							}
						}
					}
					$f=1; break;
				} else { $f=0;}
			}
		}
	return $f;
}

function insert_data_db ($prova, $new, $link) {
	
	require_once "./../admin/connect.php";
	include "dados.php";

	$handler = fopen("./../files/prova_".$prova.".csv", "r");
	$escalao = mysqli_query($link, "SELECT r.id_class, class_desc FROM results r, class c WHERE r.id_class = c.id_class AND r.id_race = '$prova'") or die(mysqli_error($link));
	$esc = mysqli_fetch_assoc($escalao);
	$row = 1;

	if ($new == 1) {
		while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
			for ($k=0; $k <= sizeof($data); $k++){
				if(!isset($data[$k])){
					$dados[$k] = null;
				}else
					$dados[$k] = $data[$k];
			}
			if ($dados[25] == $esc['class_desc']) {
				
				$id_cl = $esc['class_desc'];
				$length = str_replace(",",".",$dados[54]);
				$name = $dados[6]." ".$dados[5];
				$club = clean($dados[20], $link);
				
				if($row==1) {$winner=$dados[13];$row=0;}
				$time_behind = getMyTimeDiff($dados[13],$winner);

				if($dados[4]>9999 OR $dados[4] == null ){
					$bib = $dados[1];
				}else
					$bib = $dados[4];

				$sql_insert = mysqli_query($link, "INSERT INTO data(id_race, class, classif, bib, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','$id_cl',IF('$dados[14]'>0,0,'$dados[57]'),'$bib','$name','$dados[21]','$club','$dados[13]','$time_behind',IF('$dados[14]'>0,1,0),IF('$dados[10]'>0,1,0))") or die(mysqli_error($link));
			}
		}
	} else {
		while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
			for ($k=0; $k <= sizeof($data); $k++){
				if(!isset($data[$k])){
					$dados[$k] = null;
				}else
					$dados[$k] = $data[$k];
			}
			if ($dados[18] == $esc['class_desc']) {
				// ainda nao testado com ficheiros antigos
				//echo "YES";
				$id_cl = $esc['class_desc'];
				$length = str_replace(",",".",$dados[40]);
				$name = $dados[4]." ".$dados[3];
				$club = clean($dados[15], $link);
				
				// guarda o tempo do vencedor
				if($row==1) {$winner=$dados[11];$row=0;}
				$time_behind = getMyTimeDiff($dados[11],$winner);
				
				//verifica o numero do peitoral
				if($dados[2]>9999 OR $dados[2] == null ){
					$bib = $dados[0];
				}else
					$bib = $dados[2];

				// verifica se fez MP ou se e NC
				if($dados[12] > 0 OR $dados[8] == 'X' ) {$cl=0;} else $cl=$dados[43];

				$sql_insert = mysqli_query($link, "INSERT INTO data(id_race, class, classif, bib, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','$id_cl','$cl','$bib','$name','$dados[16]','$club','$dados[11]','$time_behind',IF('$dados[12]'>0,1,0),IF('$cl'=0,1,0))") or die(mysqli_error($link));
			}
		}
	}
}

function update_myresults($prova, $link) {

	require_once "./../admin/connect.php";
	
	// update do tempo do vencedor na tabela results
	$wintime = mysqli_query($link, "SELECT time FROM data WHERE id_race ='$prova' AND classif = 1") or die(mysqli_error($link));
	$win = mysqli_fetch_assoc($wintime);
	$w = $win['time'];
	$update = mysqli_query($link, "UPDATE results SET wintime = '$w' WHERE id_race = '$prova'") or die(mysqli_error($link));
	
	// update da velocidade na tabela results
	$speed =  mysqli_query($link, "SELECT length, mytime FROM results WHERE id_race ='$prova'") or die(mysqli_error($link));
	$vel = mysqli_fetch_assoc($speed);
	$veloc = velocidade($vel['mytime'], $vel['length']);
	$update = mysqli_query($link, "UPDATE results SET speed = '$veloc' WHERE id_race = '$prova'") or die(mysqli_error($link));
}


function copia_dados_ficheiro($prova, $link){
	
	require_once "./../admin/connect.php";
    include "dados.php";
	
	// verifica o escalao da prova
	$escalao = mysqli_query($link, "SELECT class_desc FROM results, class WHERE results.id_class = class.id_class AND id_race ='$prova'") or die(mysqli_error($link));
	
	if (mysqli_num_rows($escalao) == 1){
		$escalao1 = mysqli_fetch_assoc($escalao);
	}
	// abre ficheiro da prova
	$handler = fopen("./../files/prova_".$prova.".csv", "r");
	while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
		//$escalao1 = "HE";
        
		if($data[18] == $escalao1['class_desc']){
			if($flag == 0){ //a primeira celula HE que encontrar e o vencedor
				//if($data[16] == "POR"){
				$sql_insert = mysqli_query($link, "UPDATE results SET wintime = '$data[11]' WHERE id_race = '$prova'") or die(mysqli_error($link));
                
                $t1 = $data[11]; //guarda tempo do vencedor
                //$sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time) VALUES('$prova','$data[43]','$data[4] $data[3]','$data[16]','$data[15]','$data[11]')") or die(mysqli_error($link));
				//}
				$flag = 1;
			}
            
            if ($data[12] == 0){ //se n�o tiver mp
                if ($data[8] == "0"){ //se n�o tiver nc
                    //faz o insert normal
                    $tb = getMyTimeDiff($t1,$data[11]);
                    $sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','$data[43]','$data[4] $data[3]','$data[16]','$data[15]','$data[11]','$tb','0','0')") or die(mysqli_error($link));
                } else { //se fizer nc 
                    $tb = getMyTimeDiff($t1,$data[11]);
                    $sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','0','$data[4] $data[3]','$data[16]','$data[15]','$data[11]','$tb','0','1')") or die(mysqli_error($link));
                }
            } else { //se fizer mp
                $sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','0','$data[4] $data[3]','$data[16]','$data[15]','\0','\0','1','0')") or die(mysqli_error($link));
            }
            
			// dados no ficheiro: mp|nc|nacionalidade|nome|clube|tempo|dif_tempo			
			$fh = fopen("./../files/".$prova.".txt", "at");
			$dados_atleta = $data[12].";".$data[8].";".$data[16].";".$data[4]." ".$data[3].";".$data[15].";".$data[11].";".$tb.";\n";
			fwrite($fh, $dados_atleta);
			fclose($fh);
		}
	}
}

function calcular_pontos($prova, $link) {
	
	require_once "./../admin/connect.php";
	
	$pontos = mysqli_query($link, "SELECT TIME_TO_SEC(wintime) as tmpvenc, TIME_TO_SEC(mytime) as meutmp FROM results WHERE id_race = '$prova'") or die(mysqli_error($link));
	$pts = mysqli_fetch_assoc($pontos);
	$calculo_pts = round($pts['tmpvenc']/$pts['meutmp']*100, 2);
	
	$update = mysqli_query($link, "UPDATE results SET points = '$calculo_pts' WHERE id_race = '$prova'") or die(mysqli_error($link));				
}

?>