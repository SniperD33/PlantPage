<?php
require_once("sqlTools.php");

function buildGrid($data) {
    $gridStr = "";

    $i = 1;
    foreach($data as $row) {
        $gridStr .= "<div class ='plogtitle'> ";
        $infoStr = "<div id='info$i' class='ploginfo' style='display: none'>";
        $sciName = $row['SciName'];
        foreach($row as $columnName => $columnValue) {
            if($columnName == "Image" && $columnValue != NULL)
                $gridStr .= sprintf("<img id='img$i' src=$columnValue onclick='showDivViewPlants(\"info$i\", \"$sciName\");'>");
            else if($columnName == "SciName")
                $gridStr .= sprintf("<h1>$columnValue</h1>");
            else if($columnName == "ViewCount")
                $infoStr .= "<span class=\"viewcount\">$columnName: $columnValue</span><br>";
            else if($columnName != "Image")
                $infoStr .= "$columnName: $columnValue<br>";
        }
        $i++;
        // $sciName = $row['SciName'];
        // $viewFormUpdate = "
        // <form method='post' action='functions.php'>
        // <input type='submit' name='UpdateViewCount'>
        // <input type='hidden' name='SciName' value='$sciName'>
        // </form>
        // ";

        $infoStr .= "</div>";
        $gridStr .= "$infoStr</div>\n    ";
    }

    return $gridStr;
}

if (isset($_POST["UpdateViewCount"]) && isset($_POST["SciName"])) {
    $SciName = $_POST["SciName"];

    $db = getConnection();

    $update = $db->prepare("update Plant set ViewCount = ViewCount + 1 where SciName = ?");

    $update->bind_param("s", $SciName);

    if ($update->execute()) {
        header("Location: plog.php");
    }
    else {
        echo "Error: " . mysqli_error();
    }
}

?>
