<?php 
 
 function validaCampo($valor){
    $pattern = '/^[0-9]{11}$/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return false;
}
}

function validaNumero($valor){
    $pattern = '/^[0-9]{1,}+(\.|\,){0,}+[0-9]{0,}$/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return false;
}
}

?>