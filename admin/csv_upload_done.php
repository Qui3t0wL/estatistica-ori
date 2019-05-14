<?php

	//require_once('auth.php');
	require_once('connect.php');
	include ('./../header.php');
	include ('./menu_lateral.php');
    
    include "./../functions/verifica_atleta.php";
    //include "./../functions/dados.php";
	
	$prova = $_POST['prova'];
	$allowedExtension = array("csv");
	
	foreach ($_FILES as $file) {
		if ($file['tmp_name'] > '') {
			if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtension)) {
				die('<center>'.$file['name'].' &eacute; um ficheiro inv&aacute;lido!<br/>'.
				'</center><meta http-equiv="refresh" content="2; csv_upload.php" />');
			}
		}
	}
	
	$target_path = "../files/prova_".$prova.".csv";
	
	if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $target_path)) {
		echo "<center><br><br>O ficheiro foi carregado com sucesso!<br><br></center>";
	} else{
		echo "<center>Houve um erro no upload do ficheiro. Verifique o ficheiro e a sua localiza&ccedil;&atilde;o antes de tentar de novo!</center>";
	}
    
    $fez_prova = verifica_atleta($prova);

    if($fez_prova == 1){
        //faz update do tempo do vencedor e cria novo ficheiro CSV apenas com os atletas de elite
        //faz insert de todos os atletas do mesmo escalao na BD
        copia_dados_ficheiro($prova);
    }
    
	include ('./../footer.php');
?>