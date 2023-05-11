<?php
require_once("config.php");

if (empty($_SESSION["logged_in"])) {
    header("Location: login.php");
}

if ($_SESSION["logged_in"] == false) {
    header("Location: login.php");
}

if ($_SESSION["is_admin"] == true) {
    header("Location: login.php");
}


// Handle any inserts/updates/deletes before outputting any HTML
$email1 = htmlspecialchars($_SESSION["email"]);
// UPDATE dateperformed
if (isset($_POST["update"]) 
    && !empty($_POST["update_data1"])
    && !empty($_POST["update_data2"])
    && !empty($_POST["update_data3"])) {
    $dataToUpdate1 = htmlspecialchars($_POST["update_data1"]);
    $dataToUpdate2 = htmlspecialchars($_POST["update_data2"]);
    $dataToUpdate3 = htmlspecialchars($_POST["update_data3"]);
    echo "updating $dataToUpdate ...";

    $db = get_pdo_connection();
    //$query = $db->prepare("update hello set data= ? where id = ?");
    $query = $db->prepare("CALL UpdateTaskDateNote(?, ?, ?)");
    $query->bindParam(1, $dataToUpdate1, PDO::PARAM_STR);
    $query->bindParam(2, $dataToUpdate2, PDO::PARAM_STR);
    $query->bindParam(3, $dataToUpdate3, PDO::PARAM_STR);
    if ($query->execute()) {    
        header( "Location: " . $_SERVER['PHP_SELF']);
    }
    else {
        echo "Error executing update query:<br>";
        print_r($query->errorInfo());
    }
}

// INSERT
//to add a new PersonalPlant --> 
if (isset($_POST["insert"])) {
    $db = get_pdo_connection(); //1.get connection save into var 
    $query = false;

    if (!empty($_POST["insert_data1"])  //to add a new plant
    && !empty($_POST["insert_data2"])
    && !empty($_POST["insert_data3"])) {
    $dataToInsert1 = htmlspecialchars($_POST["insert_data1"]);
    $dataToInsert2 = htmlspecialchars($_POST["insert_data2"]);
    $dataToInsert3 = htmlspecialchars($_POST["insert_data3"]);
    echo "inserting $dataToInsert2 ...";

    $query = $db->prepare("CALL AddPersonalPlant(?, ?, ?, ?)");   //2.prepare statement
    $query->bindParam(1, $email1, PDO::PARAM_STR);    //3. bind parameter
    $query->bindParam(2, $dataToInsert1, PDO::PARAM_STR);
    $query->bindParam(3, $dataToInsert2, PDO::PARAM_STR);
    $query->bindParam(4, $dataToInsert3, PDO::PARAM_STR);   }
    else if (!empty($_POST["insert_data_task1"]) 
    && !empty($_POST["insert_data_task2"]))   {         //to add a task
        $dataToInsert1 = htmlspecialchars($_POST["insert_data_task1"]);
        $dataToInsert2 = htmlspecialchars($_POST["insert_data_task2"]);
        echo "inserting $dataToInsert2 ...";
    
        $query = $db->prepare("CALL AddPPTask(?, ?, ?)");   //2.prepare statement
        $query->bindParam(1, $email1, PDO::PARAM_STR);    //3. bind parameter
        $query->bindParam(2, $dataToInsert1, PDO::PARAM_STR);
        $query->bindParam(3, $dataToInsert2, PDO::PARAM_STR);
  
    }
    if ($query->execute()) {    //4.execute
        header( "Location: " . $_SERVER['PHP_SELF']);//refreshes page so new data inserted shows
    }
    else {
        echo "Error executing insert query:<br>";
        print_r($query->errorInfo());
    }
}



// DELETE PPlant or DELETE planttask 
if (isset($_POST["delete"])) {

    echo "deleting...<br>";

    $db = get_pdo_connection();
    $query = false;
    if (!empty($_POST["delete_data"])) {    //delete plant
        echo "deleting plant...";
        $query = $db->prepare("delete from PersonalPlant where Email = ? AND PPName = ? ");
        $query->bindParam(1, $email1, PDO::PARAM_STR); 
        $query->bindParam(2, $_POST["delete_data"], PDO::PARAM_STR);
    }
    else if (!empty($_POST["delete_data1"]) && !empty($_POST["delete_data2"])) {
        echo "deleting task...";    //delete task
        $query = $db->prepare("DELETE FROM Performs
        WHERE PerformID IN (
          SELECT P.PerformID
          FROM Performs as P
          JOIN Task as T ON P.TaskID = T.TaskID
          JOIN PersonalPlant as PP ON P.PPID = PP.PPID
          WHERE PP.Email = ? AND T.TName = ? AND PP.PPName = ?);");
        $query->bindParam(1, $email1, PDO::PARAM_STR);
        $query->bindParam(2, $_POST["delete_data1"], PDO::PARAM_STR);
        $query->bindParam(3, $_POST["delete_data2"], PDO::PARAM_STR);
    }
    if ($query) {
        if ($query->execute()) {
            $_SESSION["affected_rows"] = $query->rowCount();
            header("Location: " . $_SERVER["PHP_SELF"]);
        }
        else {
            echo "Error executing delete query:<br>";
            print_r($query->errorInfo());
        }
        
    }
    else{
        echo "Unable to delete: no id or data specified<br>";
    }
}



// select * from AccountHolder
function get_user_info($email) {
    $db = get_pdo_connection();
    $query = $db->prepare("SELECT * FROM AccountHolder where Email = ?");
    $query->bindParam(1, $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}
$user = get_user_info($_SESSION["email"]);



//show all personal plants
function get_personal_plants($email) {
    $db = get_pdo_connection();
    $query = $db->prepare("SELECT  PPName as NickName, SciName as ScientificName,DateAdd as DateAdded, HomeEnv FROM PersonalPlant WHERE Email = ? order by NickName");
    $query->bindParam(1, $email, PDO::PARAM_STR);
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC); //rows is a php associate array

    return $rows;
}
$pplants = get_personal_plants($_SESSION["email"]);

//show personal plant tasks
function get_plant_task($email) {
    $db = get_pdo_connection();
    $query = $db->prepare("SELECT PPName as Nickname, Tname as Task, TDescrip as Description, Notes, PerformAgain FROM Performs natural join Task natural join PersonalPlant WHERE Email = ? order by PPName");
    $query->bindParam(1, $email, PDO::PARAM_STR);
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC); //rows is a php associate array

    return $rows;
}
$pplanttask = get_plant_task($_SESSION["email"]);


?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <!--<title><?= $PROJECT_NAME ?></title> -->
 <title>Plant Log</title>
 
<link rel="stylesheet" href="style.css">
</head>
<body>
   <style>
    body {
        background-color: #d2fab9;
    }
</style>
<h1>Plant Log</h1>
    <div id="navigation">
        <a href="plog.php">Plant Dictionary</a>
        <a href="pplog.php">Personal Plant Log </a>
        <a href="title.php">Brought to You by</a>
</div>

<?php
if (!empty($_SESSION["affected_rows"])) {
    echo "Deleted " . $_SESSION["affected_rows"] . " rows";
    unset($_SESSION["affected_rows"]);
}
?>


<!--show all ppplants-->
<div style="text-align:center;">
  <h2>All Plants</h2>
</div>
<?php
echo makeTable($pplants);
?>

<!--ppplant tasks-->
<div style="text-align:center;">
<h2>Personal Plant Tasks</h2>
</div>
<?php
echo makeTable($pplanttask);
?>

<!-- --------------->

<div class="container">
<div class="left">


<!--to add a new PersonalPlant -->
<div style="text-align:center;">
<h2>Add Personal Plant</h2>
</div>
<?php
$insert_form = new PhpFormBuilder();
$insert_form->set_att("method", "POST");


$insert_form->add_input("Plant being added", array(
    "type" => "text"
), "insert_data1");

$insert_form->add_input("Nickname", array(
    "type" => "data"
), "insert_data2");

$insert_form->add_input("Home environment", array(
    "type" => "data"
), "insert_data3");

$insert_form->add_input("Insert", array(
    "type" => "submit",
    "value" => "Insert"
), "insert");
$insert_form->build_form();
?>

<!-- delete personal plant -->
<div style="text-align:center;">
<h2>Delete Personal Plant</h2>
</div>

<?php
$delete_form = new PhpFormBuilder();
$delete_form->set_att("method", "POST");
$delete_form->add_input("Plant to delete", array(
    "type" => "text"
), "delete_data");
$delete_form->add_input("Delete", array(
    "type" => "submit",
    "value" => "Delete"
), "delete");
$delete_form->build_form();
?>
</div>


<div class="right">

<!--update task-->
<div style ="text-align:center;">
<h2>Update Task</h2>
</div>
<?php
$update_form = new PhpFormBuilder();
$update_form->set_att("method", "POST");

$update_form->add_input("Plant being updated", array(
    "type" => "text"
), "update_data1");

$update_form->add_input("Task to update", array(
    "type" => "text"
), "update_data2");

$update_form->add_input("Notes", array(
    "type" => "text"
), "update_data3");

$update_form->add_input("Update", array(    //this funct is for button
    "type" => "submit",
    "value" => "Update"
), "update");   //name on button
$update_form->build_form();

?>


<!-- delete task -->
<div style="text-align:center;">
<h2>Delete Task</h2>
</div>

<?php
$delete_form2 = new PhpFormBuilder();
$delete_form2->set_att("method", "POST");
$delete_form2->add_input("Task to delete", array(
    "type" => "text"
), "delete_data1");

$delete_form2->add_input("For what plant", array(
    "type" => "text"
), "delete_data2");

$delete_form2->add_input("Delete", array(
    "type" => "submit",
    "value" => "Delete"
), "delete");
$delete_form2->build_form();
?>  


<!--to add a new task -->
<div style="text-align:center;">
<h2>Add Task</h2>
</div>
<?php
$insert_form = new PhpFormBuilder();
$insert_form->set_att("method", "POST");


$insert_form->add_input("Task being added", array(
    "type" => "text"
), "insert_data_task1");

$insert_form->add_input("For what plant", array(
    "type" => "data"
), "insert_data_task2");

$insert_form->add_input("Insert", array(
    "type" => "submit",
    "value" => "Insert"
), "insert");
$insert_form->build_form();
?>


</div>

</div>
	<footer> <p> Plant Page</p></footer>
</body>
</html>
