<?php
session_start();
include_once('admin/includes/connect.php');

$errors = array();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = $_POST['email'];

    if (empty($username)) {
        array_push($errors, "Username is required");
    } elseif (!preg_match("/^[a-zA-ZëË ]*$/", $username)) {
        array_push($errors, "Only letters and white space allowed");
    }

    if (empty($email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if($password != $confirmPassword){
        array_push($errors, "Password nuk eshte i njejt");
    }

    // Check if username or email already exists
    $query = "SELECT * FROM users WHERE username=:username OR email=:email";
    $checkQuery = $conn->prepare($query);
    $checkQuery->bindParam(':username', $username);
    $checkQuery->bindParam(':email', $email);
    $checkQuery->execute();
    $result = $checkQuery->fetchAll();

    foreach ($result as $row) {
        if ($row['username'] == $username) {
            array_push($errors, "Username already exists");
        }
        if ($row['email'] == $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $sqlQuery = $conn->prepare($sql);

        $sqlQuery->bindParam(':username', $username);
        $sqlQuery->bindParam(':password', $hashedPassword);
        $sqlQuery->bindParam(':email', $email);

        $sqlQuery->execute();

        echo "<script>alert('Register succesfully!')</script>";
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validation and Sanitization
    $username = htmlspecialchars($username);

    if (empty($username) || empty($password)) {
        array_push($errors, "Both username and password are required for login");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username=:username";
        $checkQuery = $conn->prepare($query);
        $checkQuery->bindParam(':username', $username);
        $checkQuery->execute();
        $result = $checkQuery->fetch();

        if ($result && password_verify($password, $result['password'])) {
            // Login successful
            $_SESSION['username'] = $username;
            if($result['role']==1)
            {
          
            echo "<script>alert('Login successful!')</script>";
            echo "<script>window.open('index.php','_self')</script>";
            }
            else{
                echo "<script>alert('Login successful!')</script>";
            echo "<script>window.open('user.php','_self')</script>";
            }
        } else {
            array_push($errors, "Invalid username or password");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Sign up / Login Form</title>
    <link rel="stylesheet" href="admin/assets/css/login.css?v=<?php echo time(); ?>">

</head>
<style>
body{
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	font-family: 'Jost', sans-serif;
	background: linear-gradient(to bottom, #0f0c29, #ffffff, #24243e);
}
.main{
	width: 350px;
	height: 500px;
	background: red;
	overflow: hidden;
	background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover;
	border-radius: 10px;
	box-shadow: 5px 20px 50px #000;
}
#chk{
	display: none;
}
.signup{
	position: relative;
	width:100%;
	height: 100%;
}
label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 60px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}
input{
	width: 60%;
	height: 20px;
	background: #e0dede;
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 10px;
	border: none;
	outline: none;
	border-radius: 5px;
}
button{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #573b8a;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
button:hover{
	background: #6d44b8;
}
.login{
	height: 460px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}
.login label{
	color: #573b8a;
	transform: scale(.6);
}

#chk:checked ~ .login{
	transform: translateY(-500px);
}
#chk:checked ~ .login label{
	transform: scale(1);	
}
#chk:checked ~ .signup label{
	transform: scale(.6);
}
</style>
<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
    
        

        <?php  if (count($errors) > 0) { ?>
    <div class="error">
        <?php foreach ($errors as $error) { ?>
        <p><?php echo $error ?></p>
        <?php } ?>
    </div>
    <?php } ?>




        <div class="signup">
            <form method="post">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="username" placeholder="username" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="password" required="">
                <input type="password" name="confirmPassword" placeholder="confirmPassword" required="">

                <button name="submit" >submit</button>
            </form>
        </div>

        <div class="login">
            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" placeholder="Username" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <button name="login">Login</button>
            </form>
        </div>
    </div>
</body>

</html>