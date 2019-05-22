<?php

	require_once('connect.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
	
	//$epoca = $_SESSION['EPOCA'];
	
	$result = mysqli_query($link, "SELECT id_race, event_name, DATE_FORMAT(date,'%d/%m/%Y') as data, dist_desc FROM race, distance WHERE race.id_dist = distance.id_dist AND date <= now() ORDER BY date") or die(mysqli_error());
?>
	<center><p><b>CARREGAR FICHEIRO</b></p></center>
	<form action="csv_upload_done.php" enctype="multipart/form-data" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table width="50%" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr> 
          <td><b>Prova:</b></td>
          <td>
          <select name="prova"><?php while ($row = mysqli_fetch_assoc($result)) {?>
          	<option value="<?php echo $row['id_race'];?>"><?php echo $row['data'];?> | <?php echo $row['event_name'];?> | <?php echo $row['dist_desc']; }?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td><b>Ficheiro:</b></td>
          <td><input name="upload_file" type="file" id="file" size="50">
          <input type="submit" name="Submit" value="Submeter">
          </td>
        </tr>
      </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <center><p><b>ATEN&Ccedil;&Atilde;O: Ao fazer upload de um ficheiro j&aacute; carregado, ir&aacute; substituir o ficheiro j&aacute; existente.</b></p></center>
		<p>&nbsp;</p>
  </form>
 
<?php include ('./../footer.php');?>