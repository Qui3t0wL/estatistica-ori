<?php
	//require_once ('auth.php');
	require_once('connect.php');
	//require_once('./../calendar/tc_calendar.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	$tipo_prova = mysqli_query($link, "SELECT id_race_type, race_type_desc FROM race_type") or die(mysqli_error($link));
	$tipo_distancia = mysqli_query($link, "SELECT id_dist, dist_desc FROM distance") or die(mysqli_error($link));

	$result = mysqli_query($link, "SELECT id_race, event_name, race.id_event, DATE_FORMAT(date,'%d/%m/%Y') as data, dist_desc, stage FROM race, event, distance WHERE race.id_dist = distance.id_dist AND race.id_event = event.id_event AND date <= now() ORDER BY date") or die(mysqli_error($link));
?>
	<center><p><b>INSERIR PROVA</b></p><br><br>
	<table>
		<form action="add_race_done.php" method="post">
			<tr> 
				<td><b>Nome do Evento:</b></td>
				<td colspan="7">
				<select name="evento"><?php while ($row = mysqli_fetch_assoc($result)) {?>
					<option value="<?php echo $row['id_event'];?>"><?php echo $row['data'];?> | <?php echo utf8_encode($row['event_name']);?> - <?php  echo $row['stage'];?> | <?php echo utf8_encode($row['dist_desc']); }?></option>
				</select>
				</td>
			</tr>
			<tr>
				<td><b>Data: </b></td>
				<td><input type="text" maxlength="10" required pattern="(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}" placeholder="dd/mm/aaaa" name="data"></td>
				<td><b>Tipo Prova: </b></td>
				<td><select name="id_prova"><?php while ($prova = mysqli_fetch_assoc($tipo_prova)) {?>
				<option value="<?php echo $prova['id_race_type'];?>"><?php echo utf8_encode($prova['race_type_desc']); }?></option></select></td>
				<td><b>Distância: </b></td>
				<td><select name="id_distancia"><?php while ($distancia = mysqli_fetch_assoc($tipo_distancia)) {?>
				<option value="<?php echo $distancia['id_dist'];?>"><?php echo utf8_encode($distancia['dist_desc']); }?></option></select></td>	
				<td><b>Etapa: </b></td>
				<td><input type="text" maxlength="2" required pattern="(E[1-9])" placeholder="E1, E2, etc" name="stage"></td>		
			</tr>
			
	</table><br>
	<input type="submit" name="submit" value="Adicionar">
	</form>
	</center><br><br>
	
<?php include ('../footer.php'); ?>