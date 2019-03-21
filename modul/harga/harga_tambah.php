<?php
	if(isset($_POST['btnHapus'])){
		mysql_query("DELETE FROM tr_harga_item WHERE id_harga_item='".$_POST['btnHapus']."' AND kode_user='".$_SESSION['kode_user']."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(isset($_POST['btnBatal'])){
		mysql_query("DELETE FROM tr_harga_item WHERE kode_user='".$_SESSION['kode_user']."' AND id_harga=''", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				$_SESSION['info'] = 'success';	
				$_SESSION['pesan'] = 'Proses perubahan harga berhasil dibatalkan, seluruh item harga barang dihapus';
				echo '<script>window.location="?page=dthrg"</script>';
	}
	if(isset($_POST['btnGet'])){
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
    						WHERE a.status_barang='Active' 
    						ORDER BY a.kode_barang DESC";
		$barangQry 		= mysql_query($barangSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($barangRow 		= mysql_fetch_assoc($barangQry)) {
			$tmpSql = "INSERT INTO tr_harga_item SET kode_barang='$barangRow[kode_barang]',
														harga_beli_lama='$barangRow[harga_beli]',
														harga_beli='$barangRow[harga_beli]',
														harga_jual_lama='$barangRow[harga_jual]',
														harga_jual='$barangRow[harga_jual]',
														kode_user='".$_SESSION['kode_user']."'";
			mysql_query($tmpSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
		}			
		
	}
	if(isset($_POST['btnUpdate'])){
		foreach ($_POST['id'] as $key=>$val) {
			$txtID 		= (int) $_POST['id'][$key];
			$txtHBeliLm	= str_replace(".","",$_POST['txtHBeliLm'])[$key];
			$txtHBeli 	= str_replace(".","",$_POST['txtHBeli'])[$key];
			$txtHJualLm	= str_replace(".","",$_POST['txtHJualLm'])[$key];
			$txtHJual 	= str_replace(".","",$_POST['txtHJual'])[$key];


			mysql_query("UPDATE tr_harga_item SET harga_jual='$txtHJual',
													harga_beli='$txtHBeli',
													harga_beli_lama='$txtHBeliLm',
													harga_jual_lama='$txtHJualLm'
												 WHERE id_harga_item='$txtID'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
		}

	}
	if(isset($_POST['btnPilih'])){
		$message = array();
		if (trim($_POST['cmbBarang'])=="") {
			$message[] = "Kode barang belum diisi, silahkan pilih barang dan layanan terlebih dahulu !";		
		}
		if (trim($_POST['txtHPembelian'])=="") {
			$message[] = "Data harga beli belum diisi, silahkan isi dengan angka !";		
		}
		if (trim($_POST['txtHPenjualan'])=="") {
			$message[] = "Data harga jual belum diisi, silahkan isi dengan angka !";		
		}
	
		$cmbBarang		= $_POST['cmbBarang'];
		$txtHPembelian	= $_POST['txtHPembelian'];
		$txtHPembelian	= str_replace(".","",$txtHPembelian);
		$txtHPenjualan	= $_POST['txtHPenjualan'];
		$txtHPenjualan	= str_replace(".","",$txtHPenjualan);

		$sqlCek			= "SELECT COUNT(*) as total FROM tr_harga_item WHERE kode_barang='$cmbBarang' AND kode_user='".$_SESSION['kode_user']."'";
		$qryCek			= mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		$qryData		= mysql_fetch_assoc($qryCek);
		if($qryData['total']>=1){
			$message[] 	= "Maaf, nama barang dengan ID <b>$cmbBarang</b> sudah anda masukkan, silahkan ganti dengan yang lain";
		}
		
		if(count($message)==0){			
			$barangSql 		="SELECT * FROM ms_barang WHERE kode_barcode='$cmbBarang'";
			$barangQry 		= mysql_query($barangSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$barangRow 		= mysql_fetch_assoc($barangQry);
			$barangQty 		= mysql_num_rows($barangQry);
			if ($barangQty >= 1) {
				$tmpSql = "INSERT INTO tr_harga_item SET kode_barang='$barangRow[kode_barang]',
															harga_beli_lama='$barangRow[harga_beli]',
															harga_jual_lama='$barangRow[harga_jual]',
															harga_beli='$txtHPembelian',
															harga_jual='$txtHPenjualan',
															kode_user='".$_SESSION['kode_user']."'";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
				$cmbBarang		= "";
				$txtHPembelian	= "";
				$txtHPenjualan	= "";
			}
			else {
				$message[] = "Tidak ada barang dengan kode $cmbBarang, silahkan ganti";
			}
		}

	}
	if(isset($_POST['btnSave'])){	
		$tmpSql ="SELECT COUNT(*) As qty FROM tr_harga_item WHERE kode_user='".$_SESSION['kode_user']."'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		$tmpRow = mysql_fetch_array($tmpQry);
		if ($tmpRow['qty'] < 1) {
			$message[] = "Item barang belum ada yang dimasukan, minimal 1 barang .";
		}
				
		if(count($message)==0){			
			$qrySaveTrans		= mysql_query("INSERT INTO tr_harga SET tgl_berlaku='".date('Y-m-d H:i:s')."', 
																		status_harga='Open',  
																		tgl_dibuat='".date('Y-m-d H:i:s')."',
																		keterangan_harga='UPDATE HARGA BARANG & PRODUK PADA TANGGAL ".date('d-m-Y')." (INSERT)',
																		kode_user='".$_SESSION['kode_user']."'") 
								  or die ("Gagal query".mysql_error());
			// INSERT BELI
			
			if($qrySaveTrans){
				
				
				$itemTransSql 		="SELECT MAX(id_harga) as id_harga FROM tr_harga WHERE kode_user='".$_SESSION['kode_user']."'";
				$itemTransQry 		= mysql_query($itemTransSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
				$itemTransRow 		= mysql_fetch_assoc($itemTransQry);
			
				$beliSql = "UPDATE tr_harga_item SET id_harga='$itemTransRow[id_harga]',
														kode_user=''
													WHERE kode_user='".$_SESSION['kode_user']."'";
				mysql_query($beliSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
							
					
				

					
				$_SESSION['info'] = 'success';	
				$_SESSION['pesan'] = 'Harga barang berhasil diperbaharui';
				echo '<script>window.location="?page=dtlhrg&id='.encrypt($itemTransRow['id_harga']).'"</script>';
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

?>
<SCRIPT language="JavaScript">
	function submitform() {
		document.form1.submit();
	}
</SCRIPT>		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Perubahan Harga</span></div>
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
						<label>Kode Barang :</label>
						<div class="input-group">
	                        <input class="form-control" type="text" name="cmbBarang" id="kode_barang" readonly />
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
						<label>Nama Satuan :</label>
						<input class="form-control" type="text" id="nama_satuan" disabled="disabled"/>
					</div>
					<div class="col-md-2">
						<label>Harga Beli :</label>
						<input class="form-control" type="text" name="txtHPembelian" id="inputku" onkeydown="return numbersonly(this, event);" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}"/>
					</div>
					<div class="col-md-2">
						<label>Harga Jual :</label>
						<div class="input-group">
	                        <input class="form-control" type="text" name="txtHPenjualan" id="inputku" onkeydown="return numbersonly(this, event);" onblur="if (value == '') {value = '0'}" onfocus="if (value == '0') {value =''}"/>
	                        <span class="input-group-btn">
	                            <button type="submit" class="btn green btn-block" name="btnPilih"><i class="icon-plus"></i></button>
	                        </span>
	                    </div>
					</div>
				</div>
				<div class="batas"></div>
				<table class="table table-striped table-hover table-bordered" id="sample_1">
					<thead>
	                    <tr>
	                      	<th width="10%"><div align="center">KODE BARANG</div></th>
	                        <th width="25%">NAMA BARANG</th>
							<th width="8%"><div align="right">HARGA BELI LAMA</div></th>
							<th width="8%"><div align="right">HARGA JUAL LAMA</div></th>
							<th width="8%"><div align="right">HARGA BELI</div></th>
							<th width="8%"><div align="right">HARGA JUAL</div></th>
					  	  	<th width="10%"><div align="center">AKSI</div></th>
	                    </tr>
					</thead>
					<tbody>
	                    <?php
							
							$dataSql 		= "SELECT 
												b.kode_barcode,
												b.nama_barang,
												c.nama_merk,
												d.nama_kategori,
												a.harga_beli,
												a.harga_jual,
												a.id_harga_item,
												b.harga_jual as harga_jual_lama,
												b.harga_beli as harga_beli_lama
												FROM tr_harga_item a
												INNER JOIN ms_barang b ON a.kode_barang=b.kode_barang
												INNER JOIN ms_merk c ON b.kode_merk=c.kode_merk
												INNER JOIN ms_kategori d ON b.kode_kategori=d.kode_kategori
												WHERE a.kode_user='".$_SESSION['kode_user']."'
												ORDER BY b.kode_barang ASC";
							$dataQry 		= mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
							$nomor  		= 0; 
							while ($data 	= mysql_fetch_array($dataQry)) {
							$nomor++;
							$ID 			= $data['id_harga_item'];
							if($data['harga_beli']==$data['harga_jual']){
								$info		= 'class="warning"';
							}elseif($data['harga_beli']>$data['harga_jual']){
								$info		= 'class="danger"';
							}else{
								$info		= 'class="success"';
							}
						?>
	                    <tr>
	                    	<input type="hidden" name="id[]" value="<?php echo $ID; ?>">
							<td <?php echo $info ?>><div align="center"><?php echo $data ['kode_barcode']; ?></div></td>
							<td><?php echo $data ['nama_barang']; ?></td>
							<td><div align="right"><?php echo format_angka($data ['harga_beli_lama']); ?></div></td>
							<td><div align="right"><?php echo format_angka($data ['harga_jual_lama']); ?></div></td>
							<td>
								<input class="form-control input-sm" type="text" name="txtHBeli[]" value="<?php echo format_angka($data ['harga_beli']); ?>" id="inputku" onkeydown="return numbersonly(this, event);" />
							</td>
							<td>
								<input class="form-control input-sm" type="text" name="txtHJual[]" value="<?php echo format_angka($data ['harga_jual']); ?>" id="inputku" onkeydown="return numbersonly(this, event);"/>
							</td>
							<td>
							<div align="center">
								<button type="submit" class="btn btn-xs green" name="btnUpdate" value="<?php echo $ID; ?>"><i class="icon-check"></i></button>
								<button type="submit" class="btn btn-xs red" name="btnHapus" value="<?php echo $ID; ?>"><i class="icon-trash"></i></button>
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
		                    <th width="100">NAMA MERK</th>
		                    <th width="100">NAMA SATUAN</th>
		                </tr>
		            </thead>
		            <tbody>
		                <?php
		                //Data mentah yang ditampilkan ke tabel    
		                $query = mysql_query("SELECT * FROM ms_barang a 
		                						INNER JOIN ms_satuan b ON a.kode_satuan=b.kode_satuan
		                						INNER JOIN ms_merk c ON a.kode_merk=c.kode_merk
		                						WHERE a.status_barang='Active'");
		                while ($data = mysql_fetch_array($query)) {
		                    ?>
		                    <tr class="pilihBarang" data-dismiss="modal" aria-hidden="true" 
								data-kode="<?php echo $data['kode_barcode']; ?>"
								data-nama="<?php echo $data['nama_barang']; ?>"
								data-satuan="<?php echo $data['nama_satuan']; ?>"
								data-harga-jual="<?php echo $data['harga_jual']; ?>"
								data-harga-beli="<?php echo $data['harga_beli']; ?>"
								data-merk="<?php echo $data['nama_merk']; ?>">
		                        <td><div align="center"><?php echo $data['kode_barcode']; ?></div></td>
		                        <td><?php echo $data['nama_barang']; ?></td>
		                        <td><?php echo $data['nama_merk']; ?></td>
		                        <td><?php echo $data['nama_satuan']; ?></td>
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
		document.getElementById("nama_satuan").value = $(this).attr('data-satuan');
		document.getElementById("nama_merk").value = $(this).attr('data-merk');
		document.getElementById("harga_jual").value = $(this).attr('data-harga-jual');
		document.getElementById("harga_beli").value = $(this).attr('data-harga-beli');
    });
</script>			
										
								