
<?php
	require_once("../plugin/jasper/autoload.dist.php");
	require_once("../config/inc.library.php");
	use Jaspersoft\Client\Client;

	$dataAct		= $_POST['cmbAct'];
	$tglAwal 		= InggrisTgl($_POST['txtTglAwal']);
	$tglAkhir		= InggrisTgl($_POST['txtTglAkhir']);
	$dataStatus		= $_POST['cmbStatus'];
	$dataSupplier 	= $_POST['cmbSupplier'];
	$control 		= array(
						    'tgl1' 				=> $tglAwal,
						    'tgl2'				=> $tglAkhir,
						    'status_pi'			=> $dataStatus,
						    'kode_supplier'		=> $dataSupplier
							);

	$c = new Client(
	                "http://localhost:8080/jasperserver",
	                "jasperadmin",
	                "admin2018SKI"
    );

	if($dataAct=='PDF'){
		$report = $c->reportService()->runReport('/reports/Electrical/laporan_faktur_pembelian', 'pdf', null, null, $control);
		header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        //header('Content-Disposition: attachment; filename=report.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Laporan_Faktur_Pembelian_'.date('ymdhis').'.pdf"');
        echo $report;
	}elseif($dataAct=='EXCEL'){
		$report = $c->reportService()->runReport('/reports/Electrical/laporan_faktur_pembelian', 'xls', null, null, $control);
        header('Cache-Control: must-revalidate');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Laporan_Faktur_Pembelian_'.date(dmyhis).'.xls"');
        ob_clean();
        flush();
        echo $report;

	}
	
?>