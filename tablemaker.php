<?php

//if i give it an assosiative array in php, can generate an html table that shows the contects
function makeTable($data, $showHeader = true) {     //if showheader is set to true it will show column name
    $tableStr = ""; //will be used to store HTML code for table

    $tableStr .= "<table>"; //adds the opening <table> tag
//iterates through associative array
    foreach($data as $row) {    //for each row
        if ($showHeader) {
            $tableStr .= "<tr>";    //adds a new row to the table using the tr(table row)
            foreach($row as $columnName => $columnValue) {
                $tableStr .= sprintf("<th>%s</th>", $columnName);
            }
            $tableStr .= "</tr>";
            $showHeader = false;    //so the header is row is only generated once
        }
        $tableStr .= "<tr>";
        foreach($row as $columnName => $columnValue) {
            $tableStr .= sprintf("<td>%s</td>", $columnValue);
        }
        $tableStr .= "</tr>";
    }

    $tableStr .= "</table>";
    //generates as a string then returns
    return $tableStr;
}


?>