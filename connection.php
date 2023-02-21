<?php
	//require_once ("connection.php");
    $username = "b35bfc72e5de73";
    $pass = "d0de149c"; 
    $host = "us-cdbr-east-06.cleardb.net"; 
    $dbase = "heroku_b1434386a052247";
    // Connect to DB: mysql://b35bfc72e5de73:d0de149c@us-cdbr-east-06.cleardb.net/heroku_b1434386a052247?reconnect=true
    
    $conn = new mysqli($host, $username, $pass, $dbase);
   
    //mysql://b35bfc72e5de73:d0de149c@us-cdbr-east-06.cleardb.net/heroku_b1434386a052247?reconnect=true
    //$con = new mysqli("heroku_b1434386a052247", "b35bfc72e5de73", "d0de149c", "heroku_b1434386a052247" ); 
    
    if($conn->connect_error){

        print("Failed to connect to MySQL: " . $conn->connect_error);
        exit();
    }
?>