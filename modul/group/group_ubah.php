<?php	
if(isset($_POST['btnSave'])){
	$message = array();
	if (trim($_POST['txtNama'])=="") {
		$message[] = "<b>Nama group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}
	if (trim($_POST['cmbStatus'])=="") {
		$message[] = "<b>Status group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}
	if (trim($_POST['cmbLevel'])=="") {
		$message[] = "<b>Level group</b> tidak boleh kosong, silahkan isi terlebih dahulu !";		
	}
	
	
	$txtNama		= $_POST['txtNama'];
	$txtNamaLm		= $_POST['txtNamaLm'];
	$txtModul		= $_POST['txtModul'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbStatus		= $_POST['cmbStatus'];
	$txtKode		= $_POST['txtKode'];
	$cmbLevel		= $_POST['cmbLevel'];
	
			
	if(count($message)==0){		

		$delete=mysql_query("DELETE FROM sys_akses WHERE akses_group='$txtKode'", $koneksidb) 
								or die ("Gagal kosongkan tmp".mysql_error());		
		foreach ($txtModul as $id_key) {
			$simpanModul=mysql_query("INSERT INTO sys_akses SET akses_group='$txtKode',
																akses_submenu='$id_key',
																akses_dibuat='".date('Y-m-d')."'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
		}
		
		$qrySave		= mysql_query("UPDATE sys_group SET group_nama='$txtNama', 
															group_keterangan='$txtKeterangan',
															group_level='$cmbLevel', 
															group_status='$cmbStatus'
														WHERE group_id='".$_POST['txtKode']."'", $koneksidb) 
							  or die ("Gagal query".mysql_error());
		if($qrySave){	
			$_SESSION['info'] = 'success';					
			$_SESSION['pesan'] = 'Data group akses berhasil diperbaharui';
			echo '<script>window.location="?page=dtgrp"</script>';
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

			
$kodeTransaksi 		= decrypt($_GET['id']);
$beliSql 			= "SELECT * FROM sys_group WHERE group_id='$kodeTransaksi'";
$beliQry 			= mysql_query($beliSql, $koneksidb)  or die ("Query pendaftaran salah : ".mysql_error());
$beliRow 			= mysql_fetch_assoc($beliQry);

$dataKode			= $beliRow['group_id'];
$dataNamaLm			= $beliRow['group_nama'];
$dataNama			= isset($_POST['txtNama']) ? $_POST['txtNama'] : $beliRow['group_nama'];
$dataKeterangan		= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $beliRow['group_keterangan'];
$dataStatus			= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : $beliRow['group_status'];
$dataLevel			= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $beliRow['group_level'];
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
            <span class="caption-subject uppercase">Form Perubahan Group</span>
        </div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
			<div class="form-body">
		    	<div class="row">
		      		<div class="col-lg-4">
		        		<div class="form-group">
		          		<label class="form-control-label">Nama Group :</label>
			        	<input class="form-control" type="text" name="txtNama" value="<?php echo $dataNama ?>" placeholder="Masukkan Nama" onkeyup="javascript:this.value=this.value.toUpperCase();">
			          	<input class="form-control" type="hidden" name="txtNamaLm" value="<?php echo $dataNamaLm ?>">
			          	<input class="form-control" type="hidden" name="txtKode" value="<?php echo $dataKode ?>">
		        		</div>
		      		</div><!-- col-4 -->
		      		<div class="col-lg-4">
		        		<div class="form-group">
				          <label class="form-control-label">Keterangan :</label>
				          <input class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" name="txtKeterangan" value="<?php echo $dataKeterangan ?>" placeholder="Masukkan Keterangan">
		        		</div>
		      		</div>
		      		<div class="col-lg-2">
				        <div class="form-group">
				    	    <label class="form-control-label">Level Group :</label>
				        	<select class="form-control select2" data-placeholder="Pilih Level" name="cmbLevel">
			                	<option value=""></option>
			               		<?php
								  $pilihan	= array("User", "Admin");
								  foreach ($pilihan as $nilai) {
									if ($dataLevel==$nilai) {
										$cek=" selected";
									} else { $cek = ""; }
									echo "<option value='$nilai' $cek>$nilai</option>";
								  }
								?>
			              	</select>
				        </div>
				    </div>
		      		<div class="col-lg-2">
		        		<div class="form-group">
		          			<label class="form-control-label">Status Group :</label>
					        <select class="form-control select2" data-placeholder="Pilih Status" name="cmbStatus">
				                <option value=""></option>
				                <?php
									  $pilihan	= array("Active", "Non Active");
									  foreach ($pilihan as $nilai) {
										if ($dataStatus==$nilai) {
											$cek=" selected";
										} else { $cek = ""; }
										echo "<option value='$nilai' $cek>$nilai</option>";
									  }
								?>
				            </select>
		        		</div>
		      		</div><!-- col-4 -->
		     	</div>
		     	<hr>
			    <div class="row">
			     	<div class="col-lg-12">    	
		            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
						<thead>
		                    <tr>
		       	  	  	  	  	<th class="table-checkbox">
		                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
		                                <span></span>
		                            </label>
		                        </th>
						  		<th width="50%">NAMA MODUL</th>
								<th width="46%">MENU UTAMA</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dataSql	= "SELECT * FROM sys_submenu 
												INNER JOIN sys_menu ON sys_submenu.submenu_menu=sys_menu.menu_id";
								$dataQry 	= mysql_query($dataSql, $koneksidb)  
												or die ("Query sys_akses salah : ".mysql_error());
								$nomor 		= 0; 
								while ($data= mysql_fetch_array($dataQry)) {
								$nomor++;
								$Kode 		= $data['akses_group'];
								$QryCari	= mysql_query("SELECT * FROM sys_akses
												WHERE akses_group='$dataKode' 
												AND akses_submenu='$data[submenu_id]'", $koneksidb) 
												or die ("gagal ambil ".mysql_error());
								$dataCari	= mysql_fetch_array($QryCari);
								if(mysql_num_rows($QryCari)>=1){
									$kondisi= "checked";
								}else{
									$kondisi= "";
								}
							?>
							<tr class="odd gradeX">
		                        <td>
		                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                <input type="checkbox" class="checkboxes" <?php echo $kondisi ?> value="<?php echo $data['submenu_id']; ?>" name="txtModul[<?php echo $data['submenu_id']; ?>]"/>
		                                <span></span>
		                            </label>
		                        </td>
								<td><?php echo $data ['submenu_nama']; ?></td>
								<td><?php echo $data ['menu_nama']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					</div>
		     	</div>
		    </div>
		    <div class="form-actions">
			    <div class="row">
			        <div class="form-group">
			                <button type="submit" name="btnSave" class="btn green"><i class="fa fa-save"></i> Simpan Data</button>
			                <a href="?page=dtgrp" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>