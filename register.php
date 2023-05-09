<html>
<head>
<title>Account Registration</title>
<link rel="stylesheet" type="text/css" href="login-register-style.css">
</head>
<body>


<br/>
<div class="register-block">
    <h1>Create New Account</h1>

    <form action="register.php" method="post">

    <div class="form_field_wrap">
        <input class="input" type="text" name="email" placeholder="Email" required><br/>
    </div>

    <div class="form_field_wrap">
        <input class="input" type="password" name="password" placeholder="Password"required><br/>
    </div>

    <div class="form_field_wrap">
        <input class="input" type="text" name="fname" placeholder="First Name"required><br/>
    </div>

    <div class="form_field_wrap">
        <input class="input" type="text" name="lname" placeholder="Last Name" required><br/>
    </div>

    <div class="form_field_wrap">
        <select class="custom-select" name="clevel" placeholder="Care Level" required>
                <option value="" disabled selected>Personal Care Level</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
        </select>
    </div>
   
    <div class="form_field_wrap">
        <input id="Register" type="submit" name="Register" value="Register">
    </div>

    </form>
</div>

<?php

require_once("config.php");
require_once("sqlTools.php");

if (isset($_SESSION["error"])) {
    echo "Something went wrong<br>";
    echo $_SESSION["error"];
    unset($_SESSION["error"]);
    die();
}

if (isset($_POST['Register'])) {
    unset($_POST['Register']);
  
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $clevel = htmlspecialchars($_POST['clevel']);

    if (strlen($email) == 0 || strlen($password) == 0) {
            $_SESSION["error"] = "email and/or password cannot be empty!";
            header("Location: register.php");
    }

    $db = get_pdo_connection();
    $statement = $db->prepare("CALL NewUser(?, ?, ?, ?, ?, ?)");

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $statement->bindParam(1, $email, PDO::PARAM_STR);
    $statement->bindParam(2, $password, PDO::PARAM_STR);
    $statement->bindParam(3, $fname, PDO::PARAM_STR);
    $statement->bindParam(4, $lname, PDO::PARAM_STR);
    $statement->bindValue(5, $clevel, PDO::PARAM_STR);
    $statement->bindParam(6, $hashed, PDO::PARAM_STR);

    if ($statement->execute()) {
        echo "Registered!"; 
        header("Location: home.php");
    }
    else {
        $_SESSION["error"] = $result["Error"];
        header("Location: register.php");

    }
}

?>

</body>
</html>

