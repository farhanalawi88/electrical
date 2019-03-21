<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
			$cekSql 		="SELECT * FROM tr_harga a WHERE a.id_harga='$id_key'";
			$cekQry 		= mysql_query($cekSql, $koneksidb) or die ("Gagal select transaksi".mysql_error());
			$cekRow 		= mysql_fetch_assoc($cekQry);
			if($cekRow['status_harga']=='Open'){

				$hapus=mysql_query("DELETE FROM tr_harga WHERE id_harga='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());

			
				if($hapus){	
					$itemHapus=mysql_query("DELETE FROM tr_harga_item WHERE id_harga='$id_key'", $koneksidb) 
					or die ("Gagal kosongkan tmp".mysql_error());
					$_SESSION['info'] = 'success';
					$_SESSION['pesan'] = 'Data barang dan item berhasil dihapus';
					echo '<script>window.location="?page=dthrg"</script>';
				}	
			}else{
				$_SESSION['info'] = 'warning';
				$_SESSION['pesan'] = 'Terdapat data harga barang dan item yang tidak bisa dihapus dikarenakan status close';
				echo '<script>window.location="?page=dthrg"</script>';
			}
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Data Harga Barang & Item</span></div>
			<div class="actions">
				<a href="?page=imprthrg" class="btn green active"><i class="icon-cloud-upload"></i> IMPORT DATA</a>
				<a href="?page=addhrg" class="btn green active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn green active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
		<div class="portlet-body">     	
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr class="active">
       	  	  	  	  	<th class="table-checkbox" width="3%">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>
                      	<th width="2%"><div align="center">NO</div></th>
                      	<th width="10%"><div align="center">TGL. BERLAKU </div></th>
                        <th width="60%">KETERANGAN</th>
						<th width="20%">DIBUAT</th>
                      	<th width="10%"><div align="center">ACTION </div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT 
									a.status_harga,
									a.keterangan_harga,
									c.nama_user,
									a.id_harga,
									DATE_FORMAT(a.tgl_berlaku, '%m/%d/%Y %H:%i') as tgl_berlaku
									FROM tr_harga a
									INNER JOIN ms_user c ON a.kode_user=c.kode_user
									ORDER BY a.id_harga DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['id_harga'];
						if($data ['status_harga']=='Open'){
							$dataStatus= "class='warning'";
						}elseif($data ['status_harga']=='Close'){
							$dataStatus= "class='success'";
						}
					?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor; ?></div></td>
						<td><div align="center"><?php echo $data ['tgl_berlaku']; ?></div></td>
						<td <?php echo $dataStatus ?>><?php echo $data ['keterangan_harga']; ?></td>
						<td><?php echo $data ['nama_user']; ?></td>
						<td><div align="center">
							<div class="btn-group">
								<a href="?page=dtlhrg&amp;id=<?php echo encrypt($Kode); ?>" class="btn green btn-xs"><i class="icon-book-open"></i></a>
								<a href="./export/print_perubahan_harga.php?id=<?php echo $Kode; ?>" target="_BLANK" class="btn blue btn-xs"><i class="icon-printer"></i></a>
							</div>
						</div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>
