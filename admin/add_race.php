<?php
	//require_once ('auth.php');
	require_once('connect.php');
	require_once('./../calendar/tc_calendar.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	$tipo_prova = mysql_query("SELECT id_tipo_prova, designacao_prova FROM tipo_prova") or die(mysql_error());
	$tipo_distancia = mysql_query("SELECT id_distancia, designacao_dist FROM tipo_distancia") or die(mysql_error());
	$organizacao = mysql_query("SELECT DISTINCT organizacao FROM prova ORDER BY organizacao ASC") or die(mysql_error());
?>
	<script language="javascript" src="./../calendar/calendar.js"></script>
	<center><p><b>INSERIR PROVA</b></p><br><br>
	<table>
		<form action="add_race_done.php" method="post">
			<tr>
				<td><b>Nome da Prova: </b></td>
				<td><input type="text" maxlength="70" name="nome"></td>
				<td><b>Local: </b></td>
				<td><input type="text" maxlength="40" name="local"></td>
				<td><b>Data: </b></td>
				<td><?php
	  $myCalendar = new tc_calendar("date5", true, false);
	  $myCalendar->setIcon("../images/iconCalendar.gif");
	  $myCalendar->setDate(date('d'), date('m'), date('Y'));
	  $myCalendar->setPath("../");
	  $myCalendar->setYearInterval(2010, 2012);
	  $myCalendar->dateAllow('2010-01-01', '2015-12-31');
	  $myCalendar->setDateFormat('j F Y');
	  //$myCalendar->setHeight(350);	  
	  //$myCalendar->autoSubmit(true, "form1");
	  $myCalendar->setAlignment('left', 'bottom');
	  $myCalendar->writeScript();
	  ?></td>
			</tr>
			<tr>
				<td><b>Tipo Prova: </b></td>
				<td><select name="id_prova"><?php while ($prova = mysql_fetch_assoc($tipo_prova)) {?>
				<option value="<?php echo $prova['id_tipo_prova'];?>"><?php echo $prova['designacao_prova']; }?></option></select></td>
				<td><b>Tipo Distância: </b></td>
				<td><select name="id_distancia"><?php while ($distancia = mysql_fetch_assoc($tipo_distancia)) {?>
				<option value="<?php echo $distancia['id_distancia'];?>"><?php echo $distancia['designacao_dist']; }?></option></select></td>			
				<td><b>Org. </b></td>
				<td><select name="organizacao"><?php while ($org = mysql_fetch_assoc($organizacao)) {?>
				<option value="<?php echo $org['organizacao'];?>"><?php echo $org['organizacao']; }?></option></select></td>
			</tr>
			
	</table><br>
	<input type="submit" name="submit" value="Adicionar">
	</form>
	</center><br><br>
	
<?php include ('../footer.php'); ?>