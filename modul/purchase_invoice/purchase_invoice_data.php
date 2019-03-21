<?php			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
			$cekSql 		="SELECT * FROM tr_pi_item a
								INNER JOIN tr_pi b ON b.kode_pi=a.kode_pi
								WHERE a.kode_pi='$id_key'";
			$cekQry 		= mysql_query($cekSql, $koneksidb) or die ("Gagal select transaksi".mysql_error());
			$cekRow 		= mysql_fetch_assoc($cekQry);
			if($cekRow['status_pi']=='Open'){
				$tranHapus 		= mysql_query("DELETE FROM tr_pi WHERE kode_pi='$id_key'", $koneksidb) 
					or die ("Gagal kosongkan pi".mysql_error());
				$transItmHapus	= mysql_query("DELETE FROM tr_pi_item WHERE kode_pi='$id_key'", $koneksidb) 
					or die ("Gagal kosongkan pi detail".mysql_error());

				$bliHapus		= mysql_query("UPDATE tr_pembelian SET status_pembelian='Open' WHERE kode_pembelian='".$cekRow['kode_pembelian']."'", $koneksidb) 
				or die ("Gagal kosongkan pembelian header".mysql_error());
				
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data purchase invoice berhasil dihapus';
				echo '<script>window.location="?page=dtpi"</script>';
				
			}else{
				$_SESSION['info'] = 'warning';
				$_SESSION['pesan'] = 'Terdapat sebagian data purchase invoice yang tidak bisa dihapus';
				echo '<script>window.location="?page=dtpi"</script>';
			}
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
	<div class="portlet box green">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Data Purchase Invoice</span></div>
			<div class="actions">
				<a href="?page=addpi" class="btn green active"><i class="icon-plus"></i> ADD DATA</a>	
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
                      	<th width="5%"><div align="center">NO</div></th>
                      	<th width="15%"><div align="center">TGL. INVOICE</div></th>
                        <th width="15%"><div align="center">NO. INVOICE </div></th>
						<th width="20%">NAMA SUPPLIER</th>
						<th width="20%">DIBUAT OLEH</th>
						<th width="10%"><div align="right">NOMINAL</div></th>
						<th width="10%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>

				<tbody>
                    <?php
						
						$dataSql = "SELECT 
									a.kode_pi,
									DATE_FORMAT(a.tgl_pi,'%d/%m/%Y') as tgl_pi,
									a.no_referensi,
									b.nama_supplier,
									c.nama_user,
									a.status_pi,
									SUM(d.total_pembelian) as total_pi
									FROM tr_pi a
									INNER JOIN ms_supplier b ON a.kode_supplier=b.kode_supplier
									INNER JOIN ms_user c ON a.kode_user=c.kode_user
									INNER JOIN tr_pi_item d ON d.kode_pi=a.kode_pi
									GROUP BY 
									a.kode_pi,
									a.tgl_pi,
									a.no_referensi,
									b.nama_supplier,
									c.nama_user,
									a.status_pi
									ORDER BY a.tgl_pi DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode 		= $data['kode_pi'];
						if($data ['status_pi']=='Open'){
							$dataStatus= "class='warning'";
						}elseif($data ['status_pi']=='Close'){
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
						<td><div align="center"><?php echo $data ['tgl_pi']; ?></div></td>
						<td <?php echo $dataStatus ?>><div align="center"><?php echo $Kode; ?></div></td>
						<td><?php echo $data ['nama_supplier']; ?></td>
						<td><?php echo $data ['nama_user']; ?></td>
						<td><div align="right"><?php echo number_format($data ['total_pi'],2); ?></div></td>
						<td><div align="center"><a href="?page=dtlpi&amp;id=<?php echo encrypt($Kode); ?>" class="btn green btn-xs"><i class="icon-book-open"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
			</div>
		</div>
	</div>
</form>