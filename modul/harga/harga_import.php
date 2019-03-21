<?php
	if(isset($_POST['btnSave'])){
		$message = array();
		if (empty($_FILES['txtFile'])) {
			$message[] = "File import tidak boleh kosong!";		
		}
				
		$data 		= new Spreadsheet_Excel_Reader($_FILES['txtFile']['tmp_name'],false);
		$hasildata 	= $data->rowcount($sheet_index=0);
				
		
		
		if(count($message)==0){			
			$qrySaveTrans		= mysql_query("INSERT INTO tr_harga SET tgl_berlaku='".date('Y-m-d H:i:s')."', 
																		status_harga='Open',  
																		tgl_dibuat='".date('Y-m-d H:i:s')."',
																		keterangan_harga='UPDATE HARGA BARANG & PRODUK PADA TANGGAL ".date('d-m-Y')." (IMPORT)',
																		kode_user='".$_SESSION['kode_user']."'") 
								  or die ("Gagal query".mysql_error());
			if($qrySaveTrans){
				$itemTransSql 		="SELECT MAX(id_harga) as id_harga FROM tr_harga WHERE kode_user='".$_SESSION['kode_user']."'";
				$itemTransQry 		= mysql_query($itemTransSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
				$itemTransRow 		= mysql_fetch_assoc($itemTransQry);
			}
			for ($i=6; $i<=$hasildata; $i++){
					$txtNama 		= $data->val($i,2); 
				  	$txtHBeliLm 	= $data->val($i,4);
				  	$txtHJualLm 	= $data->val($i,5);
				  	$txtHBeli 		= $data->val($i,6);
				  	$txtHJual 		= $data->val($i,7);
				  	$txtIDHarga 	= $itemTransRow['id_harga']; 
				  	$txtHBeliLm 	= str_replace(",","",$txtHBeliLm);
				  	$txtHJualLm 	= str_replace(",","",$txtHJualLm);
				  	$txtHBeli 		= str_replace(",","",$txtHBeli);
				  	$txtHJual 		= str_replace(",","",$txtHJual);
				  	$txtHBeliFix 	= str_replace("Rp","",$txtHBeli);
				  	$txtHJualFix 	= str_replace("Rp","",$txtHJual);

					$kodeSql 		="SELECT * FROM ms_barang WHERE nama_barang='$txtNama'";
					$kodeQry 		= mysql_query($kodeSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
					$kodeRow 		= mysql_fetch_assoc($kodeQry);



				 if(!empty($txtHJual) || !empty($txtHBeli)){
				 	$tmpSql = "INSERT INTO tr_harga_item SET kode_barang='$kodeRow[kode_barang]',
															harga_beli_lama='$kodeRow[harga_beli]',
															harga_jual_lama='$kodeRow[harga_jual]',
															harga_beli='$txtHBeliFix',
															harga_jual='$txtHJualFix',
															id_harga='$txtIDHarga'";
					mysql_query($tmpSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
				}
				  
			}
			if($tmpSql){
				$_SESSION['info'] = 'success';	
				$_SESSION['pesan'] = 'Harga barang berhasil diperbaharui';
				echo '<script>window.location="?page=dtlhrg&id='.encrypt($itemTransRow['id_harga']).'"</script>';
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
			
	$dataTanggal	= date('d-m-Y');
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';
	$dataInisial	= isset($_POST['txtInisial']) ? $_POST['txtInisial'] : '';
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Import Harga Barang & Produk</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Tgl. Berlaku :</label>
					<div class="col-md-2">
						<input class="form-control" type="text" value="<?php echo $dataTanggal; ?>" disabled="disabled"/>
					</div>
				</div>
				<div class="form-group last">
					<label class="col-md-2 control-label">File Import :</label>
					<div class="col-md-3">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                </div>
                                <span class="input-group-addon btn default btn-file">
                                    <span class="fileinput-new"> Select file </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="txtFile"> </span>
                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="form-actions">
			    <div class="row">
			        <div class="form-group">
			            <div class="col-lg-offset-2 col-lg-10">
			                <button type="submit" name="btnSave" class="btn green"><i class="fa fa-save"></i> Proses Import</button>
			                <a href="./export/form_import_harga.php" class="btn green"><i class="fa fa-download"></i> Download Item</a>
			                <a href="?page=dthrg" class="btn green"><i class="fa fa-undo"></i> Batalkan</a>
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>