<?php
	include		 "config/bar128.php";	
		
	$KodeEdit		= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtKode']; 
	$sqlShow 		= "SELECT * FROM ms_barang
						INNER JOIN ms_kategori ON ms_barang.kode_kategori=ms_kategori.kode_kategori
						WHERE ms_barang.kode_barang='$KodeEdit'";
	$qryShow 		= mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data supplier salah : ".mysql_error());
	$dataShow 		= mysql_fetch_array($qryShow);
			
	$dataKode		= $dataShow['kode_barang'];
	$dataNama		= $dataShow['nama_barang'];
	$dataKategori	= $dataShow['nama_kategori']; 
	$dataBeli		= format_angka($dataShow['harga_beli']); 
	$dataJual		= format_angka($dataShow['harga_jual']); 
	$dataBarcode	= $dataShow['kode_barcode']; 
?>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold"> Form Cetak Barcode Barang & Item</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" class="form-horizontal">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Kode :</label>
					<div class="col-md-2">
						<input class="form-control" type="text" value="<?php echo $dataKode; ?>" readonly="readonly"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Barang</label>
					<div class="col-md-5">
						<input class="form-control" value="<?php echo $dataNama; ?>" type="text" disabled="disabled"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori</label>
					<div class="col-md-4">
						<input class="form-control" value="<?php echo $dataKategori; ?>" type="text" disabled="disabled"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Harga Beli</label>
					<div class="col-md-2">
						<input class="form-control" value="<?php echo $dataBeli; ?>" type="text" disabled="disabled"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Harga Jual</label>
					<div class="col-md-2">
						<input class="form-control" value="<?php echo $dataJual; ?>" type="text" disabled="disabled"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Barcode</label>
					<div class="col-md-3">
						<input class="form-control" type="text" value="<?php echo $dataBarcode ?>" readonly="readonly"/>
					</div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
			        <div class="form-group">
			            <div class="col-lg-offset-2 col-lg-10">
			                <button name="bar" type="button" onclick="cetak()" class="btn blue"><i class="fa fa-print"></i> Cetak Barcode</button>
			                <a href="?page=databarang" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"> 
    function cetak()	 
    { 
    win=window.open('./cetak/barcode.php?id=<?php echo $dataBarcode; ?>','win','width=200, height=400, menubar=0, scrollbars=1, resizable=0, status=0'); 
    } 
</script>