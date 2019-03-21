<?php
	if(isset($_POST['btnSave'])){
		$btnSave 		= $_POST['btnSave'];
		
		$cekSql 		="SELECT * FROM tr_si a
							INNER JOIN tr_si_item b ON b.kode_si=a.kode_si
							WHERE a.kode_si='$btnSave'";
		$cekQry 		= mysql_query($cekSql, $koneksidb) or die ("Gagal select transaksi".mysql_error());
		while ($cekRow 		= mysql_fetch_assoc($cekQry)){
			if($cekRow['status_si']=='Open'){
				$tranHapus 		= mysql_query("UPDATE tr_si SET status_si='Close', tgl_app_si='".date('Y-m-d H:i:s')."' WHERE kode_si='$btnSave'", $koneksidb) 
					or die ("Gagal kosongkan transaksi".mysql_error());

				$update=mysql_query("UPDATE tr_penjualan SET status_penjualan='Close' 
										WHERE kode_penjualan='$cekRow[kode_penjualan]'",$koneksidb) 
					or die ("Gagal kosongkan tmp".mysql_error());
				$update2=mysql_query("UPDATE tr_transaksi SET status_transaksi='Close' 
										WHERE kode_transaksi='$cekRow[kode_transaksi]'",$koneksidb) 
					or die ("Gagal kosongkan tmp".mysql_error());

				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data transaksi sales invoice berhasil disetujui';
				echo '<script>window.location="?page=dtsi"</script>';
				
			}else{
				$_SESSION['info'] = 'danger';
				$_SESSION['pesan'] = 'Data transaksi tidak dapat disetujui karena status sudah close';
				echo '<script>window.location="?page=dtsi"</script>';
			}
		}		
	}
	$kodeTransaksi 	= decrypt($_GET['id']);
				
	$beliSql 		= "SELECT * FROM tr_si a
						INNER JOIN ms_referensi b ON a.kode_referensi=b.kode_referensi
						INNER JOIN ms_user c ON a.kode_user=c.kode_user
						WHERE a.kode_si='$kodeTransaksi'";
	$beliQry 		= mysql_query($beliSql, $koneksidb)  or die ("Query pendaftaran salah : ".mysql_error());
	$beliRow 		= mysql_fetch_array($beliQry);
	$dataTanggal	= IndonesiaTgl($beliRow['tgl_si']);
	$dataSumber		= $beliRow['kode_referensi'];
	$dataKeterangan	= $beliRow['keterangan_si'];
	$dataUser 		= $beliRow['nama_user'];
	$dataStatus		= $beliRow['status_si'];
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Detail Sales Invoice</span></div>
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
							<label>Referensi Dari :</label>
							<select class="form-control select2" data-placeholder="Pilih Referensi" disabled>
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
				<table class="table table-condensed table-bordered table-hover table-checkable order-column" id="sample_4">
					<thead>
	                    <tr class="active">
					  	  	<th width="5%"><div align="center">NO</div></th>
	                        <th width="15%"><div align="center">NO. PENJUALAN </div></th>
	                      	<th width="15%"><div align="center">TGL. PENJUALAN</div></th>
	                        <th width="25%">NO. REFERENSI</th>
							<th width="25%">NAMA CUSTOMER</th>
							<th width="8%"><div align="right">NOMINAL</div></th>
	                    </tr>
					</thead>
					<tbody>
	                    <?php
							
							$dataSql = "SELECT * FROM tr_si_item f
										INNER JOIN tr_transaksi a ON f.kode_transaksi=a.kode_transaksi
										INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
										INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
										INNER JOIN ms_user d ON a.kode_user=d.kode_user
										INNER JOIN ms_referensi e ON c.kode_referensi=e.kode_referensi
										WHERE f.kode_si='$kodeTransaksi'
										ORDER BY a.tgl_transaksi DESC";
							$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
							$nomor  = 0; 
							$total 	= 0;
							while ($data = mysql_fetch_array($dataQry)) {
							$nomor++;
							$Kode 		= $data['kode_penjualan'];
							$total 		= $total + $data['total_penjualan'];
						?>
	                    <tr>
							<td><div align="center"><?php echo $nomor; ?></div></td>
							<td <?php echo $dataStatus ?>><div align="center"><?php echo $data ['kode_penjualan']; ?></a></div></td>
							<td><div align="center"><?php echo IndonesiaTgl($data ['tgl_transaksi']); ?></div></td>
							<td><?php echo $data ['no_referensi']; ?></td>
							<td><?php echo $data ['nama_customer']; ?></td>
							<td><div align="right"><?php echo number_format($data ['total_penjualan'],2); ?></div></td>
	                    </tr>
	                    <?php } ?>
					</tbody>
					<tfoot>
	                    <tr class="active">
	                        <th colspan="5"><div align="right">GRAND TOTAL :</div> </th>
							<th><div align="right"><?php echo number_format($total,2); ?></div></th>
	                    </tr>
					</tfoot>
	            </table>
				<input class="form-control" type="hidden" name="txtTotal" value="<?php echo number_format($total,2); ?>"/>
									
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<a href="?page=addsi" class="btn green"><i class="icon-plus"></i> Tambah Transaksi</a>
						<a href="./export/nota_sales_invoice.php?id=<?php echo $kodeTransaksi; ?>" class="btn green"><i class="icon-printer"></i> Print Sales Invoice</a>
						<?php
						if($dataStatus=='Open'){
						?>
						<?php
						if($userRow['group_level']=='Admin'){
						?>
						<button type="submit" class="btn green" value="<?php echo $kodeTransaksi ?>" name="btnSave"><i class="fa fa-save"></i> Approve Transaksi</button>
						<?php } ?>
						<?php } ?>
						<a href="?page=dtsi" class="btn green"><i class="icon-basket"></i> Data Sales Invoice</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>