<?php
	$error = "";
	
	
	if(isset($_POST["btnSubmit"])){
		
		require_once("connection.php");
		//require_once("encryptDecrypt.php");
		
		
		$vidtype = $_FILES['vidFile']['type'];
		
		/*
		$vidsize = $_FILES['vidFile']['size'];
		$vidname = $_FILES['vidFile']['name'];
		$imgsize = $_FILES['imgFile']['size'];
		$imgname = $_FILES['imgFile']['name'];pronounce
		*/
		$imgtype = $_FILES['imgFile']['type'];
		
		$audtype = $_FILES['audFile']['type'];
		
		$vidDir = "wordVideos/";
		$imgDir = "wordImages/";
		$audDir = "wordAudios/";
		
		if(!($vidtype == "video/mp4")){
			$error .= "Only mp4 Videos Allowed";
		}
		
		if(!($imgtype == "image/png")){
			$error .= "Only png images Allowed";
		}
		
		if(!($audtype == "audio/mpeg")){
			$error .= "Only .mp3 Audio Allowed";
		}
		
		//$imgType = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
		//$vidType = strtolower(pathinfo($vidFile,PATHINFO_EXTENSION));
		if(empty($error)){
			
			$txtWord = $conn->real_escape_string(trim($_POST['txtWord']));
			$txtMorpheme = $conn->real_escape_string(trim($_POST['txtMorpheme']));
			$txtPartSpeech = $conn->real_escape_string($_POST['txtPartSpeech']);
			$txtMeaning = $conn->real_escape_string($_POST['txtMeaning']);
			
			
			$txtExplain = $conn->real_escape_string($_POST['txtExplain']);
			$txtExample = $conn->real_escape_string($_POST['txtExample']);
			
			
									
			try{
				$sql = "INSERT INTO tblWords (word, morphology, partOfSpeech, meaning, explanations, exampleUsage ) 
										VALUES ('$txtWord','$txtMorpheme','$txtPartSpeech', '$txtMeaning','$txtExplain', '$txtExample')";
				
				if ($conn->query($sql) == TRUE) {
					$wordID = $conn->insert_id;
					//move media files to locations and update database
					$audFile = $audDir.$txtWord.$wordID.".mp3";
					$vidFile = $vidDir.$txtWord.$wordID.".mp4";
					$imgFile = $imgDir.$txtWord.$wordID.".png";
					move_uploaded_file($_FILES["vidFile"]["tmp_name"], $vidFile);
					move_uploaded_file($_FILES["imgFile"]["tmp_name"], $imgFile);
					move_uploaded_file($_FILES["audFile"]["tmp_name"], $audFile);
					
					$sql = "UPDATE tblWords SET  audio='$audFile', video='$vidFile', image='$imgFile' WHERE wordID = $wordID";
					$conn->query($sql);
					
				}
			}catch(Excepyion $e){
				
				$error = "Word Addition Error. Try Again!!!";
			}
				
			
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dictionary Web App</title>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	
    <?php
        include_once("header.php");
    ?>
    <div class="row">
        <div class="col-3">
            
        </div>
    
        <div class="col-9">
            <div class="mainContainer formDive">
                
                <form action="addWordPhrase.php" method="POST" id="frmAddWord" enctype="multipart/form-data">
                    <div class="row">
					
                        <h1>Add Word to Dictionary </h1>
						<h3 color='red'><?php print($error); ?>
                        <input type = "text" id="txtWord" name="txtWord" placeholder="Word Here" required>
						<input type = "text" id="txtMorpheme" name="txtMorpheme" placeholder="Transcript Here" >
						<input type = "text" id="txtPartSpeech" name="txtPartSpeech" placeholder="Part of Speech Here">
						<input type = "text" id="txtMeaning" name="txtMeaning" placeholder="English Meaning Here" required>
						<input type = "text" id="txtExplain" name="txtExplain" placeholder="Explanations Here" required>
						<input type = "text" id="txtExample" name="txtExample" placeholder="Example Usage Here" required>
						Pronounciation (.mp3) <input type = "file" id="audFile" name="audFile" placeholder="Upload Audio Pronounciation Here" ><br />
						
						Image Illustration (.png)<input type = "file" id="imgFile" name="imgFile" placeholder="Upload Image Illustration Here" ><br />
						
						Video Illustration (.mp4)<input type = "file" id="vidFile" name="vidFile" placeholder="Upload Video Illustration Here" ><br />
						
                        <input type="submit" value="Submit" name='btnSubmit' id='btnSubmit'>
						
                    </div>
                    
                </form>
            </div>
        </div>

        <div class="col-2">
            
		</div>
    </div>

    
    <?php
        require_once('footer.php')
    ?>
	
</body>
</html>

