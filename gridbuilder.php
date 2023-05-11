<?php

function buildGrid($data) {
    $gridStr = "";

    $i = 1;
    foreach($data as $row) {
        $gridStr .= "<div class ='plogtitle'> ";
        $infoStr = "<div class='ploginfo'>";
        foreach($row as $columnName => $columnValue) {
            if($columnName == "SciName")
                $gridStr .= sprintf("<h1>$columnValue</h1>");
            else if($columnName != "Image")
                $infoStr .= "$columnName: $columnValue<br>";
        }
        $i++;
        $infoStr .= "</div>";
        $gridStr .= "$infoStr</div>";
    }

    return $gridStr;
}

?>
