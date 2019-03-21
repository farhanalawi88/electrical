<?php
					
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
			$cekSql 		="SELECT 
								a.status_transaksi,
								b.kode_pembelian,
								c.kode_penjualan
								FROM tr_transaksi a
								INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
								INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
								WHERE a.kode_transaksi='$id_key'";
			$cekQry 		= mysql_query($cekSql, $koneksidb) or die ("Gagal select transaksi".mysql_error());
			$cekRow 		= mysql_fetch_assoc($cekQry);
			if($cekRow['status_transaksi']=='Open'){
				$tranHapus 		= mysql_query("DELETE FROM tr_transaksi WHERE kode_transaksi='$id_key'", $koneksidb) 
					or die ("Gagal kosongkan transaksi".mysql_error());
				$transItmHapus	= mysql_query("DELETE FROM tr_transaksi_item WHERE kode_transaksi='$id_key'", $koneksidb) 
					or die ("Gagal kosongkan transaksi detail".mysql_error());

				$bliHapus		= mysql_query("DELETE FROM tr_pembelian WHERE kode_transaksi='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan pembelian header".mysql_error());

				$bliItmHapus	= mysql_query("DELETE FROM tr_pembelian_item WHERE kode_pembelian='".$cekRow['kode_pembelian']."'", $koneksidb) 
				or die ("Gagal kosongkan pembelian detail".mysql_error());

				$pjlHapus 		= mysql_query("DELETE FROM tr_penjualan WHERE kode_transaksi='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan penjualan header".mysql_error());

				$pjlItmHapus	= mysql_query("DELETE FROM tr_penjualan_item WHERE kode_penjualan='".$cekRow['kode_penjualan']."'", $koneksidb) 
				or die ("Gagal kosongkan penjualan detail".mysql_error());
				$_SESSION['info'] = 'success';
				$_SESSION['pesan'] = 'Data transaksi barang berhasil dihapus';
				echo '<script>window.location="?page=dttrx"</script>';
				
			}else{
				$_SESSION['info'] = 'warning';
				$_SESSION['pesan'] = 'Terdapat sebagian data yg tidak bisa dihapus dikarenakan status transaksi sudah close';
				echo '<script>window.location="?page=dttrx"</script>';
			}
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class="portlet box green">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Daftar Transaksi Order</span></div>
			<div class="actions">
				<a href="?page=addtrx" class="btn green active"><i class="icon-plus"></i> ADD DATA</a>	
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
                      	<th width="10%"><div align="center">TGL. TRANSAKSI</div></th>
                        <th width="15%"><div align="center">NO. ORDER </div></th>
                        <th width="15%"><div align="center">NO. PENJUALAN </div></th>
						<th width="10%">REFERENSI DARI</th>
                        <th width="25%">NO. REFERENSI</th>
						<th width="20%">NAMA CUSTOMER</th>
						<th width="20%"><div align="center">ACTION</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						
						$dataSql = "SELECT 
									a.kode_transaksi,
									b.status_pembelian,
									c.status_penjualan,
									b.kode_pembelian,
									c.kode_penjualan,
									DATE_FORMAT(a.tgl_transaksi,'%d/%m/%Y') as tgl_transaksi,
									e.nama_referensi,
									c.nama_customer,
									c.no_referensi
						 			FROM tr_transaksi a
									INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
									INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
									INNER JOIN ms_user d ON a.kode_user=d.kode_user
									INNER JOIN ms_referensi e ON c.kode_referensi=e.kode_referensi
									ORDER BY a.tgl_transaksi DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode 		= $data['kode_transaksi'];
						if($data ['status_pembelian']=='Open'){
							$dataStatus= "class='warning'";
						}elseif($data ['status_pembelian']=='Cancel'){
							$dataStatus= "class='danger'";
						}elseif($data ['status_pembelian']=='Close'){
							$dataStatus= "class='success'";
						}

						if($data ['status_penjualan']=='Open'){
							$dataStatus2= "class='warning'";
						}elseif($data ['status_penjualan']=='Cancel'){
							$dataStatus2= "class='danger'";
						}elseif($data ['status_penjualan']=='Close'){
							$dataStatus2= "class='success'";
						}
					?>
                    <tr>
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><?php echo $nomor; ?></div></td>
						<td><div align="center"><?php echo $data ['tgl_transaksi']; ?></div></td>
						<td <?php echo $dataStatus ?>><div align="center"><?php echo $data ['kode_pembelian']; ?></a></div></td>
						<td <?php echo $dataStatus2 ?>><div align="center"><?php echo $data ['kode_penjualan']; ?></div></td>
						<td><?php echo $data ['nama_referensi']; ?></td>
						<td><?php echo $data ['no_referensi']; ?></td>
						<td><?php echo $data ['nama_customer']; ?></td>
						<td><div align="center"><a href="?page=dtltrx&amp;id=<?php echo encrypt($Kode); ?>" class="btn green btn-xs"><i class="icon-book-open"></i></a></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
		</div>
	</div>
</form>