
<?php
	$searchResult = "";
	require_once("createDatabase.php"); //Connect and attempt creating tables yet created.
	if(isset($_POST['btnSearWord'])){
		
		
		$txtWord = $_POST['txtWord']; //Get user word for searching in tblWords
		
		$sql = "SELECT * FROM tblWords WHERE word LIKE '%".$txtWord."%'"; //format query search
		
		$result = $conn->query($sql); //execute query
		
		
		if(($result->num_rows) >= 0){ //word Exist if true
			
			while($row = $result->fetch_assoc()){ //print word and related information
				//print($row['word']."/" .$row['morphology']."/");
				
				$searchResult .= '<h3 id="tltHyamWord">'.$row['word'].'- /'.$row['morphology'].'/ ('.$row['partOfSpeech'].')</h3>';
				if(str_contains($row['audio'], ".mp3")){
					$searchResult .= '<audio z-index: -5000; controls>
										<source src="'.$row['audio'].'" type="audio/mpeg">
											Your browser does not support the audio element.
										</audio>';
				}
				
				$searchResult .= '<h3>English Meaning: </h3>
								<label id="lblEngMeaning">'.$row['meaning'].'</label>
								<h3 id="tltExplanation">Explanations: </h3>
								<label id="lblExplanation">'.$row['explanations'].' 
								</label>   
								<h3 id="tltExampleUsage">Example/Usage: </h3>
								<label id="lblExampleUsage">'.$row['exampleUsage'].'</label>
								</div>';
				
				if((str_contains($row['image'], ".mp4")) OR (str_contains($row['video'], ".mp4"))){//Contains Video
					$searchResult .= '<div class="row">
									<!--<h3 id="tltIllustration">Illustration: </h3>-->';
				}
				
				if(str_contains($row['image'], ".png")) { //There is an Image file
					$searchResult .= '<img id="imgPictureExample" width="300px" style="margin-right:2px;" height="200px" src="'.$row['image'].'" alt="Picture Showing Word/Phrase" />';
				}
				
				
				if(str_contains($row['video'], ".mp4")){//Contains Video
					$searchResult .= '<video id="vdoExample" style="margin-left:2px;" width="300px" height="200px" controls>
											<source id="vdoExample" src="'.$row['video'].'" type="video/mp4">
											Your browser does not support HTML video.
										</video>';
				}
					
						
					$searchResult .= '</div>';
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
        <div class="col-2" >
           
        </div>
    
        <div class="col-7">
            <div class="mainContainer">
                
                <form action="index.php" method="POST" id="frmIndex">
                   <div class="row">
                        <h1>Hyam Dictionary </h1>
                        <input type = "text"  id="txtWord" name="txtWord" placeholder="Word or Phrase Here" required>
                        <input type="submit" value="Search" name='btnSearWord' id='btnSearWord'>
                    </div>
					<?php print($searchResult); ?>
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

