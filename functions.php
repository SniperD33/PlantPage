<?php
require_once("config.php");

function buildGrid($data) {
    $gridStr = "";

    $i = 1;
    foreach($data as $row) {
        $gridStr .= "<div class ='plogtitle'> ";
        $infoStr = "<div id='info' class='ploginfo'>";
        foreach($row as $columnName => $columnValue) {
            if($columnName == "Image" && $columnValue != NULL)
                $gridStr .= sprintf("<img id='img$i' src=$columnValue onclick='showDiv();'>");
            else if($columnName == "SciName")
                $gridStr .= sprintf("<h1>$columnValue</h1>");
            else if($columnName != "Image")
                $infoStr .= "$columnName: $columnValue<br>";
        }
        $i++;
        $infoStr .= "</div>";
        $gridStr .= "$infoStr</div>\n    ";
    }

    return $gridStr;
}

function iterateCount($data) {
    if (isset($_POST["update"])) {
    $tableToUpdate = htmlspecialchars($_POST["update_data"]);
    $plantToUpdate = htmlspecialchars($_POST["update_id"]);

	$db = getConnection();
    $query = $db->prepare("update Plant set ViewCount = ViewCount + 1 where SciName= ?");
    $query->bind_param("v", $plantToUpdate);
    if ($query->execute()) {    
        header( "Location: " . $_SERVER['PHP_SELF']);
    }
    else {
        echo "Error updating: " . mysqli_error();
    }
    }
}


?>
