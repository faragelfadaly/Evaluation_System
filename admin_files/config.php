<?php

    function config($var, $val = NULL){
		static $vars = array();
		
		if($val !== NULL){ // set $var
			$vars[$var] = $val;
		}
		
		return $vars[$var];
	}
	
	function connectToDB(){    // Defined function to connect to database
		$link = @mysqli_connect(
			config('db-server'),
			config('db-username'),
			config('db-password'),
			config('db-name')
		);
		
		if(!$link){
			die("Mysql Database connection error " . mysqli_connect_errno() . ": " . mysqli_connect_error()."<span style='color:red'> try again later</style>");
		}
		
		return $link;
	}
        
        function executeQuery($query)  // Defined function to execute database query
        {
                $link=connectToDB();
                $query=  mysqli_query($link,$query);
                if(!$query)                    
                {
                    die("Mysql Query Error".mysqli_error($link)."<span style='color:red'> try again later</style>");                    
                }                
                return $query;
        }

    config('db-server', 'localhost');
    config('db-username', 'root');
    config('db-password', 'root');
    config('db-name', 'evaluation_sys');
?>        
