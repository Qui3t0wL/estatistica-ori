<?php

/**
 * @author Filipe Dias
 * @copyright 2017
 * 
 * 
 * INSERT INTO results (id_race, id_class, length, controls, climb, mytime, wintime) SELECT id_race, id_class, length, controls, climb, mytime, wintime FROM results WHERE id_result = 1;
 */

    require_once('connect.php');
	include ('./../header.php');
	include ('./menu_lateral.php');

	$race = mysqli_query($link, "SELECT id_race, DATE_FORMAT(date,'%d/%m/%Y') dat, local, event_name, o.abbrev ab, rt.race_type_desc rat FROM race r, organizers o, race_type rt WHERE id_season = 12 AND r.id_org1 = o.id_org AND r.id_race_type = rt.id_race_type ORDER BY date ASC") or die(mysqli_error());
	
?>
    <center><p><b>INSERIR PROVA</b></p><br><br>
    <table width="75%" id="listar_tabela">
    
            <tr>
				<td id="rank_table_header" style="text-align:center"><b>Data</b></td>
				<td id="rank_table_header" style="text-align:center"><b>Nome</b></td>
				<td id="rank_table_header" style="text-align:center"><b>Local</b></td>
				<td id="rank_table_header" style="text-align:center"><b>Organizador</b></td>
				<td id="rank_table_header" style="text-align:center"><b>Tipo prova</b></td>
                <td id="rank_table_header" style="text-align:center"><b>Tipo distancia</b></td>
                <td></td>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($race)) {
            //$tipo_prova = mysqli_query($link, "SELECT id_race_type, race_type_desc FROM race_type") or die(mysqli_error());
            $tipo_distancia = mysqli_query($link, "SELECT id_dist, dist_desc FROM distance") or die(mysqli_error());
            //$organizacao1 = mysqli_query($link, "SELECT id_org, abbrev FROM organizers GROUP BY abbrev ASC") or die(mysqli_error());
            //$organizacao2 = mysqli_query($link, "SELECT id_org, abbrev FROM organizers GROUP BY abbrev ASC") or die(mysqli_error());
            ?>
            <form action="update.php" method="post" name="" id="">
			<tr>
                <td><?php echo $row['dat']; ?></td>
                <td><?php echo $row['event_name']; ?></td>
                <td><?php echo $row['local']; ?></td>
                <td><?php echo $row['ab']; ?></td>
                <td><?php echo $row['rat']; ?></td>
                <!--
				<td><select name="org1"><?php while ($org1 = mysqli_fetch_assoc($organizacao1)) {?>
				<option value="<?php echo $org1['id_org'];?>"><?php echo $org1['abbrev']; }?></option></select></td>
                -->
				<td><select name="td"><option value="0"></option><?php while ($tp = mysqli_fetch_assoc($tipo_distancia)) {?>
				<option value="<?php echo $tp['id_dist'];?>"><?php echo $tp['dist_desc']; }?></option></select></td>
                <!--
                <td><select name="id_tipo_prova"><?php while ($prova = mysqli_fetch_assoc($tipo_prova)) {?>
				<option value="<?php echo $prova['id_race_type'];?>"><?php echo $prova['race_type_desc']; }?></option></select></td>
                -->
                <td>
					<input type="submit" name="submit" value="Update" style="height: 20px; width: 60px; font-size: 0.9em;">
					<input type="hidden" name="prova" value="<?php echo $row['id_race']; ?>" id="prova">
				</form>
                </td>
            </tr>
            <?php }?>
	</table><br>
	</center><br><br>
	
<?php include ('../footer.php'); ?>