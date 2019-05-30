<?php
	//require_once ('auth.php');
	require_once('connect.php');
	require_once('./../calendar/tc_calendar.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	$organizacao1 = mysqli_query($link, "SELECT * FROM (SELECT 1 AS id, id_club, abbrev FROM clubs WHERE id_club < 1001 UNION ALL SELECT 2 AS id, id_club, abbrev FROM clubs WHERE id_club > 1000) a ORDER BY id, abbrev") or die(mysqli_error($link));
	$organizacao2 = mysqli_query($link, "SELECT * FROM (SELECT 1 AS id, id_club, abbrev FROM clubs WHERE id_club < 1001 UNION ALL SELECT 2 AS id, id_club, abbrev FROM clubs WHERE id_club > 1000) a ORDER BY id, abbrev") or die(mysqli_error($link));
?>
	<script language="javascript" src="./../calendar/calendar.js"></script>
	<center><p><b>INSERIR EVENTO</b></p><br><br>
	<table>
		<form action="add_event_done.php" method="post">
			<tr>
				<td></td>
				<td><b>Nome do Evento: </b></td>
				<td><input type="text" maxlength="200" name="nome"></td>
				<td><b>Local: </b></td>
				<td><input type="text" maxlength="60" name="local"></td>
				<td><b>Org. 1 </b></td>
				<td><select name="organizacao1"><?php while ($org1 = mysqli_fetch_assoc($organizacao1)) {?>
				<option value="<?php echo $org1['id_club'];?>"><?php echo utf8_encode($org1['abbrev']); }?></option></select></td>
				<td><b>Org. 2 </b></td>
				<td><select name="organizacao2"><option value="NULL">-</option><?php while ($org2 = mysqli_fetch_assoc($organizacao2)) {?>
				<option value="<?php echo $org2['id_club'];?>"><?php echo utf8_encode($org2['abbrev']); }?></option></select></td>
				</tr>
			
	</table><br>
	<input type="submit" name="submit" value="Adicionar">
	</form>
	</center><br><br>
	
<?php include ('../footer.php'); ?>