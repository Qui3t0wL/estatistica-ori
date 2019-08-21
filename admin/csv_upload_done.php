<?php
	//require_once('auth.php');
	require_once('connect.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
    
    include "./../functions/verifica_atleta.php";
    include "./../functions/dados.php";
	
	$prova = $_POST['prova'];
	$allowedExtension = array("csv");
	
	foreach ($_FILES as $file) {
		if ($file['tmp_name'] > '') {
			$st = explode(".", strtolower($file['name']));
			if (!in_array(end($st), $allowedExtension)) {
				die('<center>'.$file['name'].' &eacute; um ficheiro inv&aacute;lido!<br/>'.
				'</center><meta http-equiv="refresh" content="2; csv_upload.php" />');
			}
		}
	}
	
	$target_path = "../files/prova_".$prova.".csv";
	
	if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $target_path)) {
		echo "<center><br><br>O ficheiro foi carregado com sucesso!<br><br></center><meta http-equiv='refresh' content='2; csv_upload.php' />";
	} else{
		echo "<center>Houve um erro no upload do ficheiro. Verifique o ficheiro e a sua localiza&ccedil;&atilde;o antes de tentar de novo!</center><meta http-equiv='refresh' content='2; csv_upload.php' />";
	}
	
	$new = new_csv_version ($prova);
    $fez_prova = verifica_atleta ($prova, $new, $link);

	//se fez prova carrega os resultados na tabela data
    if($fez_prova == 1){
		//faz insert de todos os atletas do mesmo escalao na BD
		insert_data_db ($prova, $new, $link);
		//faz update do tempo do vencedor e velocidade
		update_myresults($prova, $link);
		// calcula os pontos 
		calcular_pontos($prova, $link);
		// e cria novo ficheiro CSV apenas com os atletas de elite**
		//copia_dados_ficheiro ($prova, $link);
    }
    
	include ('./../footer.php');
?>