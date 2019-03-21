<?php
	if(isset($_POST['btnSave'])){
		$btnSave 		= $_POST['btnSave'];
		
		$cekSql 		="SELECT * FROM tr_pi a
							INNER JOIN tr_pi_item b ON b.kode_pi=a.kode_pi WHERE a.kode_pi='$btnSave'";
		$cekQry 		= mysql_query($cekSql, $koneksidb) or die ("Gagal select transaksi".mysql_error());
		while ($cekRow 		= mysql_fetch_assoc($cekQry)){
			if($cekRow['status_pi']=='Open'){
				$tranHapus 		= mysql_query("UPDATE tr_pi SET status_pi='Close', tgl_app_pi='".date('Y-m-d H:i:s')."' WHERE kode_pi='$btnSave'", $koneksidb) 
					or die ("Gagal kosongkan transaksi".mysql_error());

				$update=mysql_query("UPDATE tr_pembelian SET status_pembelian='Close' 
										WHERE kode_pembelian='$cekRow[kode_pembelian]'",$koneksidb) 
						or die ("Gagal kosongkan tmp".mysql_error());

				$update2=mysql_query("UPDATE tr_transaksi SET status_transaksi='Close' 
										WHERE kode_transaksi='$cekRow[kode_transaksi]'",$koneksidb) 
						or die ("Gagal kosongkan tmp".mysql_error());

				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data transaksi purchase invoice berhasil disetujui';
				echo '<script>window.location="?page=dtpi"</script>';
				
			}else{
				$_SESSION['info'] = 'danger';
				$_SESSION['pesan'] = 'Data transaksi tidak dapat disetujui karena status sudah close';
				echo '<script>window.location="?page=dtpi"</script>';
			}
		}		
	}

	$kodeTransaksi 	= decrypt($_GET['id']);
				
	$beliSql 		= "SELECT * FROM tr_pi a
						INNER JOIN ms_supplier b ON a.kode_supplier=b.kode_supplier
						INNER JOIN ms_user c ON a.kode_user=c.kode_user
						WHERE a.kode_pi='$kodeTransaksi'";
	$beliQry 		= mysql_query($beliSql, $koneksidb)  or die ("Query pendaftaran salah : ".mysql_error());
	$beliRow 		= mysql_fetch_array($beliQry);
	$dataTanggal	= IndonesiaTgl($beliRow['tgl_pi']);
	$dataSupplier	= $beliRow['kode_supplier'];
	$dataKeterangan	= $beliRow['keterangan_pi'];
	$dataReferensi	= $beliRow['no_referensi'];
	$dataUser 		= $beliRow['nama_user'];
	$dataStatus		= $beliRow['status_pi'];
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Detail Purchase Invoice</span></div>
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
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Tgl. Invoice :</label>
							<div class="input-icon left">
								<i class="icon-calendar"></i>
								<input class="form-control" value="<?php echo $dataTanggal; ?>" disabled/>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Nama Supplier :</label>
							<select class="form-control select2" data-placeholder="Pilih Supplier" disabled>
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
							<label>Dibuat Oleh :</label>
							<div class="input-icon left">
								<i class="icon-user"></i>
								<input class="form-control" type="text" value="<?php echo $dataUser; ?>" disabled/>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Keterangan :</label>
							<div class="input-icon left">
								<i class="fa fa-edit"></i>
								<input class="form-control" type="text" value="<?php echo $dataKeterangan; ?>" disabled/>
							</div>
						</div>
					</div>
				</div>
				<div class="batas"></div>
				<table class="table table-condensed table-bordered table-hover table-checkable order-column" id="sample_1">
					<thead>
	                    <tr class="active">
					  	  	<th width="2%"><div align="center">NO</div></th>
	                      	<th width="10%"><div align="center">TGL. ORDER</div></th>
	                      	<th width="20%"><div align="center">NO. TAGIHAN</div></th>
	                        <th width="15%"><div align="center">NO. ORDER </div></th>
	                        <th width="35%">NO. REFERENSI</th>
							<th width="20%">NAMA CUSTOMER</th>
							<th width="10%"><div align="right">NOMINAL</div></th>
	                    </tr>
					</thead>
					<tbody>
	                    <?php
							
							$dataSql = "SELECT * FROM tr_pi_item f
										INNER JOIN tr_transaksi a ON f.kode_transaksi=a.kode_transaksi
										INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
										INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
										INNER JOIN ms_user d ON a.kode_user=d.kode_user
										INNER JOIN ms_referensi e ON c.kode_referensi=e.kode_referensi
										WHERE f.kode_pi='$kodeTransaksi' 
										ORDER BY a.tgl_transaksi DESC";
							$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
							$nomor  = 0; 
							$total 	= 0;
							while ($data = mysql_fetch_array($dataQry)) {
							$nomor++;
							$Kode 		= $data['kode_pembelian'];
							$total 		= $total + $data['total_pembelian'];
						?>
	                    <tr>
							<td><div align="center"><?php echo $nomor; ?></div></td>
							<td><div align="center"><?php echo IndonesiaTgl($data ['tgl_transaksi']); ?></div></td>
							<td><div align="center"><?php echo $data ['no_tagihan_po']; ?></div></td>
							<td <?php echo $dataStatus ?>><div align="center"><?php echo $data ['kode_pembelian']; ?></a></div></td>
							<td><?php echo $data ['no_referensi']; ?></td>
							<td><?php echo $data ['nama_customer']; ?></td>
							<td><div align="right"><?php echo number_format($data ['total_pembelian'],2); ?></div></td>
	                    </tr>
	                    <?php } ?>
					</tbody>
					<tfoot>
	                    <tr class="active">
	                        <th colspan="6"><div align="right">GRAND TOTAL :</div> </th>
							<th width="10%"><div align="right"><?php echo number_format($total,2); ?></div></th>
	                    </tr>
					</tfoot>
	            </table>
				<input class="form-control" type="hidden" name="txtTotal" value="<?php echo number_format($total,2); ?>"/>
									
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<a href="?page=addpi" class="btn green"><i class="icon-plus"></i> Tambah Transaksi</a>
						<a href="./export/nota_purchase_invoice.php?id=<?php echo $kodeTransaksi; ?>" class="btn green"><i class="icon-printer"></i> Print Purchase Invoice</a>
						<?php
						if($dataStatus=='Open'){
						?>
						<?php
						if($userRow['group_level']=='Admin'){
						?>
						<button type="submit" class="btn green" value="<?php echo $kodeTransaksi ?>" name="btnSave"><i class="fa fa-save"></i> Approve Transaksi</button>
						<?php } ?>
						<?php } ?>
						<a href="?page=dtpi" class="btn green"><i class="icon-basket"></i> Data Purchase Invoice</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>