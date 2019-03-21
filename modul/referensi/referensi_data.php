<?php			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysql_query("DELETE FROM ms_referensi WHERE kode_referensi='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data referensi penjualan berhasil dihapus';
				echo '<script>window.location="?page=dtreff"</script>';
			}	
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Data Referensi Penjualan</span></div>
			<div class="actions">
				<a href="?page=addreff" class="btn green active"><i class="icon-plus"></i> ADD DATA</a>	
				<button class="btn green active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
		<div class="portlet-body">     	
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr>
       	  	  	  	  	<th class="table-checkbox" width="3%">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>
                      	<th width="9%"><div align="center">KODE</div></th>
                        <th width="21%">NAMA REFERENSI</th>
						<th width="42%">KETERANGAN</th>
			  	  	  <th width="10%"><div align="center">STATUS</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM ms_referensi ORDER BY kode_referensi DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query expedisi salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['kode_referensi'];
					?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><a href="?page=edtreff&amp;id=<?php echo encrypt($Kode); ?>"><?php echo $data ['kode_referensi']; ?></a></div></td>
						<td><?php echo $data ['nama_referensi']; ?></td>
						<td><?php echo $data ['keterangan_referensi']; ?></td>
                        <td>
						  <div align="center">
						    <?php 
						if($data ['status_referensi']=='Active'){
							echo "<label class='label label-success'>Active</label>";
						}else{
							echo "<label class='label label-important'>Non Active</label>";
						}
						?>						
				        </div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>