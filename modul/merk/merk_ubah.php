<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "Nama merk tidak boleh kosong!";		
		}
		if (trim($_POST['txtInisial'])=="") {
			$message[] = "Inisial merk tidak boleh kosong!";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "Status tidak boleh kosong!";		
		}
				
		$txtNama		= $_POST['txtNama'];
		$txtLama		= $_POST['txtLama'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$cmbStatus		= $_POST['cmbStatus'];
		$txtInisial		= $_POST['txtInisial'];
				
		$sqlCek="SELECT * FROM ms_merk WHERE nama_merk='$txtNama' AND NOT(nama_merk='$txtLama')";
		$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$message[] = "Maaf, merk barang <b> $txtNama </b> sudah ada, ganti dengan merk lain";
		}
				
		if(count($message)==0){	
			$qryUpdate=mysql_query("UPDATE ms_merk SET nama_merk='$txtNama', 
														keterangan_merk='$txtKeterangan',
														inisial_merk='$txtInisial',
														status_merk='$cmbStatus'	
													WHERE kode_merk ='".$_POST['txtKode']."'") 
				   or die ("Gagal query update".mysql_error());
			if($qryUpdate){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data merk barang berhasil diperbaharui';
						echo '<script>window.location="?page=dtmrk"</script>';
			}
			exit;
		}	
				
		if (! count($message)==0 ){
			echo "<div class='alert alert-error'>";
			$Num=0;
				foreach ($message as $indeks=>$pesan_tampil) { 
				$Num++;
					echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
			} 
			echo "</div>"; 
			
		} 
	}
		$KodeEdit		= isset($_GET['id']) ?  $_GET['id'] : $_POST['txtKode']; 
		$sqlShow 		= "SELECT * FROM ms_merk WHERE kode_merk='".decrypt($KodeEdit)."'";
		$qryShow 		= mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data merk salah : ".mysql_error());
		$dataShow 		= mysql_fetch_array($qryShow);
	
		$dataKode		= $dataShow['kode_merk'];
		$dataNama		= isset($dataShow['nama_merk']) ?  $dataShow['nama_merk'] : $_POST['txtNama'];
		$dataInisial	= isset($dataShow['inisial_merk']) ?  $dataShow['inisial_merk'] : $_POST['txtInisial'];
		$dataNamaLm		= $dataShow['nama_merk'];
		$dataKeterangan	= isset($dataShow['keterangan_merk']) ?  $dataShow['keterangan_merk'] : $_POST['txtKeterangan'];
		$dataStatus		= isset($dataShow['status_merk']) ?  $dataShow['status_merk'] : $_POST['cmbStatus'];
	
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Perubahan Merk</span></div>
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
						<input class="form-control" type="text" value="<?php echo $dataKode; ?>" name="txtKode" readonly/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Inisial :</label>
					<div class="col-md-2">
						<input class="form-control" type="text" name="txtInisial"  value="<?php echo $dataInisial; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Merk :</label>
					<div class="col-md-3">
						<input class="form-control" type="text" name="txtNama"  value="<?php echo $dataNama; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
						<input class="form-control" type="hidden" name="txtLama"  value="<?php echo $dataNamaLm; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Keterangan :</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="txtKeterangan"  value="<?php echo $dataKeterangan; ?>" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
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
			                <a href="?page=dtmrk" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>