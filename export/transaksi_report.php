
<?php
require_once("../plugin/jasper/autoload.dist.php");
use Jaspersoft\Client\Client;
$dataTransaksi = $_GET['id'];

$control = array(
    'kode_transaksi' => $dataTransaksi
);

$c = new Client(
                "http://localhost:8080/jasperserver",
                "jasperadmin",
                "admin2018SKI"
        );

$report = $c->reportService()->runReport('/reports/Electrical/Nota_Order', 'pdf', null, null, $control);
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Description: File Transfer');
//header('Content-Disposition: attachment; filename=report.pdf');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($report));
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Nota_Order_'.date('ymdhis').'.pdf"');

echo $report;
?>