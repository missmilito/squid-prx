<?php 
$archivo = (fopen('noway.txt', 'w'));
$txt = "instagram"; 
if($archivo){
	fputs($archivo, $txt);
	}

fclose($archivo);
 ?>

