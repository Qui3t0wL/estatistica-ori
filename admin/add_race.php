<?php
	//require_once ('auth.php');
	require_once('connect.php');
	require_once('./../calendar/tc_calendar.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	$tipo_prova = mysqli_query($link, "SELECT id_race_type, race_type_desc FROM race_type") or die(mysqli_error($link));
	$tipo_distancia = mysqli_query($link, "SELECT id_dist, dist_desc FROM distance") or die(mysqli_error($link));
	$organizacao1 = mysqli_query($link, "SELECT id_club, abbrev FROM clubs ORDER BY abbrev ASC") or die(mysqli_error($link));
	$organizacao2 = mysqli_query($link, "SELECT id_club, abbrev FROM clubs ORDER BY abbrev ASC") or die(mysqli_error($link));
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
				<td><b>Org. 1 </b></td>
				<td><select name="organizacao1"><?php while ($org = mysqli_fetch_assoc($organizacao1)) {?>
				<option value="<?php echo $org['id_club'];?>"><?php echo $org['abbrev']; }?></option></select></td>
				<td><b>Org. 2 </b></td>
				<td><select name="organizacao2"><option value="NULL">-</option><?php while ($org = mysqli_fetch_assoc($organizacao2)) {?>
				<option value="<?php echo $org['id_club'];?>"><?php echo $org['abbrev']; }?></option></select></td>
				</tr>
			<tr>
				<td><b>Data: </b></td>
				<td><?php
	  $myCalendar = new tc_calendar_("date5", true, false);
	  $myCalendar->setIcon("../images/iconCalendar.gif");
	  $myCalendar->setDate(date('d'), date('m'), date('Y'));
	  $myCalendar->setPath(".");
	  $myCalendar->setYearInterval(2005, 2030);
	  $myCalendar->dateAllow('2005-01-01', '2030-12-31');
	  $myCalendar->setDateFormat('j F Y');
	  //$myCalendar->setHeight(350);	  
	  //$myCalendar->autoSubmit(true, "form1");
	  $myCalendar->setAlignment('left', 'bottom');
	  $myCalendar->writeScript();
	  ?></td>
				<td><b>Tipo Prova: </b></td>
				<td><select name="id_prova"><?php while ($prova = mysqli_fetch_assoc($tipo_prova)) {?>
				<option value="<?php echo $prova['id_race_type'];?>"><?php echo $prova['race_type_desc']; }?></option></select></td>
				<td><b>Tipo Distância: </b></td>
				<td><select name="id_distancia"><?php while ($distancia = mysqli_fetch_assoc($tipo_distancia)) {?>
				<option value="<?php echo $distancia['id_dist'];?>"><?php echo $distancia['dist_desc']; }?></option></select></td>			
			</tr>
			
	</table><br>
	<input type="submit" name="submit" value="Adicionar">
	</form>
	</center><br><br>
	
<?php include ('../footer.php'); ?>