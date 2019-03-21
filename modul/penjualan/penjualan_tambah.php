<?php
		

	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['cmbOrder'])=="") {
			$message[] = "Data order tidak boleh kosong, silahkan isi terlebih dahulu !";		
		}
		if (trim($_POST['cmbExpedisi'])=="") {
			$message[] = "Jenis expedisi tidak boleh kosong, silahkan isi terlebih dahulu !";		
		}
		
		$cmbTanggal 	= $_POST['cmbTanggal'];
		$txtCustomer	= $_POST['txtCustomer'];
		$txtReferensi	= $_POST['txtReferensi'];
		$txtTotal		= $_POST['txtTotal'];
		$txtTotal		= str_replace(".","",$txtTotal);
		$txtOngkir		= $_POST['txtOngkir'];
		$txtOngkir		= str_replace(".","",$txtOngkir);
		$txtAlamat		= $_POST['txtAlamat'];
		$cmbOrder		= $_POST['cmbOrder'];
		$cmbExpedisi	= $_POST['cmbExpedisi'];

		$tmpSql ="SELECT COUNT(*) As qty FROM tr_pembelian_item WHERE kode_pembelian='$cmbOrder'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		$tmpRow = mysql_fetch_array($tmpQry);
		if ($tmpRow['qty'] < 1) {
			$message[] = "Item barang belum ada yang dimasukan, minimal 1 barang.";
		}
				
		if(count($message)==0){			
			// PENOMORAN
			$bulan 			= date('n');
			$romawi 		= getRomawi($bulan);
			$tahun 			= date ('Y');
			$nomor 			= "/OL/".$romawi."/".$tahun;
			$query 			= "SELECT max(kode_penjualan) as maxKode FROM tr_penjualan WHERE month(tgl_penjualan)='$bulan'";
			$hasil 			= mysql_query($query);
			$data  			= mysql_fetch_array($hasil);
			$no 			= $data['maxKode'];
			$noUrut			= $no + 1;
			$kode 			=  sprintf("%03s", $noUrut);
			$kodeBaru		= $kode.$nomor;
			// AKHIR PENOMORAN
			$waktuTransaksi = date('H:i:s');
			$qrySave		= mysql_query("INSERT INTO tr_penjualan SET kode_penjualan='$kodeBaru', 
																	tgl_penjualan='".date('Y-m-d H:i:s')."', 
																	alamat_customer='$txtAlamat',
																	total_penjualan='$txtTotal',
																	no_referensi='$txtReferensi',
																	kode_expedisi='$cmbExpedisi',
																	kode_pembelian='$cmbOrder',
																	total_ongkir='$txtOngkir',
																	nama_customer='$txtCustomer',
																	kode_user='".$_SESSION['kode_user']."'") 
								  or die ("Gagal query".mysql_error());
			if($qrySave){
				$tmpSql ="SELECT * FROM tr_pembelian_item a
							INNER JOIN ms_barang b ON a.kode_barang=b.kode_barang
							WHERE kode_pembelian='$cmbOrder'";
				$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
				while ($tmpRow = mysql_fetch_array($tmpQry)) {
					$barangSql = "INSERT INTO tr_penjualan_item SET kode_penjualan='$kodeBaru', 
																	kode_barang='$tmpRow[kode_barang]', 
																	harga_penjualan='$tmpRow[harga_jual]', 
																	jumlah_penjualan='$tmpRow[jumlah_pembelian]'";
					mysql_query($barangSql, $koneksidb) or die ("Gagal Query Simpan detail barang".mysql_error());
					$barangSql = "UPDATE tr_pembelian SET status_pembelian='Close' WHERE kode_pembelian='$cmbOrder'";
					mysql_query($barangSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
				}

				$_SESSION['pesan'] = 'Transaksi penjualan barang dengan nomor transaksi '.$kodeBaru.' berhasil dibuat';
				echo '<script>window.location="?page=dtlpjl&id='.$kodeBaru.'"</script>';
			}
			else{
				$message[] = "Gagal penyimpanan ke database";
			}
		}	
	} 
	
	if (! count($message)==0 ){
		echo "<div class='alert alert-danger'>";
			$Num=0;
			foreach ($message as $indeks=>$pesan_tampil) { 
			$Num++;
				echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
			} 
		echo "</div>"; 
	}
	
// PENOMORAN
$bulan 			= date('n');
$romawi 		= getRomawi($bulan);
$tahun 			= date ('Y');
$nomor 			= "/OL/".$romawi."/".$tahun;
$query 			= "SELECT max(kode_penjualan) as maxKode FROM tr_penjualan WHERE month(tgl_penjualan)='$bulan'";
$hasil 			= mysql_query($query);
$data  			= mysql_fetch_array($hasil);
$no 			= $data['maxKode'];
$noUrut			= $no + 1;
$kode 			=  sprintf("%03s", $noUrut);
$nomorTransaksi	= $kode.$nomor;
// AKHIR PENOMORAN	

$tglTransaksi 		= isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('d-m-Y');
$dataOrder			= isset($_POST['cmbOrder']) ? $_POST['cmbOrder'] : '';

$beliSql 			= "SELECT * FROM tr_pembelian a WHERE a.kode_pembelian='$dataOrder'";
$beliQry 			= mysql_query($beliSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$beliRow 			= mysql_fetch_array($beliQry);	
$dataReferensi		= $beliRow['no_referensi'];
$dataCustomer		= $beliRow['nama_customer'];
$dataAlamat			= $beliRow['alamat_customer'];
$dataOngkir			= isset($_POST['txtOngkir']) ? $_POST['txtOngkir'] : '';
$dataExpedisi		= isset($_POST['cmbExpedisi']) ? $_POST['cmbExpedisi'] : '';
?>
<SCRIPT language="JavaScript">
	function submitform() {
		document.form1.submit();
	}
</SCRIPT>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Form Transaksi Penjualan Barang</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="fieldset-form" autocomplete="off" name="form1">
			<div class="row">
				<div class="col-md-3">
					<fieldset>
					<legend>Informasi Transaksi </legend>
					<div class="form-group">
						<label>No. Transaksi :</label>
						<div class="input-icon left">
							<i class="fa fa-qrcode"></i>
							<input class="form-control" type="text" name="txtNomor" value="<?php echo $nomorTransaksi; ?>" disabled="disabled"/>
						</div>
					</div>
					<div class="form-group">
						<label>Tgl. Transaksi :</label>
						<div class="input-icon left">
							<i class="icon-calendar"></i>
							<input class="form-control date-picker" data-date-format="dd-mm-yyyy" type="text" name="cmbTanggal" value="<?php echo $tglTransaksi; ?>" readonly="readonly"/>
						</div>
					</div>
					<div class="form-group">
						<label>No. Referensi :</label>
						<select class="form-control select2" data-placeholder="Pilih Order" name="cmbOrder" onChange="javascript:submitform();">
							<option value=""></option>
							<?php
							  $dataSql = "SELECT * FROM tr_pembelian WHERE status_pembelian='Open' ORDER BY kode_pembelian ASC";
							  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
							  while ($dataRow = mysql_fetch_array($dataQry)) {
								if ($dataOrder == $dataRow['kode_pembelian']) {
									$cek = " selected";
								} else { $cek=""; }
									echo "<option value='$dataRow[kode_pembelian]' $cek>$dataRow[no_referensi]</option>";
							  }
							  $sqlData ="";
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Nama Customer :</label>
						<div class="input-icon left">
							<i class="fa fa-user"></i>
							<input class="form-control" type="text" value="<?php echo $dataCustomer; ?>" name="txtCustomer" readonly/>
							<input class="form-control" type="hidden" value="<?php echo $dataReferensi; ?>" name="txtReferensi"/>
						</div>
					</div>
					<div class="form-group">
						<label>Alamat Customer :</label>
						<textarea class="form-control" type="text" name="txtAlamat" onkeyup="javascript:this.value=this.value.toUpperCase();" rows="6"/><?php echo $dataAlamat; ?></textarea>
					</div>
					
					</fieldset>
				</div>
				<div class="col-md-9">				
					<fieldset>
					<legend>Informasi Barang & Item</legend>	
					<div class="scroller" data-height="295px">
						<table class="table table-hover table-condensed table-bordered" width="100%" id="sample_4">
							<thead>
								<tr>
							  	  	<th width="23"><div align="center">NO</div></th>
									<th width="159">KODE BARANG </th>
									<th width="745">NAMA BARANG </th>
							  	  	<th width="117"><div align="right">HARGA JUAL </div></th>
						  	 	  	<th width="83"><div align="center">JUMLAH</div></th>
						  	  	  	<th width="84"><div align="right">SUBTOTAL</div></th>
								</tr>
							</thead>
							<tbody>
							<?php
									$tmpSql ="SELECT * FROM tr_pembelian_item a
												INNER JOIN ms_barang b ON a.kode_barang=b.kode_barang
												WHERE kode_pembelian='$dataOrder'";
									$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
									$total 	= 0; 
									$qtyBrg = 0; 
									$nomor	= 0;
									$qtyPPN	= 0;
									while($tmpRow = mysql_fetch_array($tmpQry)) {
										$ID			= $tmpRow['id'];
										$subSotal 	= $tmpRow['jumlah_pembelian'] * intval($tmpRow['harga_jual']);
										$total 		= $total + $subSotal;
										$qtyBrg 	= $qtyBrg + $tmpRow['jumlah_pembelian'];
										
										
										$nomor++;
							?>
								<tr>
									<td><div align="center"><?php echo $nomor; ?></div></td>
									<td><?php echo $tmpRow['kode_barcode']; ?></td>
									<td><?php echo $tmpRow['nama_barang']; ?></td>
									<td><div align="right"><?php echo format_angka2($tmpRow['harga_jual']); ?></div></td>
									<td><div align="center"><?php echo format_angka2($tmpRow['jumlah_pembelian']); ?></div></td>
									<td><div align="right"><?php echo format_angka2($subSotal); ?></div></td>
								</tr>
									<?php }?>
							</tbody>
						</table>
					</div>
					<div class="batas"></div>
					<div class="row">
						<div class="col-md-6 form-horizontal">
							<div class="form-group">
								<label class="col-md-4 control-label">Jasa Expedisi :</label>
								<div class="col-md-7">
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
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label">Operator :</label>
								<div class="col-md-7">
									<div class="input-icon left">
										<i class="fa fa-user"></i>
										<input class="form-control" type="text" value="<?php echo $userRow['nama_user']; ?>" disabled/>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 form-horizontal">
							<div class="form-group">
								<label class="col-md-6 control-label">Sub Total (Rp.) :</label>
								<div class="col-md-6">
									<div class="input-icon left">
									<i class="fa fa-money"></i>
									<input class="form-control span12" type="text" name="txtTotal" value="<?php echo format_angka($total); ?>" readonly="readonly"/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label">Jasa Expedisi (Rp.) :</label>
								<div class="col-md-6">
									<div class="input-icon left">
									<i class="fa fa-money"></i>
									<input class="form-control" type="tel" name="txtOngkir" id="inputku" value="<?php echo format_angka($dataOngkir); ?>" onkeydown="return numbersonly(this, event);" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}"/>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</fieldset>
				</div>
				
			</div>
			<div class="form-actions">
				<button type="submit" class="btn blue" name="btnSave"><i class="fa fa-save"></i> Simpan Transaksi</button>
				<a href="?page=dtpjl" class="btn blue"><i class="fa fa-remove"></i> Batalkan</a>
			</div>
		</form>
	</div>
</div>
