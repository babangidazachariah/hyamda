<?php
SESSION_START();
	$error = "";
	if(isset($_POST["btnSubmit"])){
		
		require_once("connection.php");
		require_once("encryptDecrypt.php");
		
		$email = $conn->real_escape_string($_POST['txtEmail']);
		$pass = $conn->real_escape_string($_POST['txtPassword']);
		
		$sql = "SELECT * FROM tblUsersLogin WHERE userEmail = '$email'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			
			while($row = $result->fetch_assoc()){
				if($pass == Decrypt($row['userPWord'])){
					print("Here");
					$_SESSION['userName'] = $row['userName'];
					$_SESSION['userEmail'] = $row['userEmail'];
					header("location:hyamForum.php");
				}
			}
		}
		$error = "Email or Password Error. Try Again!!!";
		
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
                
                <form action="login.php" method="POST" id="frmLogin">
                    <div class="row">
                        <h1> User Login </h1>
						<h3 style="color:red;">
						<?php
							print($error);
						?>
                        </h3>
						<input type = "email" id="txtEmail" name="txtEmail" placeholder="Email Here" required>
						<input type = "password" id="txtPassword" name="txtPassword" placeholder="Password Here" required>
                        <input type="submit" value="Submit" name='btnSubmit' id='btnSubmit'>
						<h4>Do not have an account yet? <a href="register.php">Register Here</a></h4>
                    </div>
                    
                </form>
            </div>
        </div>

        
    </div>

    
    <?php
        require_once('footer.php')
    ?>
	<div class="col-2">
		
	</div>
	
	<script>
		
	</script>
</body>
</html>

