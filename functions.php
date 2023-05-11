<?php
require_once("sqlTools.php");

function buildGrid($dataPlant, $dataCare, $dataProb) {
    $gridStr = "";


    $i = 1;
    foreach($dataPlant as $row) {
        $gridStr .= "<div class ='plogtitle'> ";
        $infoStr = "<div id='info$i' class='ploginfo' style='display: none'>";
        $infoStr .= "<h3>Plant Information</h3>";
        $sciName = $row['SciName'];
        foreach($row as $columnName => $columnValue) {
            if($columnName == "Image" && $columnValue != NULL)
                $gridStr .= sprintf("<img id='img$i' class = 'plantImg' src=$columnValue onclick='showDivViewPlants(\"info$i\", \"$sciName\");'>");
            else if($columnName == "SciName")
                $gridStr .= sprintf("<h1>$columnValue</h1>");
            else if($columnName == "ViewCount")
                $infoStr .= "<span class=\"viewcount\">$columnName: $columnValue</span><br>";
            else if($columnName != "Image")
                $infoStr .= "$columnName: $columnValue<br>";
        }
        $careStr = "<h3>Care Info</h3>";
        $probStr = "<h3>Common Problems</h3>";
        foreach($dataCare as $row2) {
            if ($row2["SciName"]==$sciName) {
                $careID = $row2['CareID'];
                foreach($row2 as $columnName => $columnValue) {
                    if ($columnName != "CareID" && $columnName != "SciName") {
                        $careStr .= "$columnName: $columnValue<br>";    
                    }
                }
                foreach($dataProb as $row3) {
                    if ($row3["CareID"]==$careID) {
                        $careID2 = $row3['CareID'];
                        foreach($row3 as $columnName => $columnValue) {
                            if ($columnName != "CareID") {
                                $probStr .= "$columnName: $columnValue<br>";
                            }
                        }
                    }
                }
            }
        }

        $infoStr .= $careStr;
        $infoStr .= $probStr;

        $i++;
        

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

        // $sciName = $row['SciName'];
        // $viewFormUpdate = "
        // <form method='post' action='functions.php'>
        // <input type='submit' name='UpdateViewCount'>
        // <input type='hidden' name='SciName' value='$sciName'>
        // </form>
        // ";

        //Below information, break and add header for careinfo, and commonproblems tables

?>

