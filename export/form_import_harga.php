
<?php
require_once("../plugin/jasper/autoload.dist.php");
use Jaspersoft\Client\Client;

$c = new Client(
                "http://localhost:8080/jasperserver",
                "jasperadmin",
                "admin2018SKI"
        );

$report = $c->reportService()->runReport('/reports/Electrical/Form_Import_Harga', 'xls', null, null);
header('Cache-Control: must-revalidate');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($report));
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Form_Import_Harga_'.date(dmyhis).'.xls"');
ob_clean();
flush();
echo $report;
?>