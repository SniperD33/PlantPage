<?php
function makeTable($data, $showHeader = true) {
    $tableStr = "";

    $tableStr .= "<table>";

    foreach($data as $row) {
        if ($showHeader) {
            $tableStr .= "<tr>";
            $showHeader = false;
        }
        $tableStr .= "<tr>";
        foreach($row as $columnName => $columnValue) {
            if($columnName == "Image" && $columnValue != NULL){
                $tableStr .= sprintf("<img id='img' class = 'plantImg' src = $columnValue>");
            }
            else{
                $tableStr .= sprintf("<td>%s</td>", $columnValue);
            }

        }
        $tableStr .= "</tr>";
    }

    $tableStr .= "</table>";

    return $tableStr;
}

?>