<?php
/**
 * @author Filipe Dias
 * @copyright Junho 2012
 * 
 * Esta fun��o verifica se fiz a prova e faz update a tabela.
 * Basicamente procura pelo meu nome e pelo meu peitoral.
 *
 */

function verifica_atleta($prova) {

	require_once "./../admin/connect.php";
	
	$dados = array();
    
	$handler = fopen("./../files/prova_".$prova.".csv", "r");
	
	while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
			//echo $data[0]."\n";	
		if($data[2] == "3555" AND ($data[4] == "Filipe" AND $data[3] = "Dias")){
			
			for ($k=0; $k <= sizeof($data); $k++){
				$dados[$k] = $data[$k];
			}
			//print_r($dados);		
			//vai buscar o id do escalao
            $escaloes = mysqli_query($link, "SELECT id_class, class_desc FROM class") or die(mysql_error($link));
            while ($esc = mysql_fetch_assoc($escaloes)) {
				// mudar para [25]
				// verificar o tipo de ficheiro OE0014
                if ($dados[18] == $esc['class_desc']) {
					// verifica se fiz MP
                    if ($dados[12] == 0) {
                        $id_cl = $esc['id_class'];
                        $sql_insert = mysqli_query($link, "INSERT INTO results(id_race, id_class, length, controls, climb, classif, mytime, mp) VALUES('$prova','$id_cl','$dados[40]','$dados[42]','$dados[41]','$dados[43]','$dados[11]','0')") or die(mysql_error($link));
                    } else {
                        $id_cl = $esc['id_class'];
                        $sql_insert = mysqli_query($link, "INSERT INTO results(id_race, id_class, length, controls, climb, classif, mytime, mp) VALUES('$prova','$id_cl','$dados[40]','$dados[42]','$dados[41]','$dados[43]','$dados[11]','1')") or die(mysql_error($link));
                    }
                    
                }
            }
			$f=1; break;
		} else { $f=0;}
	}
	return $f;
}


/**
 * @author Filipe Dias
 * @copyright Junho 2012
 * 
 * Esta fun��o copia dados para um ficheiro txt.
 * 
 */

function copia_dados_ficheiro($prova){
	
	require_once "./../admin/connect.php";
    include "dados.php";
	
	$escalao = mysqli_query($link, "SELECT class_desc FROM results, class WHERE results.id_class = class.id_class AND id_race ='$prova'") or die(mysql_error($link));
	
	if (mysqli_num_rows($escalao) == 1){
		$escalao1 = mysqli_fetch_assoc($escalao);
	}

	$handler = fopen("./../files/prova_".$prova.".csv", "r");
	while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
		//$escalao1 = "HE";
        
		if($data[18] == $escalao1['class_desc']){
			if($flag == 0){ //a primeira celula HE que encontrar e o vencedor
				//if($data[16] == "POR"){
				$sql_insert = mysqli_query($link, "UPDATE results SET wintime = '$data[11]' WHERE id_race = '$prova'") or die(mysql_error($link));
                
                $t1 = $data[11]; //guarda tempo do vencedor
                //$sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time) VALUES('$prova','$data[43]','$data[4] $data[3]','$data[16]','$data[15]','$data[11]')") or die(mysql_error($link));
				//}
				$flag = 1;
			}
            
            if ($data[12] == 0){ //se n�o tiver mp
                if ($data[8] == "0"){ //se n�o tiver nc
                    //faz o insert normal
                    $tb = getMyTimeDiff($t1,$data[11]);
                    $sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','$data[43]','$data[4] $data[3]','$data[16]','$data[15]','$data[11]','$tb','0','0')") or die(mysql_error($link));
                } else { //se fizer nc 
                    $tb = getMyTimeDiff($t1,$data[11]);
                    $sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','0','$data[4] $data[3]','$data[16]','$data[15]','$data[11]','$tb','0','1')") or die(mysql_error($link));
                }
            } else { //se fizer mp
                $sql_insert_data = mysqli_query($link, "INSERT INTO data(id_race, classif, name, id_country, club, time, time_behind, mp, nc) VALUES('$prova','0','$data[4] $data[3]','$data[16]','$data[15]','\0','\0','1','0')") or die(mysql_error($link));
            }
            
			// dados no ficheiro: mp|nc|nacionalidade|nome|clube|tempo|dif_tempo			
			$fh = fopen("./../files/".$prova.".txt", "at");
			$dados_atleta = $data[12].";".$data[8].";".$data[16].";".$data[4]." ".$data[3].";".$data[15].";".$data[11].";".$tb.";\n";
			fwrite($fh, $dados_atleta);
			fclose($fh);
		}
	}
}

/**
 * @author Filipe Dias
 * @copyright Junho 2012
 * 
 * Esta fun��o atualiza os pontos na prova em quest�o.
 * 
 */

function calcular_pontos($prova) {
	
	require_once "./../admin/connect.php";
	
	$pontos = mysqli_query($link, "SELECT TIME_TO_SEC(wintime) as tmpvenc, TIME_TO_SEC(mytime) as meutmp FROM results WHERE id_race = '$prova'") or die(mysql_error($link));
	$pts = mysqli_fetch_assoc($pontos);
	$calculo_pts = round($pts['tmpvenc']/$pts['meutmp']*100, 2);
	
	$update = mysqli_query($link, "UPDATE results SET points = '$calculo_pts' WHERE id_race = '$prova'") or die(mysql_error($link));				
}


?>