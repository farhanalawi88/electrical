<?php			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysql_query("DELETE FROM ms_supplier WHERE kode_supplier='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
			if($hapus){
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data supplier berhasil dihapus';
				echo '<script>window.location="?page=dtsupp"</script>';
			}	
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject uppercase">Data Supplier</span>
			</div>
			<div class="actions">
				<a href="?page=addsupp" class="btn green active"><i class="icon-plus"></i> ADD DATA</a>	
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
                        <th width="20%">NAMA SUPPLIER</th>
						<th width="21%">JENIS</th>
						<th width="13%">NO. TELP</th>
						<th width="15%">ALAMAT</th>
			  	  	  <th width="9%"><div align="center">STATUS</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM ms_supplier ORDER BY kode_supplier DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query supplier salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode = $data['kode_supplier'];
					?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><a href="?page=edtsupp&amp;id=<?php echo $Kode; ?>"><?php echo $Kode; ?></a></div></td>
						<td><?php echo $data ['nama_supplier']; ?></td>
						<td><?php echo $data ['jenis_supplier']; ?></td>
						<td><?php echo $data ['telp_supplier']; ?></td>
						<td><?php echo $data ['alamat_supplier']; ?></td>
                        <td>
						  <div align="center">
						    <?php 
						if($data ['status_supplier']=='Active'){
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