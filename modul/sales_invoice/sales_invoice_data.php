<?php			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
			$cekSql 		="SELECT * FROM tr_si_item a
								INNER JOIN tr_si b ON b.kode_si=a.kode_si
								WHERE a.kode_si='$id_key'";
			$cekQry 		= mysql_query($cekSql, $koneksidb) or die ("Gagal select transaksi".mysql_error());
			$cekRow 		= mysql_fetch_assoc($cekQry);
			if($cekRow['status_si']=='Open'){
				$tranHapus 		= mysql_query("DELETE FROM tr_si WHERE kode_si='$id_key'", $koneksidb) 
					or die ("Gagal kosongkan si".mysql_error());
				$transItmHapus	= mysql_query("DELETE FROM tr_si_item WHERE kode_si='$id_key'", $koneksidb) 
					or die ("Gagal kosongkan si detail".mysql_error());

				$bliHapus		= mysql_query("UPDATE tr_penjualan SET status_penjualan='Open' WHERE kode_penjualan='".$cekRow['kode_penjualan']."'", $koneksidb) 
				or die ("Gagal kosongkan pembelian header".mysql_error());
				
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data sales invoice berhasil dihapus';
				echo '<script>window.location="?page=dtsi"</script>';
				
			}else{
				$_SESSION['info'] = 'warning';
				$_SESSION['pesan'] = 'Terdapat sebagian data sales invoice yang tidak bisa dihapus';
				echo '<script>window.location="?page=dtsi"</script>';
			}
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
	<div class="portlet box green">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Data Sales Invoice</span></div>
			<div class="actions">
				<a href="?page=addsi" class="btn green active"><i class="icon-plus"></i><span class="phone-hidden"> ADD DATA</span></a>	
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
						<th width="20%">REFERENSI DARI</th>
						<th width="20%">DIBUAT OLEH</th>
						<th width="10%"><div align="right">NOMINAL</div></th>
						<th width="10%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						
						$dataSql = "SELECT 
									a.kode_si,
									DATE_FORMAT(a.tgl_si,'%d/%m/%Y') as tgl_si,
									b.nama_referensi,
									c.nama_user,
									a.status_si,
									SUM(d.total_penjualan) as total_si
									FROM tr_si a
									INNER JOIN ms_referensi b ON a.kode_referensi=b.kode_referensi
									INNER JOIN ms_user c ON a.kode_user=c.kode_user
									INNER JOIN tr_si_item d ON d.kode_si=a.kode_si
									GROUP BY 
									a.kode_si,
									a.tgl_si,
									b.nama_referensi,
									c.nama_user,
									a.status_si
									ORDER BY a.tgl_si DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode 		= $data['kode_si'];
						if($data ['status_si']=='Open'){
							$dataStatus= "class='warning'";
						}elseif($data ['status_si']=='Close'){
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
						<td><div align="center"><?php echo $data ['tgl_si']; ?></div></td>
						<td <?php echo $dataStatus ?>><div align="center"><?php echo $Kode; ?></div></td>
						<td><?php echo $data ['nama_referensi']; ?></td>
						<td><?php echo $data ['nama_user']; ?></td>
						<td><div align="right"><?php echo number_format($data ['total_si'],2); ?></div></td>
						<td><div align="center"><a href="?page=dtlsi&amp;id=<?php echo encrypt($Kode); ?>" class="btn green btn-xs"><i class="icon-book-open"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
			</div>
		</div>
	</div>
</form>