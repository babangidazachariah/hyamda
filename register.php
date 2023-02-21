<?php
	$error = "";
	$fname = "";
	$mname = "";
	$lname = "";
	$uname = "";
	$email = "";
	$pass = "";
	$cpass = "";
	
	if(isset($_POST["btnSubmit"])){
		
		require_once("connection.php");
		require_once("encryptDecrypt.php");
		
		$fname = $conn->real_escape_string($_POST['txtFName']);
		$mname = $conn->real_escape_string($_POST['txtMName']);
		$lname = $conn->real_escape_string($_POST['txtLName']);
		$uname = $conn->real_escape_string($_POST['txtUName']);
		
		
		$email = $conn->real_escape_string($_POST['txtEmail']);
		$pass = $conn->real_escape_string($_POST['txtPWord']);
		$cpass = $conn->real_escape_string($_POST['txtCPWord']);
		
		
		$sql = "SELECT * FROM tblUsersLogin WHERE userEmail = '$email' OR userName ='$uname'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){ //Account Exist
			
			while($row = $result->fetch_assoc()){
				if($uname == $row['userName']){
					$error = "Username Already Taken. Try a different Username!!!";
				}
				if($email == $row['userEmail']){
					$error .= "Account Already Registered with this Email. <a href='login.php'>Click Here to Login</a>";
				}
			}
		}else{//Register Account
			try{
				$pass = Encrypt($pass);
				$sql = "INSERT INTO tblUsers (userEmail, userFName, userMName, userLName) VALUES ('$email','$fname','$mname', '$lname')";
				$result = $conn->query($sql);
				$sql = "INSERT INTO tblUsersLogin (userName, userEmail, userPWord) VALUES ('$uname','$email', '$pass')";
				$result = $conn->query($sql);
			}catch(Excepyion $e){
				$sql = "DELETE FROM tblUsers WHERE userEmail = '$email'";
				$result = $conn->query($sql);
				$error = "Registration Error. Try Again!!!";
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
                
                <form action="register.php" method="POST" id="frmRegister">
                    <div class="row">
                        <h1> User Registration </h1>
						<h3 style="color:red;">
						<?php
							print($error);
						?>
                        </h3>
                        <input type = "text" id="txtFName" name="txtFName" placeholder="First Name Here" required>
						<input type = "text" id="txtMName" name="txtMName" placeholder="Middle Name Here" >
						<input type = "text" id="txtLName" name="txtLName" placeholder="Last Name Here" required>
						<input type = "text" id="txtUName" name="txtUName" placeholder="Username Here" required>
						<input type = "email" id="txtEmail" name="txtEmail" placeholder="Email Here" required>
						<input type = "password" id="txtPWord" name="txtPWord" placeholder="Password Here" required>
						<input type = "password" id="txtCPWord" name="txtCPWord" placeholder="Confirm/Retype Pasword Here" required>
                        <input type="submit" value="Submit" name='btnSubmit' id='btnSubmit'>
						<h4>Already have an account? <a href="login.php">Login Here</a></h4>
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

