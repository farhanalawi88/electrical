<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysql_query("DELETE FROM ms_kategori WHERE kode_kategori='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data kategori barang berhasil dihapus';
				echo '<script>window.location="?page=dtktgr"</script>';
			}	
					
		}
	}
 ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Data Kategori Barang</span></div>
			<div class="actions">
				<a href="?page=addktgr" class="btn green active"><i class="icon-plus"></i> ADD DATA</a>	
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
                        <th width="24%">NAMA KETEGORI</th>
						<th width="53%">KETERANGAN & CATATAN</th>
			  	  	  <th width="11%"><div align="center">STATUS</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM ms_kategori ORDER BY kode_kategori DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['kode_kategori'];
					?>
                   <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><a href="?page=edtktgr&amp;id=<?php echo encrypt($Kode); ?>"><?php echo $data ['kode_kategori']; ?></a></div></td>
						<td><?php echo $data ['inisial_kategori']; ?></td>
						<td><?php echo $data ['nama_kategori']; ?></td>
						<td><?php echo $data ['keterangan_kategori']; ?></td>
                        <td>
						  <div align="center">
						    <?php 
						if($data ['status_kategori']=='Active'){
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