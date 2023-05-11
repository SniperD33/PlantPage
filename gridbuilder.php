<?php

function buildGrid($data) {
    $gridStr = "";

    $i = 1;
    foreach($data as $row) {
        $gridStr .= "<div class ='$i'> ";
        $infoStr = "<div class='info'>";
        foreach($row as $columnName => $columnValue) {
            if($columnName == "SciName")
                $gridStr .= sprintf("<h1>$columnValue</h1>");
            else
                $infoStr .= "$columnName: $columnValue<br>";
        }
        $i++;
        $infoStr .= "</div>";
        $gridStr .= "$infoStr</div>";
    }

    return $gridStr;
}

?>
