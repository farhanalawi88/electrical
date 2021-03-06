<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtNama'])=="") {
			$message[] = "<b>Nama referensi</b> tidak boleh kosong!";		
		}
		if (trim($_POST['cmbStatus'])=="") {
			$message[] = "<b>Status </b> tidak boleh kosong!";		
		}

		$txtNama		= $_POST['txtNama'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtTelpon		= $_POST['txtTelpon'];
		$cmbStatus		= $_POST['cmbStatus'];
		
		if(count($message)==0){	
			$qryUpdate=mysql_query("UPDATE ms_referensi SET nama_referensi='$txtNama', 
								  							keterangan_referensi='$txtKeterangan',
															status_referensi='$cmbStatus'
													WHERE kode_referensi ='".$_POST['txtKode']."'") 
					   or die ("Gagal query update".mysql_error());
			if($qryUpdate){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data referensi berhasil diperbaharui';
				echo '<script>window.location="?page=dtreff"</script>';
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
	$sqlShow = "SELECT * FROM ms_referensi WHERE kode_referensi='".decrypt($KodeEdit)."'";
	$qryShow = mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data referensi salah : ".mysql_error());
	$dataShow = mysql_fetch_array($qryShow);
	
	$dataKode		= $dataShow['kode_referensi'];
	$dataNama		= isset($dataShow['nama_referensi']) ?  $dataShow['nama_referensi'] : $_POST['txtNama'];
	$dataKeterangan	= isset($dataShow['alamat_referensi']) ?  $dataShow['alamat_referensi'] : $_POST['txtKeterangan'];
	$dataStatus 	= isset($dataShow['status_referensi']) ?  $dataShow['status_referensi'] : $_POST['cmbStatus'];
?>
		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Perubahan Referensi</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd" class="form-horizontal form-bordered">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Kode :</label>
					<div class="col-md-2">
						<input class="form-control" type="text" value="<?php echo $dataKode; ?>" name="txtKode" readonly/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Nama Referensi :</label>
					<div class="col-md-5">
						<input class="form-control" name="txtNama" value="<?php echo $dataNama; ?>" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Keterangan :</label>
					<div class="col-md-10">
						<textarea class="form-control" name="txtKeterangan" type="text" onkeyup="javascript:this.value=this.value.toUpperCase();"/><?php echo $dataKeterangan; ?></textarea>
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
			                <a href="?page=dtreff" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>