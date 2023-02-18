<?php 	
function active_page($active){
	$page=array_pop(explode("/", $_SERVER['SCRIPT_NAME']));
	if($page=='#'.$active||$page=='#'.$active){
		return active;
	}
	else{
		return "";
	}
}
?>
 