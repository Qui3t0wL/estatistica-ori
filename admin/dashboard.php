<?php
	//require_once('auth.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
    
    include_once ('connect.php');

$count = 1;

//$num_provas = mysql_query("") or die(mysql_error());

$sums = mysqli_query($link, "SELECT s.season_desc epoca, count(*) as provas, round(sum(r.LENGTH),2) kms, sum(r.controls) pontos FROM results r, race ra, season s WHERE r.id_race = ra.id_race AND ra.id_season = s.id_season GROUP BY s.id_season ASC") or die(mysqli_error());

?>

<center><div style="text-align: center;"><b>Back Office</b></div><br /></center>
<center>
<table width="75%" id="rank_table">
    <tr id="rank_table_header">
		
		<td width="100px" style="text-align:center"><b>&Eacute;poca</b></td>
		<td width="100px" style="text-align:center"><b>Provas realizadas</b></td>
		<td width="%" style="text-align:center">&nbsp;<b>Sprint</b></td>
        <td width="%" style="text-align:center">&nbsp;<b>M&eacute;dia</b></td>
        <td width="%" style="text-align:center">&nbsp;<b>Longa</b></td>
        <td width="100px" style="text-align:center">&nbsp;<b>Kms totais</b></td>
        <td width="140px" style="text-align:center"><b>Pontos controlados</b></td>
	</tr>
    <?php while ($somas = mysqli_fetch_assoc($sums)){?>
    <tr class="d<?php echo ($count & 1); ?>">
        <td style="text-align:center"><?php echo $somas['epoca'];?></td>
  		<td style="text-align:center"><?php echo $somas['provas'];?></td>
		<td style="text-align:center"></td>
		<td style="text-align:center">&nbsp;</td>
        <td style="text-align:center">&nbsp;</td>
        <td style="text-align:center"><?php echo $somas['kms'];?></td>
        <td style="text-align:center">&nbsp;<?php echo $somas['pontos'];?></td>
    </tr>
    <?php $count++;}?>
</table>
</center><br />



<form method="post" action="load_race.php" style="text-align:left; text-indent: 300px;">
Escolha a época: <select name="epoca" >
	<option value="2011">2011</option>
</select>
<input type="submit" value="OK">
</form><p></p>
</center>
<?php include ('./../footer.php');?>