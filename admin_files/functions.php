<?php
	function config($var, $val = NULL){
		static $vars = array();
		
		if($val !== NULL){ // set $var
			$vars[$var] = $val;
		}
		
		return $vars[$var];
	}
	
	function connectToDB(){
		$link = @mysqli_connect(
			config('db-server'),
			config('db-username'),
			config('db-password'),
			config('db-name')
		);
		
		if(!$link){
			die("Mysql connection error " . mysqli_connect_errno() . ": " . mysqli_connect_error());
		}
		
		return $link;
	}