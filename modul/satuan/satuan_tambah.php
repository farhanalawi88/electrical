<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama satuan tidak boleh kosong!";		
		}
		if (trim($_POST['txtInisial'])=="") {
			$message[] = "Inisial satuan tidak boleh kosong!";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "Status tidak boleh kosong!";		
		}
				
		$txtNama		= $_POST['txtNama'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$cmbStatus		= $_POST['cmbStatus'];
		$txtInisial		= $_POST['txtInisial'];
				
		$sqlCek="SELECT * FROM ms_satuan WHERE nama_satuan='$txtNama'";
		$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$message[] = "Maaf, satuan barang <b> $txtNama </b> sudah ada, ganti dengan satuan lain";
		}
		
		if(count($message)==0){			
			$NewID	= buatKode("ms_satuan", "S");
			$qrySave=mysql_query("INSERT INTO ms_satuan SET kode_satuan='$NewID', 
															nama_satuan='$txtNama',
															inisial_satuan='$txtInisial',
															keterangan_satuan='$txtKeterangan',
															status_satuan='$cmbStatus'") 
					 or die ("Gagal query".mysql_error());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data satuan barang berhasil ditambahkan';
						echo '<script>window.location="?page=dtstn"</script>';
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
			
	$dataKode		= buatKode("ms_satuan", "S");
	$dataInisial	= isset($_POST['txtInisial']) ? $_POST['txtInisial'] : '';
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Penambahan Satuan</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Kode :</label>
					<div class="col-md-2">
						<input class="form-control" type="text" value="<?php echo $dataKode; ?>" disabled="disabled"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Inisial :</label>
					<div class="col-md-2">
						<input class="form-control" type="text" name="txtInisial"  value="<?php echo $dataInisial; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Satuan :</label>
					<div class="col-md-4">
						<input class="form-control" type="text" name="txtNama"  value="<?php echo $dataNama; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Keterangan :</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="txtKeterangan"  value="<?php echo $dataKeterangan; ?>"/>
					</div>
				</div>
				<div class="form-group">
	                <label class="col-md-2 control-label">Status User :</label>
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
			                <a href="?page=dtstn" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>