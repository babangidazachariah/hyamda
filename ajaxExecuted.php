<?php
SESSION_START();
	require_once("connection.php");
	
	
	function ReportPost($postID, $reporter, $mysqli){
		
		/*
		 A function report a post given a post ID and username of reporter		
		*/
		$dateTime = Date('Y-m-d-H:i:s');
		try{
			$sql = "INSERT INTO tblReportPost (postID, reporterUsername, reportDateTime) 
									VALUES ($postID,'$reporter','$dateTime')";
			
			if ($mysqli->query($sql) == TRUE) {
				return true;
				
			}else{
				return false;
			}
		}catch(Excepyion $e){
			
			return false;
		}
	}
	
	
	if(!(empty($_SESSION['userName']))){
		$rpter = $_SESSION['userName'];
		
		
		
		if((strcmp($_GET['func'], "ReportPost")) == 0){
			$pid = $_GET['pID'];
			
			if(is_numeric($pid)){
				
				print(ReportPost($pid, $rpter, $conn));
			}else{
				print("InputError");
			}
			
		}		
	}else{
		header("location:login.php");
	}
	
?>