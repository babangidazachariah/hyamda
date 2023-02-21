<?php
SESSION_START();
	$error = "";
	if((!empty($_SESSION["userName"]) && (!empty($_SESSION["userEmail"])))){ //User has successfully login to system.
		require_once("connection.php");
		
	
		if(isset($_POST["btnSubmit"])){
			
			require_once("connection.php");
			//require_once("encryptDecrypt.php");
			
			
			$vidtype = $_FILES['vidFile']['type'];
			
			
			$imgtype = $_FILES['imgFile']['type'];
			
			$vidDir = "postVideos/";
			$imgDir = "postImages/";
			
			
			if(!($vidtype == "video/mp4")){
				$error .= "Only mp4 Videos Allowed";
			}
			
			if(!($imgtype == "image/png")){
				$error .= "Only png images Allowed";
			}
			
			
			if(empty($error)){
				
				$txtForum = $conn->real_escape_string(trim($_POST['txtForum']));
				$author = $_SESSION['userName'];
				$dateTime = Date('Y-m-d-H:i:s');
				
				try{
					$sql = "INSERT INTO tblPost (postContent, postAuthor, postDateTime, postStatus) 
											VALUES ('$txtForum','$author','$dateTime', 1)";
					
					if ($conn->query($sql) == TRUE) {
						$postID = $conn->insert_id;
						//move media files to locations and update database
						
						$vidFile = $vidDir."postImage".$postID.".mp4";
						$imgFile = $imgDir."postVideo".$postID.".png";
						move_uploaded_file($_FILES["vidFile"]["tmp_name"], $vidFile);
						move_uploaded_file($_FILES["imgFile"]["tmp_name"], $imgFile);
						
						
						$sql = "UPDATE tblPost SET  postVideo='$vidFile', postImage='$imgFile' WHERE postID = $postID";
						$conn->query($sql);
						
					}
				}catch(Excepyion $e){
					
					$error = "Word Addition Error. Try Again!!!";
				}
					
				
			}
		}
		
		
		
	}else{//User is yet to successfully login to system
		header("location:login.php");
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
        <div class="col-2">
			<div class="userProfile">
				<img src="images/genericDp.png" alt="User Photo" />
				<h3> Babangida Zachariah </h3>
				<h5>logged on as: babangida</h5>
			</div>
		</div>
		
        <div class="col-9">
            <div class="post">
                
				
					<div class="row">
                        
						<form name="frmPostFrum" id="frmPostFrum" method="POST" action="hyamForum.php" class="frmPostFrum" enctype="multipart/form-data">
							<h3>@<?php print($_SESSION['userName']); ?>:</h3>
							<input type="textarea" name ="txtForum" id ="txtForum" rows="4" placeholder="Post a New Learning  Content"></textarea>
							
							Image Illustration (.png)<input type = "file" id="imgFile" name="imgFile" placeholder="Upload Image Illustration Here" ><br />
						
							Video Illustration (.mp4)<input type = "file" id="vidFile" name="vidFile" placeholder="Upload Video Illustration Here" ><br />
						
							<input type="submit" value="Submit" name='btnSubmit' id='btnSubmit'>
						</form>
                    </div>
                    <!--<div class="row">
                        <button type="button" class="collapsible">Open Section 3</button>
							<h3>@Username:
							<input type="textarea" name ="txtForum" id ="txtForum" placeholder="Post a New Learning  Content"></textarea>
							
							Image Illustration (.png)<input type = "file" id="imgFile" name="imgFile" placeholder="Upload Image Illustration Here" ><br />
						
							Video Illustration (.mp4)<input type = "file" id="vidFile" name="vidFile" placeholder="Upload Video Illustration Here" ><br />
						
							<input type="submit" value="Submit" name='btnSubmit' id='btnSubmit'>
							
						</div>

                    </div>-->
					<?php
					
						$offset = 0;
						$strPost = "";
						if(!empty($_GET['offID'])){
							$offset = $_GET['offID'];
						}
						function GetTitle($string){
							$wordsreturned = 10;
							$retval = $string;  //  Just in case of a problem
							$array = explode(" ", $string);
							/*  Already short enough, return the whole thing*/
							if (count($array)<=$wordsreturned){
								$retval = $string;
							}else{ /*  Need to chop of some words*/
								array_splice($array, $wordsreturned);
								$retval = implode(" ", $array)." ...";
							}
							return $retval;
						}
						$sql = "SELECT * FROM tblPost ORDER BY postDateTime LIMIT $offset, 10";
						$result = $conn->query($sql);
						if($result->num_rows > 0){
							
							while($row = $result->fetch_assoc()){
								$post = $row['postContent'];
								$title = GetTitle($post);
								$strPost = '
									<div class="row">
										<button type="button" class="collapsible">'.$title.'</button>
										<div class="content">
										  <p>'.$post.'</p>';
								if(!empty($row['postImage'])){
									$strPost .='<img src="'.$row['postImage'].'" alt="PostPicture" />';
								}
								if(!empty($row['postVideo'])){
									$strPost .= '<video id="vid'.$row['postID'].'" style="margin-left:2px;" width="300px" height="200px" controls>
												<source id="vdoExample" src="'.$row['postVideo'].'" type="video/mp4">
												Your browser does not support HTML video.
											</video>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
											<button type="button" id ="btnRportPost'.$row['postID'].'" onclick="ReportPost('."'".$row['postID']."','".'btnRportPost'.$row['postID']."'".');" >Report Post</button>';
								}
								$strPost .= '</div></div>';
								print($strPost);
							}
						}
					
					?>
                    
				
                    
                </div> 
				
			</div>
        </div>
		
        
    </div>

    
    <?php
        require_once('footer.php')
    ?>
	
	<div class="col-1">
		
	</div>
	<script>
		var coll = document.getElementsByClassName("collapsible");
		var i;

		for (i = 0; i < coll.length; i++) {
		  coll[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var content = this.nextElementSibling;
			if (content.style.maxHeight){
			  content.style.maxHeight = null;
			} else {
			  content.style.maxHeight = content.scrollHeight + "px";
			} 
		  });
		}
		
		
		
		function ExecuteTasks(fncUrl) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//return successfull execution status to the calling function
					//alert(xhttp.responseText);
					return true;
				}else{
					//execution failure
					return false;
				}
			};
		  xhttp.open("GET", fncUrl, true);
		  xhttp.send();
		}
		
		
		//Report Post
		function ReportPost(postID, btn){
			//Function to report a post
			
			var btnRpt = document.getElementById(btn);
			
			var fncUrl ="ajaxExecuted.php?func=ReportPost&pID="+ postID;
			
			status = ExecuteTasks(fncUrl);
			
			document.getElementById(btn).innerHTML = 'Reported';				
			
			
		}
	</script>
</body>
</html>

