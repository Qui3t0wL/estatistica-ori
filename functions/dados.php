<?php

function velocidade($tempo, $distancia)
{
    $time = explode(":",$tempo);
    
    if($time[0] > "04"){
		$time_minutos = ($time[0]*60+$time[1])/60;
		$modulo = ($time_minutos / $distancia)-intval(($time_minutos / $distancia));
		$velocidade = ($time_minutos / $distancia)-$modulo+$modulo*0.6;
	} else {
		$time_horas = ($time[0]*3600+$time[1]*60+$time[2])/60;
		$modulo = ($time_horas / $distancia) - intval($time_horas / $distancia);
		$velocidade = ($time_horas / $distancia) - $modulo + ($modulo*0.6);
	}

    return round($velocidade, 2);
}

function getMyTimeDiff($t1,$t2)
{
	$a1 = explode(":",$t1);
	$a2 = explode(":",$t2);
	$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
	$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
	$diff = abs($time1-$time2);
	
	$hours = floor($diff/(60*60));
	$mins = floor(($diff-($hours*60*60))/60);
	$secs = floor(($diff-(($hours*60*60)+($mins*60))));
	
	if($hours == 0)
		$result = "00:".$mins.":".$secs;
	elseif ($hours == 0 && $mins == 0)
		$result = "00:00:".$secs;
	else 
		$result = $hours.":".$mins.":".$secs;
	
	return $result;
}

function converte_tempo($tempo) {
	$tim = explode(":",$tempo);
					
	if($tim[0] > "04"){
		$tim[2] = $tim[1];
		$tim[1] = $tim[0];
		$tim[0] = 0;
		$time_fixed =  $tim[0].":".$tim[1].":".$tim[2];
	} else {
		$time_fixed = $tempo;
	}
	return $time_fixed;
}

function devolve_bandeira($pais)
{
    $file="./files/flags.csv";
    if (($fp = fopen($file, "r") or die("Couldn't open $file"))!== FALSE) {
        while (($data = fgetcsv($fp, 1000, ";"))!== FALSE) {
            if ($data[0] == $pais){
                return $abr_band=$data[1];
            }
        }
        fclose($fp);
    }
    return $abr_band="por";
}

?>