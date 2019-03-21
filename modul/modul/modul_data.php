<?php
	// Menghapus Data
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysql_query("DELETE FROM sys_submenu WHERE submenu_id='$id_key'",$koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
					if($hapus){
						$_SESSION['info'] = 'success';
            $_SESSION['pesan'] = 'Data modul berhasil dihapus';
            echo '<script>window.location="?page=dtmdl"</script>';
          }
		
        }
	}	
	
	
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase">Data Menu & Modul</span>
	        </div>
	        <div class="actions">
				<a href="?page=addmdl" class="btn green active"><i class="icon-plus"></i> ADD DATA </a>
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
                        <th width="37%">NAMA MODUL</th>
                        <th width="22%" class="hidden-phone"> MENU</th>
						<th width="23%" class="hidden-phone">LINK</th>
						<th width="16%" class="hidden-phone"><div align="center">URUTAN</div></th>
                    </tr>
				</thead>
				<tbody>
               <?php
						$dataSql = "SELECT * FROM sys_submenu a
									INNER JOIN sys_menu b ON a.submenu_menu=b.menu_id
									ORDER BY a.submenu_id ASC";
						$dataQry = mysql_query($dataSql, $koneksidb);
						$nomor  = 0; 
						while ($data = mysql_fetch_assoc($dataQry)) {
						$nomor++;
						$Kode = $data['submenu_id'];
				?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><a href="?page=edtmdl&amp;id=<?php echo encrypt($Kode); ?>"><?php echo $data ['submenu_nama']; ?></a></td>
						<td class="hidden-phone"><?php echo $data['menu_nama']; ?></td>
						<td class="hidden-phone"><?php echo $data['submenu_link']; ?></td>
						<td class="hidden-phone">
						  <div align="center">
						    <?php echo $data ['submenu_urutan'] ?>						
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
    	