<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama supplier</b> tidak boleh kosong!";		
		}
		if (trim($_POST['txtAlamat'])=="") {
			$message[] = "<b>Alamat </b> tidak boleh kosong";		
		}
		if (trim($_POST['txtTelpon'])=="") {
			$message[] = "<b>No. Telpon </b> tidak boleh kosong!";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status </b> tidak boleh kosong!";		
		}

		$txtNama		= $_POST['txtNama'];
		$txtAlamat		= $_POST['txtAlamat'];
		$txtTelpon		= $_POST['txtTelpon'];
		$txtJenis		= $_POST['txtJenis'];
		$cmbStatus		= $_POST['cmbStatus'];
		$txtInisial		= $_POST['txtInisial'];
		
		if(count($message)==0){	
			$qryUpdate=mysql_query("UPDATE ms_supplier SET nama_supplier='$txtNama', 
								  							alamat_supplier='$txtAlamat',
								  							inisial_supplier='$txtInisial',
															jenis_supplier='$txtJenis', 
															telp_supplier='$txtTelpon',
															status_supplier='$cmbStatus'
													WHERE kode_supplier ='".$_POST['txtKode']."'") 
					   or die ("Gagal query update".mysql_error());
			if($qryUpdate){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data supplier berhasil diperbaharui';
				echo '<script>window.location="?page=dtsupp"</script>';
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
	$KodeEdit= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtKode']; 
	$sqlShow = "SELECT * FROM ms_supplier WHERE kode_supplier='$KodeEdit'";
	$qryShow = mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data supplier salah : ".mysql_error());
	$dataShow = mysql_fetch_array($qryShow);
	
	$dataKode		= $dataShow['kode_supplier'];
	$dataInisial	= isset($dataShow['inisial_supplier']) ?  $dataShow['inisial_supplier'] : $_POST['txtInisial'];
	$dataNama		= isset($dataShow['nama_supplier']) ?  $dataShow['nama_supplier'] : $_POST['txtNama'];
	$dataAlamat 	= isset($dataShow['alamat_supplier']) ?  $dataShow['alamat_supplier'] : $_POST['txtAlamat'];
	$dataTelpon 	= isset($dataShow['telp_supplier']) ?  $dataShow['telp_supplier'] : $_POST['txtTelpon'];
	$dataJenis 		= isset($dataShow['jenis_supplier']) ?  $dataShow['jenis_supplier'] : $_POST['txtJenis'];
	$dataStatus 	= isset($dataShow['status_supplier']) ?  $dataShow['status_supplier'] : $_POST['cmbStatus'];
?>
		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Perubahan Supplier</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal form-bordered">
			<div class="form-body form">
				<div class="form-group">
					<label class="col-lg-2 control-label">Kode :</label>
					<div class="col-lg-2">
						<input class="form-control" type="text" value="<?php echo $dataKode; ?>" disabled="disabled"/>
						<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Inisial Kode :</label>
					<div class="col-lg-2">
						<input class="form-control" name="txtInisial" value="<?php echo $dataInisial; ?>" type="text"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Nama Supplier :</label>
					<div class="col-lg-4">
						<input class="form-control" name="txtNama" value="<?php echo $dataNama; ?>" type="text"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Jenis Supplier :</label>
					<div class="col-lg-3">
						<input class="form-control" name="txtJenis" value="<?php echo $dataJenis; ?>" type="text"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Alamat :</label>
					<div class="col-lg-10">
						<textarea class="form-control" name="txtAlamat" type="text"/><?php echo $dataAlamat; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">No. Telp :</label>
					<div class="col-lg-3">
						<input class="form-control" name="txtTelpon" value="<?php echo $dataTelpon; ?>" type="text"/>
					</div>
				</div>
				<div class="form-group">
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
			                <a href="?page=dtsupp" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
