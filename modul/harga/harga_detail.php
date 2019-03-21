<?php
	if(isset($_POST['btnCancel'])){
		$update=mysql_query("UPDATE tr_harga SET status_harga='Cancel' WHERE id_harga='".$_POST['btnApprove']."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
	}
	if(isset($_POST['btnApprove'])){
		$update=mysql_query("UPDATE tr_harga SET status_harga='Close' WHERE id_harga='".$_POST['btnApprove']."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());


		// UPDATE MASTER HARGA
		$hargaSql = "SELECT * FROM tr_harga a
					INNER JOIN tr_harga_item b ON a.id_harga=b.id_harga
					WHERE a.id_harga='".$_POST['btnApprove']."'";
		$hargaQry = mysql_query($hargaSql, $koneksidb)  or die ("Query pembelian salah : ".mysql_error());
		while ($hargaRow = mysql_fetch_array($hargaQry)){
			mysql_query("UPDATE ms_barang SET harga_jual='$hargaRow[harga_jual]',
													harga_beli='$hargaRow[harga_beli]'
										WHERE kode_barang='$hargaRow[kode_barang]'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());

		}

	}
	if(isset($_POST['btnUpdate'])){
		foreach ($_POST['id'] as $key=>$val) {
			$txtID 		= (int) $_POST['id'][$key];
			$txtHBeli 	= $_POST['txtHBeli'][$key];
			$txtHJual 	= $_POST['txtHJual'][$key];
			$txtBarang	= $_POST['barang'][$key];


			mysql_query("UPDATE tr_harga_item SET harga_jual='$txtHJual',
													harga_beli='$txtHBeli'
												 WHERE id_harga_item='$txtID'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());

			mysql_query("UPDATE ms_barang SET harga_jual='$txtHJual' WHERE kode_barang='$txtBarang'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
		}

	}
	$kodeTransaksi = decrypt($_GET['id']);				
	$beliSql = "SELECT * FROM tr_harga a
				INNER JOIN ms_user b ON a.kode_user=b.kode_user
				WHERE a.id_harga='".$kodeTransaksi."'";
	$beliQry = mysql_query($beliSql, $koneksidb)  or die ("Query pembelian salah : ".mysql_error());
	$beliRow = mysql_fetch_array($beliQry);

	$dataTanggal	= IndonesiaTgl($beliRow['tgl_berlaku']);
	$dataKeterangan	= $beliRow['keterangan_harga'];
	$dataUser 		= $beliRow['nama_user'];
	$dataStatus		= $beliRow['status_harga'];

	if($dataStatus=='Close'){
		$input 	= 'Disabled';
	}elseif($dataStatus=='Cancel'){
		$input 	= 'Disabled';
	}else{
		$input 	= '';
	}
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Detail Perubahan Harga</span></div>
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
						<label>Tgl. Perubahan :</label>
	                    <input class="form-control" type="text" value="<?php echo $dataTanggal ?>" disabled/>
					</div>
					<div class="col-md-6">
						<label>Keterangan & Deskripsi :</label>
						<input class="form-control" type="text" value="<?php echo $dataKeterangan ?>" disabled="disabled"/>
					</div>
					<div class="col-md-3">
						<label>Dibuat Oleh :</label>
						<input class="form-control" type="text" value="<?php echo $dataUser ?>" disabled="disabled"/>
					</div>
				</div>
				<div class="batas"></div>
				<table class="table table-striped table-hover table-bordered" id="sample_1">
					<thead>
	                    <tr>
	       	  	  	  	  	<th class="table-checkbox" width="3%">
	                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
	                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" disabled />
	                                <span></span>
	                            </label>
	                        </th>
	                      	<th width="2%"><div align="center">NO</div></th>
	                      	<th width="10%"><div align="center">KODE BARANG</div></th>
	                        <th width="25%">NAMA BARANG</th>
							<th width="8%"><div align="right">HARGA BELI LAMA</div></th>
							<th width="8%"><div align="right">HARGA JUAL LAMA</div></th>
							<th width="8%"><div align="right">HARGA BELI</div></th>
							<th width="8%"><div align="right">HARGA JUAL</div></th>
					  	  	<th width="5%"><div align="center">AKSI</div></th>
	                    </tr>
					</thead>
					<tbody>
	                    <?php
							
							$dataSql 		= "SELECT 
												b.kode_barcode,
												b.kode_barang,
												b.nama_barang,
												c.nama_merk,
												d.nama_kategori,
												a.harga_beli,
												a.harga_jual,
												a.id_harga_item,
												a.harga_beli_lama,
												a.harga_jual_lama
												FROM tr_harga_item a
												INNER JOIN ms_barang b ON a.kode_barang=b.kode_barang
												INNER JOIN ms_merk c ON b.kode_merk=c.kode_merk
												INNER JOIN ms_kategori d ON b.kode_kategori=d.kode_kategori
												WHERE a.id_harga='$kodeTransaksi'
												ORDER BY id_harga_item ASC";
							$dataQry 		= mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
							$nomor  		= 0; 
							while ($data 	= mysql_fetch_array($dataQry)) {
							$nomor++;
							$ID 			= $data['id_harga_item'];
							$barang			= $data['kode_barang'];

							if($data['harga_beli']==$data['harga_jual']){
								$info		= 'class="warning"';
							}elseif($data['harga_beli']>$data['harga_jual']){
								$info		= 'class="danger"';
							}else{
								$info		= 'class="success"';
							}
							if($dataStatus=='Close'){
								$hargaBeli 	= number_format($data ['harga_beli'],2);
								$hargaJual 	= number_format($data ['harga_jual'],2);
							}elseif($dataStatus=='Cancel'){
								$hargaBeli 	= number_format($data ['harga_beli'],2);
								$hargaJual 	= number_format($data ['harga_jual'],2);
							}else{
								$hargaBeli 	= $data ['harga_beli'];
								$hargaJual 	= $data ['harga_jual'];
							}
						?>
	                    <tr>
	                        <td>
	                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline" disabled>
	                                <input disabled type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
	                                <span></span>
	                            </label>
	                        </td>
	                    	<input type="hidden" name="id[]" value="<?php echo $ID; ?>">
	                    	<input type="hidden" name="barang[]" value="<?php echo $barang; ?>">
							<td><div align="center"><?php echo $nomor; ?></div></td>
							<td <?php echo $info ?>><div align="center"><?php echo $data ['kode_barcode']; ?></div></td>
							<td><?php echo $data ['nama_barang']; ?></td>
							<td><div align="right"><?php echo number_format($data ['harga_beli_lama'],2); ?></div></td>
							<td><div align="right"><?php echo number_format($data ['harga_jual_lama'],2); ?></div></td>
							<td><div align="right"><input class="form-control input-sm" <?php echo $input ?> type="text" name="txtHBeli[]" value="<?php echo $hargaBeli; ?>"/></div></td>
							<td><div align="right"><input class="form-control input-sm" <?php echo $input ?> type="text" name="txtHJual[]" value="<?php echo $hargaJual; ?>" /></div></td><td>
							<div align="center">
								<button type="submit" class="btn btn-xs green" name="btnUpdate" <?php echo $input ?> value="<?php echo $ID; ?>"><i class="icon-check"></i></button>
							</div>										
							</td>
	                    </tr>
	                    <?php } ?>
					</tbody>
	            </table>									
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<a href="?page=addhrg" class="btn green"><i class="icon-plus"></i> Add Transaction</a>
						<?php
						if($dataStatus=='Open' && $userRow['group_level']=='Admin'){
						?>
						<button type="submit" class="btn green" name="btnApprove" value="<?php echo $kodeTransaksi ?>"><i class="fa fa-save"></i> Approve Harga</button>
						<button type="submit" class="btn green" name="btnCancel" value="<?php echo $kodeTransaksi ?>"><i class="fa fa-times"></i> Cancel Harga</button>
						<?php } ?>
						<a href="?page=dthrg" class="btn green"><i class="fa fa-undo"></i> Data Transaction</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>