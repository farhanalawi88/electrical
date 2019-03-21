<?php			
	if(isset($_POST['btnHapus'])){
		$txtID 		= $_POST['txtID'];
		foreach ($txtID as $id_key) {
				
			$hapus=mysql_query("DELETE FROM tr_penjualan WHERE kode_penjualan='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
			
			if($hapus){	
				$itemHapus=mysql_query("DELETE FROM tr_penjualan_item WHERE kode_penjualan='$id_key'", $koneksidb) 
				or die ("Gagal kosongkan tmp".mysql_error());
				
				$_SESSION['pesan'] = 'Data transaksi penjualan berhasil dihapus';
				echo '<script>window.location="?page=dtpjl"</script>';
			}
			
		}
	}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
	<div class="portlet">
		<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase bold">Daftar Penjualan Barang</span></div>
			<div class="actions">
				<a href="?page=addpjl" class="btn blue"><i class="icon-plus"></i> Tambah Data</a>	
				<button class="btn blue" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> Hapus Data</button>
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
                        <th width="9%"><div align="center">NO. TRANSAKSI </div></th>
                        <th width="12%"><div align="center">TGL. TRANSAKSI</div></th>
						<th width="15%">NAMA EXPEDISI</th>
						<th width="20%">NAMA CUSTOMER</th>
						<th width="17%"><div align="left">OPERATOR</div></th>
					  	<th width="10%"><div align="right">PENJUALAN</div></th>
					  	<th width="10%"><div align="right">JASA KIRIM</div></th>
					  	<th width="10%"><div align="right">SUBTOTAL</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
						$dataSql = "SELECT * FROM tr_penjualan a
									INNER JOIN ms_user b ON a.kode_user=b.kode_user
									LEFT JOIN ms_expedisi c ON a.kode_expedisi=c.kode_expedisi
									ORDER BY a.kode_penjualan DESC";
						$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
						$nomor  = 0; 
						while ($data = mysql_fetch_array($dataQry)) {
						$nomor++;
						$Kode 		= $data['kode_penjualan'];
						$subtotal	= $data['total_penjualan']+$data['total_ongkir'];
					?>
                    <tr class="odd gradeX">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                                <span></span>
                            </label>
                        </td>
						<td><div align="center"><a href="?page=dtlpjl&amp;id=<?php echo $Kode; ?>"><?php echo $Kode; ?></a></div></td>
						<td><div align="center"><?php echo IndonesiaTgl($data ['tgl_penjualan']); ?></div></td>
						<td><?php echo $data ['nama_expedisi']; ?></td>
						<td><?php echo $data ['nama_customer']; ?></td>
                        <td><?php echo $data ['nama_user']; ?></td>
						<td><div align="right"><?php echo format_angka($data['total_penjualan']); ?></div></td>
						<td><div align="right"><?php echo format_angka($data['total_ongkir']); ?></div></td>
						<td><div align="right"><?php echo format_angka($subtotal); ?></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>
			</div>
		</div>
	</div>
</form>