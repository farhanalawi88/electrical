<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama barang & item tidak boleh kosong!";		
		}
		if (trim($_POST['cmbKategori'])=="") {
			$message[] = "Data kategori belum dipilih, silahkan pilih terlebih dahulu!";		
		}
		if (trim($_POST['cmbMerk'])=="" ) {
			$message[] = "Data merk barang belum dipilih, silahkan pilih terlebih dahulu!";		
		}
		if (trim($_POST['cmbSatuan'])=="" ) {
			$message[] = "Data satuan barang belum dipilih, silahkan pilih terlebih dahulu!";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "Data status belum dipilih, silahkan pilih terlebih dahulu!";		
		}
		
		$txtNama		= $_POST['txtNama'];
		$cmbKategori	= $_POST['cmbKategori'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$cmbStatus		= $_POST['cmbStatus'];
		$cmbMerk		= $_POST['cmbMerk'];
		$cmbSatuan		= $_POST['cmbSatuan'];
		$txtUkuran		= $_POST['txtUkuran'];
		$txtBeli		= $_POST['txtBeli'];
		$txtBeli		= str_replace(".","",$txtBeli);
		$txtJual		= $_POST['txtJual'];
		$txtJual		= str_replace(".","",$txtJual);
		
		if(count($message)==0){			
			$qrySave=mysql_query("UPDATE ms_barang SET nama_barang='$txtNama', 
														kode_kategori='$cmbKategori', 
														kode_satuan='$cmbSatuan',
														kode_merk='$cmbMerk',
														ukuran_barang='$txtUkuran',
														harga_beli='$txtBeli',
														harga_jual='$txtJual',
														status_barang='$cmbStatus',
														keterangan_barang='$txtKeterangan'
													WHERE kode_barang='".$_POST['txtKode']."'") or die ("Gagal query".mysql_error());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data barang & item berhasil diperbaharui';
						echo '<script>window.location="?page=dtitm"</script>';
			}
			exit;
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
	$KodeEdit			= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtKode']; 
	$sqlShow 			= "SELECT * FROM ms_barang WHERE kode_barang='".decrypt($KodeEdit)."'";
	$qryShow 			= mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data supplier salah : ".mysql_error());
	$dataShow 			= mysql_fetch_array($qryShow);
	
	$dataKode			= $dataShow['kode_barang'];
	$dataLama			= $dataShow['nama_barang'];
	$dataBarcode		= $dataShow['kode_barcode'];
	$dataNama			= isset($dataShow['nama_barang']) ?  $dataShow['nama_barang'] : $_POST['txtNama'];
	$dataKategori		= isset($dataShow['kode_kategori']) ?  $dataShow['kode_kategori'] : $_POST['cmbKategori'];
	$dataSatuan			= isset($dataShow['kode_satuan']) ?  $dataShow['kode_satuan'] : $_POST['cmbSatuan'];
	$dataMerk			= isset($dataShow['kode_merk']) ?  $dataShow['kode_merk'] : $_POST['cmbMerk'];
	$dataKeterangan		= isset($dataShow['keterangan_barang']) ?  $dataShow['keterangan_barang'] : $_POST['txtKeterangan'];
	$dataStatus			= isset($dataShow['status_barang']) ?  $dataShow['status_barang'] : $_POST['cmbStatus'];
	$dataUkuran			= isset($dataShow['ukuran_barang']) ?  $dataShow['ukuran_barang'] : $_POST['txtUkuran'];
	$dataBeli			= isset($dataShow['harga_beli']) ?  format_angka($dataShow['harga_beli']) : $_POST['txtBeli'];
	$dataJual			= isset($dataShow['harga_jual']) ?  format_angka($dataShow['harga_jual']) : $_POST['txtJual'];

?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase"> Form Penambahan Barang & Item</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" class="form-horizontal form-bordered">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Kode :</label>
					<div class="col-md-2">
						<input class="form-control" type="text" value="<?php echo $dataKode; ?>" readonly="readonly" name="txtKode"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kode Inisial :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" value="<?php echo $dataBarcode; ?>" disabled/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Barang :</label>
					<div class="col-md-7">
						<input class="form-control" name="txtNama" value="<?php echo $dataNama; ?>" type="text"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Ukuran :</label>
					<div class="col-md-4">
						<input class="form-control" type="text" value="<?php echo $dataUkuran; ?>" name="txtUkuran" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Merk & Brand :</label>
					<div class="col-md-3">
					<select name="cmbMerk" class="form-control select2" data-placeholder="Pilih Merk">
					  <option value=""> </option>
					  <?php
						  $dataSql = "SELECT * FROM ms_merk WHERE status_merk='Active' ORDER BY kode_merk";
						  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
						  while ($dataRow = mysql_fetch_array($dataQry)) {
							if ($dataMerk == $dataRow['kode_merk']) {
								$cek = " selected";
							} else { $cek=""; }
							echo "<option value='$dataRow[kode_merk]' $cek>$dataRow[nama_merk]</option>";
						  }
						  $sqlData ="";
					  ?>
				  	</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Kategori :</label>
					<div class="col-md-3">
					<select name="cmbKategori" class="form-control select2" data-placeholder="Pilih Kategori" tabindex="1">
					  <option value=""> </option>
					  <?php
						  $dataSql = "SELECT * FROM ms_kategori WHERE status_kategori='Active' ORDER BY kode_kategori";
						  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
						  while ($dataRow = mysql_fetch_array($dataQry)) {
							if ($dataKategori == $dataRow['kode_kategori']) {
								$cek = " selected";
							} else { $cek=""; }
							echo "<option value='$dataRow[kode_kategori]' $cek>$dataRow[kode_kategori] - $dataRow[nama_kategori]</option>";
						  }
						  $sqlData ="";
					  ?>
				  	</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Satuan :</label>
					<div class="col-md-2">
					<select name="cmbSatuan" class="form-control select2" data-placeholder="Pilih Satuan">
					  <option value=""> </option>
					  <?php
						  $dataSql = "SELECT * FROM ms_satuan WHERE status_satuan='Active' ORDER BY kode_satuan";
						  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
						  while ($dataRow = mysql_fetch_array($dataQry)) {
							if ($dataSatuan == $dataRow['kode_satuan']) {
								$cek = " selected";
							} else { $cek=""; }
							echo "<option value='$dataRow[kode_satuan]' $cek>$dataRow[nama_satuan]</option>";
						  }
						  $sqlData ="";
					  ?>
				  	</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Keterangan :</label>
					<div class="col-md-10">
						<textarea class="form-control" name="txtKeterangan" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();"/><?php echo $dataKeterangan; ?></textarea>
					</div>
				</div>
				<div class="form-group last">
	                <label class="col-md-2 control-label">Status :</label>
	                <div class="col-md-10">
	                    <div class="md-radio-list">
	                    	<?php
								if($dataStatus=='Active'){
				                    echo " 	<div class='md-radio'>
				                    			<input type='radio' id='radio53' name='cmbStatus' value='Active' class='md-radiobtn' checked>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Active </label>
				                            </div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbStatus' value='Non Active' class='md-radiobtn'>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Non Active </label>
				                        	</div>";
				                }elseif($dataStatus=='Non Active'){
				                	echo "	<div class='md-radio'>
				                            	<input type='radio' id='radio53' name='cmbStatus' value='Active' class='md-radiobtn'>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Active </label>
				                        	</div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbStatus' value='Non Active' class='md-radiobtn' checked>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Non Active </label>
				                            </div>";
				                }else{
				                	echo "	<div class='md-radio'>
				                            	<input type='radio' id='radio53' name='cmbStatus' value='Active' class='md-radiobtn'>
				                            	<label for='radio53'><span></span><span class='check'></span><span class='box'></span> Active </label>
				                        	</div>
				                        	<div class='md-radio'>
				                            	<input type='radio' id='radio54' name='cmbStatus' value='Non Active' class='md-radiobtn'>
				                            	<label for='radio54'><span></span><span class='check'></span><span class='box'></span> Non Active </label>
				                            </div>";
				                }
				            ?>
	                    </div>
	                </div>
	            </div>
			</div>
			<div class="form-actions">
			    <div class="row">
			        <div class="form-group">
			            <div class="col-lg-offset-2 col-lg-10">
			                <button type="submit" name="btnSave" class="btn green"><i class="fa fa-save"></i> Simpan Data</button>
			                <a href="?page=dtitm" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>