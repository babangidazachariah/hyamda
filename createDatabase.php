<?php
	 require_once("connection.php");
    
    $sql = "CREATE TABLE IF NOT EXISTS tblWords (wordID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        word VARCHAR(50) NOT NULL,
                                                        morphology VARCHAR(10) NOT NULL,
                                                        partOfSpeech VARCHAR(20) NOT NULL,
                                                        meaning VARCHAR(100) NOT NULL,
														explanations VARCHAR(400),
                                                        exampleUsage VARCHAR(400),
														audio VARCHAR(50),
                                                        video VARCHAR(50),
														image VARCHAR(50),
                                                        PRIMARY KEY (wordID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql);
	
	
	$sql = "CREATE TABLE IF NOT EXISTS tblUsers (userID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        userEmail VARCHAR(50) NOT NULL,
                                                        userFName VARCHAR(30) NOT NULL,
                                                        userMName VARCHAR(30) ,
                                                        userLName VARCHAR(30) NOT NULL,
                                                        
                                                        PRIMARY KEY (userID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql); 
	$sql = "CREATE TABLE IF NOT EXISTS tblUsersLogin (userLoginID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        userName VARCHAR(50) NOT NULL,
                                                        userEmail VARCHAR(50) NOT NULL,
                                                        userPWord VARCHAR(50),
                                                  
                                                        PRIMARY KEY (userLoginID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql); 
	
	$sql = "CREATE TABLE IF NOT EXISTS tblAdmin (adminID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        userName VARCHAR(50) NOT NULL,
                                                        userFName VARCHAR(50) NOT NULL,
                                                        userMName VARCHAR(50) ,
                                                        userLName VARCHAR(50) NOT NULL,
                                                        userEmail VARCHAR(50) NOT NULL,
                                                        userPWord VARCHAR(100),
                                                        
                                                        PRIMARY KEY (adminID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql); 
	
	
	$sql = "CREATE TABLE IF NOT EXISTS tblPost (postID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        postContent VARCHAR(500) NOT NULL,
                                                        postAuthor VARCHAR(50) NOT NULL,
                                                        postDateTime DATETIME NOT NULL,
                                                        postStatus INTEGER NOT NULL,
                                                        postVideo VARCHAR(70),
														postImage VARCHAR(70),
														
                                                        PRIMARY KEY (postID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql); 
	
	
	
	$sql = "CREATE TABLE IF NOT EXISTS tblComments (commentID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        postID INTEGER NOT NULL,
                                                        comment VARCHAR(500) NOT NULL,
                                                        commentAuthor VARCHAR(50) ,
                                                        commentDate DATETIME NOT NULL,
                                                        commentStatus INTEGER NOT NULL,
                                                        
                                                        PRIMARY KEY (commentID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql); 
	
	
	$sql = "CREATE TABLE IF NOT EXISTS tblReportMembers (reportID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        reportedUsername VARCHAR(50) NOT NULL,
                                                        reporterComment VARCHAR(500) NOT NULL,
                                                        reporterUsername VARCHAR(50) ,
                                                        reportDateTime DATETIME NOT NULL,
                                                        
                                                        PRIMARY KEY (reportID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql); 
	
	
	$sql = "CREATE TABLE IF NOT EXISTS tblReportPost (reportID INTEGER NOT NULL AUTO_INCREMENT,														
                                                        postID INTEGER NOT NULL,
                                                        reporterComment VARCHAR(500) ,
                                                        reporterUsername VARCHAR(50) NOT NULL,
                                                        reportDateTime DATETIME NOT NULL,
                                                        
                                                        PRIMARY KEY (reportID)
                                                        )
                                                        ENGINE=MyISAM";
                                                        
   
    $conn->query($sql); 
	
	
?>