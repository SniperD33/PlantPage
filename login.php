<?php
require_once("config.php");

function get_admin($email) {
    $db = get_pdo_connection();
    $query = $db->prepare("SELECT * FROM Admin WHERE Email = ?");
    $query->bindParam(1, $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}


if (isset($_POST["Login"])) {
    $login_email = $_POST["login_email"];
    $login_password = $_POST["login_password"];

    $admin = get_admin($login_email);

    // if no email or password is provided
    if (strlen($login_email) == 0 || strlen($login_password) == 0) {
        $_SESSION["login_error"] = "Email and Password cannot be empty.";
    }
    else if (count($admin) > 0) { // check for admin login
        $_SESSION["is_admin"] = true;
        
        $db = get_pdo_connection();
        $query = $db->prepare("SELECT HashPass FROM `Admin` WHERE Email = ?");
        $query->bindParam(1, $login_email, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($results) > 0) {
            $hash = $results[0]["HashPass"];
            // first row in results for column HashPass

            if (password_verify($login_password, $hash)) {
                $_SESSION["logged_in"] = true;
                $_SESSION["email"] = $login_email;

                header("Location: home.php");
            }
            else { 
                $_SESSION["login_error"] = "Invalid email and password combination.";
            }
        }
        else {
            $_SESSION["login_error"] = "Invalid email and password combination.";
        }
    }
    else { // account holder login 
        $_SESSION["is_admin"] = false; 
        
        $db = get_pdo_connection();
        $query = $db->prepare("SELECT HashPass FROM AccountHolder WHERE Email = ?");
        $query->bindParam(1, $login_email, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            $hash = $results[0]["HashPass"];
            // first row in results for column HashPass

            if (password_verify($login_password, $hash)) {
                $_SESSION["logged_in"] = true;
                $_SESSION["email"] = $login_email;

                header("Location: home.php");
            }
            else { 
                $_SESSION["login_error"] = "Invalid email and password combination.";
            }
        }
        else {
            $_SESSION["login_error"] = "Invalid email and password combination.";
        }
    }
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $PROJECT_NAME . " Login" ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="login-register-style.css">
</head>
<body>


<div id="form_block">
<h1><?= $PROJECT_NAME . " Login"?></h1>
<?php
$login_form = new PhpFormBuilder();
$login_form->set_att("method", "POST");
$login_form->add_input("Email", array(
    "type" => "text",
    "placeholder" => "Email",
    "required" => true
), "login_email");
$login_form->add_input("Password", array(
    "type" => "password",
    "placeholder" => "Password",
    "required" => true
), "login_password");
$login_form->add_input("Login", array(
    "type" => "submit",
    "value" => "Login"
), "Login");
$login_form->build_form();

// in case required fields are changed in browser dev tools
if (isset($_SESSION["login_error"])) {
    echo $_SESSION["login_error"] . "<br>";
    unset($_SESSION["login_error"]);
}

?>
</div>

</div id="plant-logo">
<img src="">
</div>

</body>
</html> 
