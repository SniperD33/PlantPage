<?php
require_once('config.php');
require('tcpdf/tcpdf.php'); // Assuming you have TCPDF library in a "tcpdf" folder relative to this file

// Establish PDO connection
$conn = get_pdo_connection();

try {
    // Call the stored procedure and get the results
    $stmt = $conn->prepare("CALL AHMetrics()");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create a new PDF document
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $PROJECT_NAME = "Plant Page";
    $pdf->SetCreator($PROJECT_NAME);
    $pdf->SetAuthor($PROJECT_NAME);
    $pdf->SetTitle('AHMetrics');

    // Add a page
    $pdf->AddPage();

    // Set font and size
    $pdf->SetFont('helvetica', '', 12);

    // Output the content from the stored procedure
    foreach ($results as $row) {
        foreach ($row as $key => $value) {
            $pdf->Cell(0, 10, $key . ': ' . $value, 0, 1);
        }
        $pdf->Ln();
    }

    // Output the PDF as a download
    $pdf->Output('AHMetrics.pdf', 'D');
} catch (PDOException $e) {
    echo "Error executing stored procedure: " . $e->getMessage();
}
?>
