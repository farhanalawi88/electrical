<?php
	if(isset($_POST['btnUpdate'])){
		$qrySaveTrans		= mysql_query("INSERT INTO tr_harga SET tgl_berlaku='".date('Y-m-d H:i:s')."', 
																	status_harga='Open',  
																	tgl_dibuat='".date('Y-m-d H:i:s')."',
																	keterangan_harga='UPDATE HARGA BARANG & PRODUK PADA TANGGAL ".date('d-m-Y')." (TRANSAKSI ITEM)',
																	kode_user='".$_SESSION['kode_user']."'") 
							  or die ("Gagal query".mysql_error());
		if($qrySaveTrans){
			$itemTransSql 		="SELECT MAX(id_harga) as id_harga FROM tr_harga WHERE kode_user='".$_SESSION['kode_user']."'";
			$itemTransQry 		= mysql_query($itemTransSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$itemTransRow 		= mysql_fetch_assoc($itemTransQry);
		}
		foreach ($_POST['id'] as $key=>$val) {
			$txtID 		= (int) $_POST['id'][$key];
			$txtHBeli 	= str_replace(".","",$_POST['txtHBeli'])[$key];
			$txtHJual 	= str_replace(".","",$_POST['txtHJual'])[$key];
			$txtBarang	= $_POST['barang'][$key];
			$txtIDHarga = $itemTransRow['id_harga']; 

			mysql_query("UPDATE tr_transaksi_item SET harga_pembelian='$txtHBeli',
														harga_penjualan='$txtHJual'
												 WHERE id_transaksi_item='$txtID'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
			// UPDATE HARGA PEMBELIAN ITEM
			mysql_query("UPDATE tr_pembelian_item SET harga_pembelian='$txtHBeli'
												 WHERE id_transaksi_item='".$_POST['btnUpdate']."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
			// UPDATE HARGA PENJUALAN ITEM
			mysql_query("UPDATE tr_penjualan_item SET harga_penjualan='$txtHJual'
												 WHERE id_transaksi_item='$txtID'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());

			// INSERT HARGA BARANG
			$tmpSql = "INSERT INTO tr_harga_item SET kode_barang='$txtBarang',
														harga_beli='$txtHBeli',
														harga_jual='$txtHJual',
														id_harga='$txtIDHarga'";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
		}

	}

	if(isset($_POST['btnCancel'])){
		$btnCancel 		= $_POST['btnCancel'];
		
		$cekSql 		="SELECT 
							a.status_transaksi
							FROM tr_transaksi a
							INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
							INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
							WHERE a.kode_transaksi='$btnCancel'";
		$cekQry 		= mysql_query($cekSql, $koneksidb) or die ("Gagal select transaksi".mysql_error());
		$cekRow 		= mysql_fetch_assoc($cekQry);
		if($cekRow['status_transaksi']=='Open'){
			$tranHapus 		= mysql_query("UPDATE tr_transaksi SET status_transaksi='Cancel' WHERE kode_transaksi='$btnCancel'", $koneksidb) 
				or die ("Gagal kosongkan transaksi".mysql_error());

			$bliHapus		= mysql_query("UPDATE tr_pembelian SET status_pembelian='Cancel' WHERE kode_transaksi='$btnCancel'", $koneksidb) 
			or die ("Gagal kosongkan pembelian header".mysql_error());

		
			$pjlHapus 		= mysql_query("UPDATE tr_penjualan SET status_penjualan='Cancel' WHERE kode_transaksi='$btnCancel'", $koneksidb) 
			or die ("Gagal kosongkan penjualan header".mysql_error());

			$_SESSION['info'] = 'success';
			$_SESSION['pesan'] = 'Data transaksi barang berhasil dibatalkan/Cancel';
			echo '<script>window.location="?page=dttrx"</script>';
			
		}else{
			$_SESSION['info'] = 'danger';
			$_SESSION['pesan'] = 'Data transaksi tidak dapat dibatalkan';
			echo '<script>window.location="?page=dttrx"</script>';
		}
		
	}
	if(isset($_POST['btnPrint'])){
		$aksi = array("<meta http-equiv='Refresh' content='0; URL=./export/sales_report.php?id=".$_POST['btnPrint']."'>",
						"<meta http-equiv='Refresh' content='4; URL=./export/order_report.php?id=".$_POST['btnPrint']."'>");
		foreach ($aksi as $nilai) {
		echo "$nilai";
		}

	}


	$kodeTransaksi = decrypt($_GET['id']);				
	$beliSql = "SELECT * FROM tr_transaksi a
				INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
				INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
				INNER JOIN ms_user d ON a.kode_user=d.kode_user
				INNER JOIN ms_referensi e ON c.kode_referensi=e.kode_referensi
				WHERE a.kode_transaksi='".$kodeTransaksi."'";
	$beliQry = mysql_query($beliSql, $koneksidb)  or die ("Query pembelian salah : ".mysql_error());
	$beliRow = mysql_fetch_array($beliQry);

	$dataTanggal	= IndonesiaTgl($beliRow['tgl_transaksi']);
	$dataSupplier	= $beliRow['kode_supplier'];
	$dataSumber		= $beliRow['kode_referensi'];
	$dataReferensi	= $beliRow['no_referensi'];
	$dataCustomer	= $beliRow['nama_customer'];
	$dataTelp		= $beliRow['telp_customer'];
	$dataUser		= $beliRow['nama_user'];
	$dataAlamat		= $beliRow['alamat_customer'];
	$dataExpedisi	= $beliRow['kode_expedisi'];
	$dataOngkir		= number_format($beliRow['total_ongkir'],2);
	$dataStatus 	= $beliRow['status_transaksi'];

	
	$input 	= 'Disabled';
	
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Transaksi Order</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="fieldset-form" autocomplete="off" name="form1">
			<div class="form-body">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Tgl. Transaksi :</label>
							<input class="form-control date-picker" value="<?php echo $dataTanggal; ?>" disabled/>
						</div>
						<div class="form-group">
							<label>Nama Supplier :</label>
							<select class="form-control select2" data-placeholder="Pilih Supplier" name="cmbSupplier" disabled>
								<option value=""></option>
								<?php
								  $dataSql = "SELECT * FROM ms_supplier WHERE status_supplier='Active' ORDER BY kode_supplier ASC";
								  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
								  while ($dataRow = mysql_fetch_array($dataQry)) {
									if ($dataSupplier == $dataRow['kode_supplier']) {
										$cek = " selected";
									} else { $cek=""; }
										echo "<option value='$dataRow[kode_supplier]' $cek>$dataRow[nama_supplier]</option>";
								  }
								  $sqlData ="";
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Referensi Dari :</label>
							<select class="form-control select2" data-placeholder="Pilih Referensi" name="cmbSumber" disabled>
								<option value=""></option>
								<?php
								  $dataSql = "SELECT * FROM ms_referensi WHERE status_referensi='Active' ORDER BY kode_referensi ASC";
								  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
								  while ($dataRow = mysql_fetch_array($dataQry)) {
									if ($dataSumber == $dataRow['kode_referensi']) {
										$cek = " selected";
									} else { $cek=""; }
										echo "<option value='$dataRow[kode_referensi]' $cek>$dataRow[nama_referensi]</option>";
								  }
								  $sqlData ="";
								?>
							</select>
						</div>
						<div class="form-group">
							<label>No. Referensi :</label>
							<div class="input-icon left">
								<i class="fa fa-qrcode"></i>
								<input class="form-control" type="text" value="<?php echo $dataReferensi; ?>" name="txtReferensi" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled/>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Nama Customer :</label>
							<div class="input-icon left">
								<i class="icon-user"></i>
								<input class="form-control" type="text" value="<?php echo $dataCustomer; ?>" name="txtCustomer" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled/>
							</div>
						</div>
						<div class="form-group">
							<label>Telp. Customer :</label>
							<div class="input-icon left">
								<i class="icon-call-out"></i>
								<input class="form-control" type="text" value="<?php echo $dataTelp; ?>" name="txtTelp" disabled/>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Jasa Expedisi :</label>
							<select class="form-control select2" data-placeholder="Pilih Expedisi" name="cmbExpedisi" disabled>
								<option value=""></option>
								<?php
								  $dataSql = "SELECT * FROM ms_expedisi WHERE status_expedisi='Active' ORDER BY kode_expedisi ASC";
								  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
								  while ($dataRow = mysql_fetch_array($dataQry)) {
									if ($dataExpedisi == $dataRow['kode_expedisi']) {
										$cek = " selected";
									} else { $cek=""; }
										echo "<option value='$dataRow[kode_expedisi]' $cek>$dataRow[kode_expedisi] - $dataRow[nama_expedisi]</option>";
								  }
								  $sqlData ="";
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Operator :</label>
							<div class="input-icon left">
								<i class="icon-user"></i>
								<input class="form-control" type="text" value="<?php echo $dataUser; ?>" disabled/>
							</div>
						</div>
					</div>
				</div>
				<div class="batas"></div>
				<table class="table table-hover table-striped table-condensed table-bordered" width="100%" id="sample_4">
					<thead>
						<tr>
					  	  	<th width="26"><div align="center">NO</div></th>
							<th width="150">KODE BARANG </th>
							<th width="537">NAMA BARANG </th>
					  	  	<th width="87"><div align="right">HARGA BELI</div></th>
					  	  	<th width="87"><div align="right">HARGA JUAL</div></th>
					  	  	<th width="87"><div align="center">JUMLAH</div></th>
					  	  	<th width="87"><div align="right">TOTAL BELI</div></th>
					  	  	<th width="87"><div align="right">TOTAL JUAL</div></th>
					  	  	<th width="87"><div align="center">AKSI</div></th>
						</tr>
					</thead>
					<tbody>
					<?php
							$tmpSql 			="SELECT * FROM tr_transaksi_item a
													INNER JOIN ms_barang b ON a.kode_barang=b.kode_barang
													INNER JOIN ms_satuan c ON b.kode_satuan=c.kode_satuan
													WHERE a.kode_transaksi='$kodeTransaksi'
													ORDER BY a.id_transaksi_item DESC";
							$tmpQry 			= mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
							$nomor				= 0;
							$grandTotBeli 		= 0;
							$grandTotJual 		= 0;
							while($tmpRow 		= mysql_fetch_array($tmpQry)) {
								$ID				= $tmpRow['id_transaksi_item'];		
								$totalBeli 		= $tmpRow['jumlah_transaksi'] * ($tmpRow['harga_pembelian']);
								$totalJual 		= $tmpRow['jumlah_transaksi'] * ($tmpRow['harga_penjualan']);
								$grandTotBeli	= $grandTotBeli + $totalBeli;
								$grandTotJual	= $grandTotJual + $totalJual;								
								$nomor++;
					?>
						<tr>
							<input type="hidden" name="id[]" value="<?php echo $ID; ?>">
	                    	<input type="hidden" name="barang[]" value="<?php echo $tmpRow['kode_barang']; ?>">
							<td><div align="center"><?php echo $nomor; ?></div></td>
							<td><?php echo $tmpRow['kode_barcode']; ?></td>
							<td><?php echo $tmpRow['nama_barang']; ?></td>
							<td><div align="right"><input class="form-control input-sm" <?php echo $input ?> type="text" name="txtHBeli[]" value="<?php echo number_format($tmpRow ['harga_pembelian'],2); ?>" id="inputku" onkeydown="return numbersonly(this, event);"/></div></td>
							<td><div align="right"><input class="form-control input-sm" <?php echo $input ?> type="text" name="txtHJual[]" value="<?php echo number_format($tmpRow ['harga_penjualan'],2); ?>" id="inputku" onkeydown="return numbersonly(this, event);"/></div></td>
							<td><div align="center"><?php echo number_format($tmpRow['jumlah_transaksi'],2); ?></div></td>
							<td><div align="right"><?php echo number_format($totalBeli,2); ?></div></td>
							<td><div align="right"><?php echo number_format($totalJual,2); ?></div></td><td>
							<div align="center">
								<button type="submit" class="btn btn-xs green" name="btnUpdate" <?php echo $input ?> value="<?php echo $ID; ?>"><i class="icon-check"></i></button>
							</div>										
							</td>
						</tr>
							<?php }?>
					</tbody>
				</table>
				<div class="batas"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Alamat Customer :</label>
								<textarea class="form-control" name="txtAlamat" rows="4" disabled><?php echo $dataAlamat; ?></textarea>
							</div>
						</div>
						<div class="col-md-6 form-horizontal">
							<div class="form-group">
								<label class="col-md-7 control-label">Grand Total Beli (Rp.) :</label>
								<div class="col-md-5">
									<div class="input-icon left">
									<i class="fa fa-money"></i>
									<input class="form-control" type="text" name="txtTotalBeli" value="<?php echo number_format($grandTotBeli,2); ?>" readonly="readonly"/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-7 control-label">Grand Total Jual (Rp.) :</label>
								<div class="col-md-5">
									<div class="input-icon left">
									<i class="fa fa-money"></i>
									<input class="form-control" type="text" name="txtTotalJual" value="<?php echo number_format($grandTotJual,2); ?>" readonly="readonly"/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-7 control-label">Jasa Expedisi (Rp.) :</label>
								<div class="col-md-5">
									<div class="input-icon left">
									<i class="fa fa-money"></i>
									<input class="form-control" type="tel" name="txtOngkir" id="inputku" value="<?php echo $dataOngkir; ?>" onkeydown="return numbersonly(this, event);" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}" disabled/>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<a href="?page=addtrx" class="btn green"><i class="icon-plus"></i> Add Data</a>
						<?php
						if($dataStatus!='Cancel'){
						?>
						<button type="button" onClick="cetak()" class="btn green" value="<?php echo $kodeTransaksi ?>"><i class="icon-printer"></i> Print Dokumen</button>
						<?php } ?>
						<?php
						if($dataStatus=='Open'){
						?>
						<button type="submit" class="btn green" name="btnCancel" value="<?php echo $kodeTransaksi ?>"><i class="icon-ban"></i> Cancel Transaksi</button>
						<?php } ?>
						<a href="?page=dttrx" class="btn green"><i class="icon-basket"></i> Data Transaksi</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"> 
    function cetak()	 
    { 
    win=open('./export/order_report.php?id=<?php echo $kodeTransaksi; ?>','win','width=1, height=1, menubar=0, scrollbars=1, resizable=0, status=0'); 
	    if(win){
	    	win2=open('./export/sales_report.php?id=<?php echo $kodeTransaksi; ?>','win2','width=1, height=1, menubar=0, scrollbars=1, resizable=0, status=0'); 
	    	if(win2){
	    		win3=open('./export/alamat_transaksi.php?id=<?php echo $kodeTransaksi; ?>','win3','width=1, height=1, menubar=0, scrollbars=1, resizable=0, status=0'); 
	    	}
   		}
    } 
</script>