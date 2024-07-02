<?php
require('assets/fpdf/fpdf.php');
include 'includes/db.php';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('assets/img/logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Fee Report',0,1,'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }

    // Table with data
    function FeeTable($header, $data)
    {
        // Column widths
        $w = array(40, 35, 40, 45);
        // Header
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->Ln();
        // Data
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row['name'],'LR');
            $this->Cell($w[1],6,$row['amount'],'LR');
            $this->Cell($w[2],6,$row['month'],'LR');
            $this->Cell($w[3],6,$row['status'],'LR');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }
}

// Fetch data
$sql = "SELECT students.name, fees.amount, fees.month, fees.status FROM fees JOIN students ON fees.student_id = students.id";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$pdf = new PDF();
// Column headings
$header = array('Student', 'Amount', 'Month', 'Status');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->FeeTable($header,$data);
$pdf->Output();
?>
