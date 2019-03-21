<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysql_query("DELETE FROM ms_merk WHERE kode_merk='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data merk barang berhasil dihapus';
				echo '<script>window.location="?page=dtmrk"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Data Merk Barang</span></div>
			<div class="actions">
				<a href="?page=addmrk" class="btn green active"><i class="icon-plus"></i> ADD DATA</a>	
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
                        <th width="10%"><div align="center">KODE</div></th>
                        <th width="10%"><div align="center">INISIAL</div></th>
                        <th width="24%">NAMA MERK & BRAND</th>
						<th width="53%">KETERANGAN & CATATAN</th>
			  	  	  <th width="11%"><div align="center">STATUS</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM ms_merk ORDER BY kode_merk DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['kode_merk'];
					?>
                   <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><a href="?page=edtmrk&amp;id=<?php echo encrypt($Kode); ?>"><?php echo $data ['kode_merk']; ?></a></div></td>
						<td><div align="center"><?php echo $data ['inisial_merk']; ?></div></td>
						<td><?php echo $data ['nama_merk']; ?></td>
						<td><?php echo $data ['keterangan_merk']; ?></td>
                        <td class="hidden-phone">
						  <div align="center">
						    <?php 
						if($data ['status_merk']=='Active'){
							echo "<label class='label label-success'>Active</label>";
						}else{
							echo "<label class='label label-danger'>Non Active</label>";
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