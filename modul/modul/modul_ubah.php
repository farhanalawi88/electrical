<?php
	
	if(isset($_POST['btnSave'])){
		$message = array();
		if (trim($_POST['txtModul'])=="") {
			$message[] = "<b>Nama Modul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtLink'])=="") {
			$message[] = "<b>Link modul</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbMenu'])=="") {
			$message[] = "<b>Menu utama</b> tidak boleh kosong !";		
		}
		
		$txtKode		= $_POST['txtKode'];
		$txtModul		= $_POST['txtModul'];
		$txtLink		= $_POST['txtLink'];
		$cmbMenu		= $_POST['cmbMenu'];
		$txtUrutan		= $_POST['txtUrutan'];
		
		if(count($message)==0){
			$sqlSave	= "UPDATE sys_submenu SET submenu_nama='$txtModul', 
									 							submenu_link='$txtLink', 
																submenu_menu='$cmbMenu', 
																submenu_urutan='$txtUrutan',
																submenu_diubah='".date('Y-m-d')."'
													WHERE submenu_id='$txtKode'";
			$qrySave	= mysql_query($sqlSave, $koneksidb) or die ("gagal insert". mysql_error());
			if($qrySave){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data modul berhasil diperbaharui';
				echo '<script>window.location="?page=dtmdl"</script>';
			}
			exit;
		}	
		
		if (! count($message)==0 ){
			echo "<div class='alert note note-warning'>
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
	$sqlShow			= "SELECT * FROM sys_submenu WHERE submenu_id='".decrypt($KodeEdit)."'";
	$qryShow 			= mysql_query($sqlShow, $koneksidb)  or die ("Query ambil data department salah : ".mysql_error());
	$dataShow			= mysql_fetch_array($qryShow);
	
	$dataKode			= $dataShow['submenu_id'];
	$dataModul			= isset($_POST['txtModul']) ? $_POST['txtModul'] : $dataShow['submenu_nama'];
	$dataLink			= isset($_POST['txtLink']) ? $_POST['txtLink'] : $dataShow['submenu_link'];
	$dataMenu			= isset($_POST['cmbMenu']) ? $_POST['cmbMenu'] : $dataShow['submenu_menu'];
	$dataUrutan			= isset($_POST['txtUrutan']) ? $_POST['txtUrutan'] : $dataShow['submenu_urutan'];
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Perubahan Modul</span></div>
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
					<label class="col-lg-2 control-label">Nama Modul :</label>
					<div class="col-lg-3">
						<input type="text" name="txtModul" value="<?php echo $dataModul; ?>" class="form-control"/>
						<input type="hidden" name="txtKode" value="<?php echo $dataKode; ?>" class="form-control"/>
		             </div>
				</div>
		        <div class="form-group">
					<label class="col-lg-2 control-label">Link Modul :</label>
					<div class="col-lg-4">
						<input type="text" name="txtLink" value="<?php echo $dataLink; ?>" class="form-control"/>
		             </div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Menu Utama :</label>
					<div class="col-lg-2">
						<select name="cmbMenu" data-placeholder="- Pilih Menu -" class="select2 form-control">
							<option value=""></option> 
							<?php
								  $dataSql = "SELECT * FROM sys_menu ORDER BY menu_id DESC";
								  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
								  while ($dataRow = mysql_fetch_array($dataQry)) {
									if ($dataMenu == $dataRow['menu_id']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[menu_id]' $cek>$dataRow[menu_nama]</option>";
								  }
								  $sqlData ="";
							?>
						</select>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-lg-2 control-label">Urutan Modul :</label>
					<div class="col-lg-2">
						<input type="number" name="txtUrutan" value="<?php echo $dataUrutan; ?>" class="form-control"/>
		             </div>
				</div>
    		</div>
	    	<div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
		                <button type="submit" name="btnSave" class="btn green"><i class="fa fa-save"></i> Simpan Data</button>
		                <a href="?page=dtmdl" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>
		