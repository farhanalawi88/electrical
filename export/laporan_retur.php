
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;

	$dataAct		= $_POST['cmbAct'];
	$tglAwal 		= InggrisTgl($_POST['txtTglAwal']);
	$tglAkhir		= InggrisTgl($_POST['txtTglAkhir']);
	$control 		= array(
						    'tgl1' 			=> $tglAwal,
						    'tgl2'			=> $tglAkhir
							);

	$c = new Client(
	                "http://localhost:8080/jasperserver",
	                "jasperadmin",
	                "admin2018SKI"
    );

	if($dataAct=='PDF'){
		$report = $c->reportService()->runReport('/reports/Electrical/Laporan_Retur', 'pdf', null, null, $control);
		header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        //header('Content-Disposition: attachment; filename=report.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Laporan_Retur_'.date('ymdhis').'.pdf"');
        echo $report;
	}elseif($dataAct=='EXCEL'){
		$report = $c->reportService()->runReport('/reports/Electrical/Laporan_Retur', 'xls', null, null, $control);
        header('Cache-Control: must-revalidate');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Laporan_Retur_'.date(dmyhis).'.xls"');
        ob_clean();
        flush();
        echo $report;

	}
	
?>