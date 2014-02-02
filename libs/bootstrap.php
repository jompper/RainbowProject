<?php

function toSafePath($path){
	return preg_replace("/[^a-z-]/","-",strtolower(trim($path)));
}

function toCamelCase($string){
	$return = "";
	foreach(explode('-',strtolower($string)) as $word){
		$return .= ucfirst(trim($word));
	}
	return $return;
}
