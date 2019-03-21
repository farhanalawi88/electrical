<?php
if($_POST) {
	if(isset($_POST['btnHapus'])){
		mysql_query("DELETE FROM tr_transaksi_item WHERE id_transaksi_item='".$_POST['btnHapus']."' AND kode_user='".$_SESSION['kode_user']."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(isset($_POST['btnBatal'])){
		mysql_query("DELETE FROM tr_transaksi_item WHERE kode_user='".$_SESSION['kode_user']."' AND kode_transaksi=''", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
		$_SESSION['info'] = 'success';
		$_SESSION['pesan'] = 'transaksi order barang berhasil dibatalkan, seluruh item barang dihapus';
		echo '<script>window.location="?page=dttrx"</script>';
	}
	if(isset($_POST['btnPilih'])){
		$message = array();
		if (trim($_POST['cmbBarang'])=="") {
			$message[] = "Kode barang belum diisi, silahkan pilih barang dan layanan terlebih dahulu !";		
		}
		if (trim($_POST['txtJumlah'])=="" OR ! is_numeric(trim($_POST['txtJumlah']))) {
			$message[] = "Data Jumlah barang (Qty) belum diisi, silahkan isi dengan angka !";		
		}
	
		$cmbBarang			= $_POST['cmbBarang'];
		$txtJumlah			= $_POST['txtJumlah'];
		
		if(count($message)==0){			
			$barangSql 		="SELECT 
	    						a.kode_barcode,
	    						a.kode_barang,
	    						a.nama_barang,
	    						b.nama_satuan,
	    						(SELECT
									b1.harga_beli 
								FROM
									tr_harga a1
									INNER JOIN tr_harga_item b1 ON b1.id_harga = a1.id_harga 
								WHERE
									a1.status_harga = 'Close' 
									AND b1.kode_barang = a.kode_barang
								ORDER BY
									a1.tgl_berlaku DESC 
									LIMIT 1) as harga_beli,
	    						(SELECT
									b1.harga_jual 
								FROM
									tr_harga a1
									INNER JOIN tr_harga_item b1 ON b1.id_harga = a1.id_harga 
								WHERE
									a1.status_harga = 'Close' 
									AND b1.kode_barang = a.kode_barang
								ORDER BY
									a1.tgl_berlaku DESC 
									LIMIT 1) as harga_jual
	    						FROM ms_barang a 
	    						INNER JOIN ms_satuan b ON a.kode_satuan=b.kode_satuan
	    						INNER JOIN ms_merk c ON a.kode_merk=c.kode_merk
	    						WHERE a.status_barang='Active' AND a.kode_barcode='$cmbBarang'
	    						ORDER BY a.kode_barang DESC";
			$barangQry 		= mysql_query($barangSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$barangRow 		= mysql_fetch_assoc($barangQry);
			$barangQty 		= mysql_num_rows($barangQry);
			if ($barangQty >= 1) {
				$tmpSql = "INSERT INTO tr_transaksi_item SET kode_barang='$barangRow[kode_barang]',
															harga_pembelian='$barangRow[harga_beli]',
															harga_penjualan='$barangRow[harga_jual]',
															jumlah_transaksi='$txtJumlah', 
															kode_user='".$_SESSION['kode_user']."'";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
				$txtKode	= "";
				$txtJumlah	= "";
			}
			else {
				$message[] = "Tidak ada barang dengan kode $cmbBarang, silahkan ganti";
			}
		}

	}
	
	if(isset($_POST['btnSave'])){	
		$message = array();
		if (trim($_POST['txtCustomer'])=="") {
			$message[] = "Nama customer belum diisi, silahkan isi nama customer terlebih dahulu !";		
		}
		if (trim($_POST['cmbSupplier'])=="") {
			$message[] = "Nama supplier belum diisi, silahkan pilih supplier terlebih dahulu !";		
		}
		if (trim($_POST['cmbSumber'])=="") {
			$message[] = "Sumber referensi belum diisi, silahkan pilih salah satu terlebih dahulu !";		
		}
		if (trim($_POST['cmbExpedisi'])=="") {
			$message[] = "Expedisi belum diisi, silahkan pilih salah satu terlebih dahulu !";		
		}

		$tmpSql ="SELECT COUNT(*) As qty FROM tr_transaksi_item WHERE kode_user='".$_SESSION['kode_user']."'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		$tmpRow = mysql_fetch_array($tmpQry);
		if ($tmpRow['qty'] < 1) {
			$message[] = "Item barang belum ada yang dimasukan, minimal 1 barang .";
		}

		$txtAlamat		= $_POST['txtAlamat'];
		$txtAlamat		= str_replace("'","",$txtAlamat);
		$cmbSupplier	= $_POST['cmbSupplier'];
		$txtCustomer	= $_POST['txtCustomer'];
		$txtReferensi	= $_POST['txtReferensi'];
		$cmbExpedisi	= $_POST['cmbExpedisi'];
		$cmbSumber		= $_POST['cmbSumber'];
		$txtTelp		= $_POST['txtTelp'];
		$txtOngkir		= $_POST['txtOngkir'];
		$txtOngkir		= str_replace(".","",$txtOngkir);
		$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
		$txtTotalBeli	= $_POST['txtTotalBeli'];
		$txtTotalBeli	= str_replace(",","",$txtTotalBeli);
		$txtTotalJual	= $_POST['txtTotalJual'];
		$txtTotalJual	= str_replace(",","",$txtTotalJual);
				
		if(count($message)==0){			
			// PENOMORAN TRANSAKSI

			$bulan			= substr($txtTanggal,5,2);
			$romawi 		= getRomawi($bulan);
			$tahun			= substr($txtTanggal,2,2);
			$tahun2			= substr($txtTanggal,0,4);
			$nomorTrans		= "/ODR/".$romawi."/".$tahun;
			$queryTrans		= "SELECT max(kode_transaksi) as maxKode FROM tr_transaksi WHERE year(tgl_transaksi)='$tahun2'";
			$hasilTrans		= mysql_query($queryTrans);
			$dataTrans		= mysql_fetch_array($hasilTrans);
			$noTrans		= $dataTrans['maxKode'];
			$noUrutTrans	= $noTrans + 1;
			$IDTrans		=  sprintf("%04s", $noUrutTrans);
			$kodeTrans		= $IDTrans.$nomorTrans;
			// PENOMORAN PENJUALAN
			$init1Sql 		="SELECT kode_referensi FROM ms_referensi WHERE kode_referensi='$cmbSumber'";
			$init1Qry 		= mysql_query($init1Sql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$init1Row 		= mysql_fetch_array($init1Qry);
			$dataInit1		= $init1Row['kode_referensi'];
			$nomorJual		= "/".$dataInit1."/".$romawi."/".$tahun;
			$queryJual		= "SELECT max(kode_penjualan) as maxKode 
								FROM tr_penjualan 
								WHERE year(tgl_penjualan)='$tahun2'";
			$hasilJual		= mysql_query($queryJual);
			$dataJual		= mysql_fetch_array($hasilJual);
			$noJual			= $dataJual['maxKode'];
			$noUrutJual		= $noJual + 1;
			$IDJual			=  sprintf("%04s", $noUrutJual);
			$kodeJual		= $IDJual.$nomorJual;
			// PENOMORAN PEMBELIAN
			$initSql 		="SELECT inisial_supplier FROM ms_supplier WHERE kode_supplier='$cmbSupplier'";
			$initQry 		= mysql_query($initSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$initRow 		= mysql_fetch_array($initQry);
			$dataInit		= $initRow['inisial_supplier'];
			$nomorBeli		= "/".$dataInit."/".$romawi."/".$tahun;
			$queryBeli		= "SELECT 
								max(kode_pembelian) as maxKode 
								FROM tr_pembelian 
								WHERE year(tgl_pembelian)='$tahun2'";
			$hasilBeli		= mysql_query($queryBeli);
			$dataBeli		= mysql_fetch_array($hasilBeli);
			$noBeli			= $dataBeli['maxKode'];
			$noUrutBeli		= $noBeli + 1;
			$IDBeli			=  sprintf("%04s", $noUrutBeli);
			$kodeBeli		= $IDBeli.$nomorBeli;
			// INSERT TRANSAKSI
			$qrySaveTrans		= mysql_query("INSERT INTO tr_transaksi SET kode_transaksi='$kodeTrans', 
																		tgl_transaksi='$txtTanggal', 
																		status_transaksi='Open', 
																		tgl_dibuat='".date('Y-m-d H:i:s')."',
																		kode_user='".$_SESSION['kode_user']."'") 
								  or die ("Gagal query transaksi".mysql_error());
			// INSERT BELI
			$qrySaveBeli		= mysql_query("INSERT INTO tr_pembelian SET kode_pembelian='$kodeBeli', 
																		tgl_pembelian='$txtTanggal', 
																		kode_transaksi='$kodeTrans',
																		total_pembelian='$txtTotalBeli',
																		kode_supplier='$cmbSupplier'") 
								  or die ("Gagal query".mysql_error());
			// INSERT JUAL
			$qrySaveJual		= mysql_query("INSERT INTO tr_penjualan SET kode_penjualan='$kodeJual', 
																		tgl_penjualan='$txtTanggal', 
																		kode_transaksi='$kodeTrans',
																		kode_referensi='$cmbSumber',
																		nama_customer='$txtCustomer',
																		no_referensi='$txtReferensi',
																		alamat_customer='$txtAlamat',
																		telp_customer='$txtTelp',
																		status_penjualan='Open',
																		kode_expedisi='$cmbExpedisi',
																		total_penjualan='$txtTotalJual',
																		total_ongkir='$txtOngkir'") 
								  or die ("Gagal query penjualan".mysql_error());
			if($qrySaveTrans){
				
				$qryUpdate=mysql_query("UPDATE tr_transaksi_item SET kode_transaksi='$kodeTrans', 
																	kode_user=''
													WHERE kode_user='".$_SESSION['kode_user']."'") 
					   or die ("Gagal query update".mysql_error());

				if($qryUpdate){
					$itemTransSql 			="SELECT * FROM tr_transaksi_item WHERE kode_transaksi='$kodeTrans'";
					$itemTransQry 			= mysql_query($itemTransSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
					while ($itemTransRow 	= mysql_fetch_assoc($itemTransQry)){
						$beliSql = "INSERT INTO tr_pembelian_item SET kode_barang='$itemTransRow[kode_barang]',
																		id_transaksi_item='$itemTransRow[id_transaksi_item]',
																		kode_pembelian='$kodeBeli',
																		harga_pembelian='$itemTransRow[harga_pembelian]',
																		jumlah_pembelian='$itemTransRow[jumlah_transaksi]'";
						mysql_query($beliSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
						$jualSql = "INSERT INTO tr_penjualan_item SET kode_barang='$itemTransRow[kode_barang]',
																		kode_penjualan='$kodeJual',
																		id_transaksi_item='$itemTransRow[id_transaksi_item]',
																		harga_penjualan='$itemTransRow[harga_penjualan]',
																		jumlah_penjualan='$itemTransRow[jumlah_transaksi]'";
						mysql_query($jualSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());

					}
					
				}
				$_SESSION['info'] = 'success';	
				$_SESSION['pesan'] = 'Transaksi order barang dengan nomor transaksi '.$kodeTrans.' berhasil dibuat';
				echo '<script>window.location="?page=dtltrx&id='.encrypt($kodeTrans).'"</script>';
			}
			else{
				$message[] = "Gagal penyimpanan ke database";
			}
		}	
	} 
	
	if (! count($message)==0 ){
		echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>";
			$Num=0;
			foreach ($message as $indeks=>$pesan_tampil) { 
			$Num++;
				echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
			} 
		echo "</div>"; 
	}
} 
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataAlamat		= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataCustomer	= isset($_POST['txtCustomer']) ? $_POST['txtCustomer'] : '';
$dataReferensi	= isset($_POST['txtReferensi']) ? $_POST['txtReferensi'] : '';
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataSumber		= isset($_POST['cmbSumber']) ? $_POST['cmbSumber'] : '';
$dataExpedisi	= isset($_POST['cmbExpedisi']) ? $_POST['cmbExpedisi'] : '';
$dataOngkir		= isset($_POST['txtOngkir']) ? $_POST['txtOngkir'] : '';
$dataTelp		= isset($_POST['txtTelp']) ? $_POST['txtTelp'] : '';
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
							<div class="input-icon left">
								<i class="icon-calendar"></i>
								<input class="form-control input-md date-picker" data-date-format="dd-mm-yyyy" type="text" name="txtTanggal" value="<?php echo $tglTransaksi; ?>" readonly="readonly"/>
							</div>
						</div>
						<div class="form-group">
							<label>Nama Supplier :</label>
							<select class="form-control select2" data-placeholder="Pilih Supplier" name="cmbSupplier">
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
							<select class="form-control select2" data-placeholder="Pilih Referensi" name="cmbSumber">
								<?php
								  $dataSql = "SELECT * FROM ms_referensi WHERE status_referensi='Active' ORDER BY default_referensi ASC";
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
								<input class="form-control" type="text" value="<?php echo $dataReferensi; ?>" name="txtReferensi" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Nama Customer :</label>
							<div class="input-icon left">
								<i class="icon-user"></i>
								<input class="form-control" type="text" value="<?php echo $dataCustomer; ?>" name="txtCustomer" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
							</div>
						</div>
						<div class="form-group">
							<label>Telp. Customer :</label>
							<div class="input-icon left">
								<i class="icon-call-out"></i>
								<input class="form-control" type="text" value="<?php echo $dataTelp; ?>" name="txtTelp"/>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Jasa Expedisi :</label>
							<select class="form-control select2" data-placeholder="Pilih Expedisi" name="cmbExpedisi">
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
								<input class="form-control" type="text" value="<?php echo $userRow['nama_user']; ?>" disabled/>
							</div>
						</div>
					</div>
				</div>
				<div class="batas"></div>
				<div class="row">
					<div class="col-md-2">
						<label>Kode Barang :</label>
						<div class="input-group">
	                        <input class="form-control" type="text" name="cmbBarang" id="kode_barang"/>
	                        <span class="input-group-btn">
	                            <a class="btn green btn-block" data-toggle="modal" data-target="#barang"><i class="icon-magnifier-add"></i></a>
	                        </span>
	                    </div>
						
					</div>
					<div class="col-md-4">
						<label>Nama Barang :</label>
						<input class="form-control" type="text" id="nama_barang" disabled="disabled"/>
					</div>
					<div class="col-md-2">
						<label>Harga Beli :</label>
						<input class="form-control" type="text" id="harga_beli" disabled="disabled"/>
					</div>
					<div class="col-md-2">
						<label>Harga Jual :</label>
						<input class="form-control" type="text" id="harga_jual" disabled="disabled"/>
					</div>
					<div class="col-md-2">
						<label>Jumlah :</label>
						<div class="input-group">
	                        <input type="tel" class="form-control" name="txtJumlah" value="1" onblur="if (value == '') {value = '1'}" onfocus="if (value == '1') {value =''}"/>
	                        <span class="input-group-btn">
	                            <button type="submit" class="btn green btn-block" name="btnPilih"><i class="icon-plus"></i></button>
	                        </span>
	                    </div>
					</div>
				</div>
				<div class="batas"></div>
				<table class="table table-hover table-condensed table-bordered" width="100%" id="sample_4">
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
					  	  	<th width="67"><div align="center">DELETE</div></th>
						</tr>
					</thead>
					<tbody>
					<?php
							$tmpSql 			="SELECT * FROM tr_transaksi_item a
													INNER JOIN ms_barang b ON a.kode_barang=b.kode_barang
													INNER JOIN ms_satuan c ON b.kode_satuan=c.kode_satuan
													WHERE a.kode_user='".$_SESSION['kode_user']."'
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
							<td><div align="center"><?php echo $nomor; ?></div></td>
							<td><?php echo $tmpRow['kode_barcode']; ?></td>
							<td><?php echo $tmpRow['nama_barang']; ?></td>
							<td><div align="right"><?php echo number_format($tmpRow['harga_pembelian'],2); ?></div></td>
							<td><div align="right"><?php echo number_format($tmpRow['harga_penjualan'],2); ?></div></td>
							<td><div align="center"><?php echo number_format($tmpRow['jumlah_transaksi'],2); ?></div></td>
							<td><div align="right"><?php echo number_format($totalBeli,2); ?></div></td>
							<td><div align="right"><?php echo number_format($totalJual,2); ?></div></td>
							<td>
							<div align="center">
								<button type="submit" class="btn btn-xs red" name="btnHapus" value="<?php echo $ID; ?>"><i class="icon-trash"></i></button>
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
								<textarea class="form-control" name="txtAlamat" rows="4" onkeyup="javascript:this.value=this.value.toUpperCase();"><?php echo $dataAlamat; ?></textarea>
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
									<input class="form-control" type="tel" name="txtOngkir" id="inputku" value="<?php echo $dataOngkir; ?>" onkeydown="return numbersonly(this, event);" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}"/>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn green" name="btnSave"><i class="fa fa-save"></i> Save Transaction</button>
						<button type="submit" class="btn green" name="btnBatal"><i class="fa fa-undo"></i> Cancel Transaction</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade bs-modal-lg" id="barang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Data Barang</h4>
            </div>
            <div class="modal-body"> 
            	<table class="table table-hover table-bordered table-striped table-condensed" width="100%" id="sample_2">
		            <thead>
		                <tr>
		                  	<th width="100"><div align="center">KODE</div></th>
		                    <th width="600">NAMA BARANG</th>
		                    <th width="100">NAMA SATUAN</th>
		                    <th width="100"><div align="right">HARGA BELI</div></th>
		                    <th width="100"><div align="right">HARGA JUAL</div></th>
		                </tr>
		            </thead>
		            <tbody>
		                <?php
		                //Data mentah yang ditampilkan ke tabel    
		                $query = mysql_query("SELECT 
		                						a.kode_barcode,
		                						a.kode_barang,
		                						a.nama_barang,
		                						b.nama_satuan,
		                						(SELECT
													b1.harga_beli 
												FROM
													tr_harga a1
													INNER JOIN tr_harga_item b1 ON b1.id_harga = a1.id_harga 
												WHERE
													a1.status_harga = 'Close' 
													AND b1.kode_barang = a.kode_barang
												ORDER BY
													a1.tgl_berlaku DESC 
													LIMIT 1) as harga_beli,
		                						(SELECT
													b1.harga_jual 
												FROM
													tr_harga a1
													INNER JOIN tr_harga_item b1 ON b1.id_harga = a1.id_harga 
												WHERE
													a1.status_harga = 'Close' 
													AND b1.kode_barang = a.kode_barang
												ORDER BY
													a1.tgl_berlaku DESC 
													LIMIT 1) as harga_jual
		                						FROM ms_barang a 
		                						INNER JOIN ms_satuan b ON a.kode_satuan=b.kode_satuan
		                						INNER JOIN ms_merk c ON a.kode_merk=c.kode_merk
		                						WHERE a.status_barang='Active' 
		                						ORDER BY a.kode_barang DESC");
		                while ($data = mysql_fetch_array($query)) {
		                    ?>
		                    <tr class="pilihBarang" data-dismiss="modal" aria-hidden="true" 
								data-kode="<?php echo $data['kode_barcode']; ?>"
								data-id="<?php echo $data['kode_barang']; ?>"
								data-nama="<?php echo $data['nama_barang']; ?>"
								data-satuan="<?php echo $data['nama_satuan']; ?>"
								data-hjual="<?php echo number_format($data['harga_jual'],2); ?>"
								data-hbeli="<?php echo number_format($data['harga_beli'],2); ?>">
		                        <td><div align="center"><?php echo $data['kode_barcode']; ?></div></td>
		                        <td><?php echo $data['nama_barang']; ?></td>
		                        <td><?php echo $data['nama_satuan']; ?></td>
		                        <td><div align="right"><?php echo number_format($data['harga_beli'],2); ?></div></td>
		                        <td><div align="right"><?php echo number_format($data['harga_jual'],2); ?></div></td>
		                    </tr>
		                    <?php
		                }
		                ?>
		            </tbody>
		        </table> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn green" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="./assets/scripts/jquery-1.11.2.min.js"></script>
<script src="./assets/scripts/bootstrap.js"></script>
<script type="text/javascript">
    $(document).on('click', '.pilihBarang', function (e) {
        document.getElementById("kode_barang").value = $(this).attr('data-kode');
		document.getElementById("nama_barang").value = $(this).attr('data-nama');
		document.getElementById("harga_jual").value = $(this).attr('data-hjual');
		document.getElementById("harga_beli").value = $(this).attr('data-hbeli');
    });
</script>	

				
										
								