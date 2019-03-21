<?php
			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			mysql_query("DELETE FROM user WHERE kode_user='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
					
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Daftar Admin & Kasir</span>
	        </div>
	        <div class="actions">
				<a href="?page=addusr" class="btn green active"><i class="icon-plus"></i> ADD DATA </a>
				<button class="btn green active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
			</div>
		</div>
    	<div class="portlet-body">
           <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
				<thead>
                    <tr>
       	  	  	  	  	<th class="table-checkbox">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                <span></span>
                            </label>
                        </th>

						<th width="7%"><div align="center">KODE</div></th>
                        <th width="23%">NAMA USER</th>
                        <th width="15%" class="hidden-phone">USERNAME</th>
						<th width="16%" class="hidden-phone">NO. TELEPON</th>
						<th width="15%" class="hidden-phone">EMAIL</th>
						<th width="13%" class="hidden-phone">GROUP LEVEL</th>
						<th width="9%" class="hidden-phone"><div align="center">STATUS</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT * FROM ms_user a 
									INNER JOIN sys_group b ON a.user_group=b.group_id
									ORDER BY kode_user DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode = encrypt($data['kode_user']);
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><a href="?page=edtusr&amp;id=<?php echo $Kode; ?>"><?php echo $data ['kode_user']; ?></a></div></td>
						<td><?php echo $data ['nama_user']; ?></td>
						<td class="hidden-phone"><?php echo $data ['username_user']; ?></td>
						<td class="hidden-phone"><?php echo $data ['telp_user']; ?></td>
						<td class="hidden-phone"><?php echo $data ['email_user']; ?></td>
						<td class="hidden-phone"><?php echo $data ['group_nama']; ?></td>
						<td class="hidden-phone">
						  <div align="center">
						    <?php 
						if($data ['status_user']=='Active'){
							echo "<label class='label label-success'>Active</label>";
						}else{
							echo "<label class='label label-danger'>Non Active</label>";
						}
						?>						
				        </div></td>
                    </tr>
                    <?php
                        
                    }
                    ?>
				</tbody>
            </table>
  		</div>
	</div>
</form>