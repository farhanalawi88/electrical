
<?php
require_once("../plugin/jasper/autoload.dist.php");
use Jaspersoft\Client\Client;
$dataPi = $_GET['id'];

$control = array(
    'id_harga' => $dataPi
);

$c = new Client(
                "http://localhost:8080/jasperserver",
                "jasperadmin",
                "admin2018SKI"
        );

$report = $c->reportService()->runReport('/reports/Electrical/Print_Perubahan_Harga', 'xls', null, null, $control);
header('Cache-Control: must-revalidate');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($report));
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Print_Perubahan_Harga_'.date(dmyhis).'.xls"');
ob_clean();
flush();
echo $report;
?>