<?php

/**
 * @author 
 * @copyright 2012
 */
 
include "./functions/verifica_atleta.php";
include "./functions/dados.php";
/*
$prova = 2;
$fez_prova = verifica_atleta($prova);
//copia_dados_ficheiro($prova);
//calcular_pontos($prova);

$mytime1 = "01:49:43";
$mytime2 = "01:50:10";
$cool = getMyTimeDiff($mytime1,$mytime2);
echo "<br>".$cool."<br>";

if($fez_prova == 1){
	echo "ccc";
	
} else echo "zero";


*/

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Filipe Dias - Orienteering Statistics</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="./css/styles.css" type="text/css" media="screen" />
</head>
<body>
	<table>
		<tr>
		<?php /*
			require "./admin/connect.php";
			$ep = mysql_query("SELECT distinct(season) as ep FROM race") or die(mysql_error());
			$season = mysql_fetch_assoc($ep);
			echo $season['ep'];
			
			mysql_num_rows($ep);
			*/
			//for($i=0;$i<=;$i++){
		?><td></td>
		</tr>
	</table>
	<center><b>ORIENTAÇÃO</b>
    <p>(since 2005)</p><br />
	<table>
		<tr>
			<td><div class="container"><img src="./images/account-hexagon.png" alt="Home" class="image" title="Home" height="200px"/></div></td>
			<td><div class="container"><img src="./images/globe.png" alt="Mapas" class="image" title="Mapas" height="200px"/></div></td>
            <td><div class="container"><img src="./images/calendar.png" alt="Épocas" class="image" title="Épocas" height="200px"/></div></td>
            <td><div class="container"><img src="./images/badge.png" alt="Estatisticas" class="image" title="Estatisticas" height="200px"/></div></td>
		</tr>
		<tr>
			
            <td>b</td>
            <td>b</td>
		</tr>
	</table></center>
</body>
</html>