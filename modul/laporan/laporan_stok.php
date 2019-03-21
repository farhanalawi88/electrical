<?php	
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
 ?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="fieldset-form">
	<div class="portlet">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Laporan Stok Barang & Produk</span>
	        </div>
	        <div class="tools">
				<a href="javascript:;" class="collapse"></a>
				<a href="javascript:;" class="reload"></a>
				<a href="javascript:;" class="remove"></a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-lg-4">	
					<div class="form-group">
						<label>Kategori Barang :</label>
						<div class="controls" style="margin-top: 6px">
							<select name="cmbKategori" class="form-control select2" data-placeholder="Pilih Kategori" tabindex="1">
							  <option value="%"> PILIH SEMUA</option>
							  <?php
								  $dataSql = "SELECT * FROM ms_kategori WHERE status_kategori='Active' ORDER BY kode_kategori";
								  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
								  while ($dataRow = mysql_fetch_array($dataQry)) {
									if ($dataKategori == $dataRow['kode_kategori']) {
										$cek = " selected";
									} else { $cek=""; }
									echo "<option value='$dataRow[kode_kategori]' $cek>$dataRow[kode_kategori] - $dataRow[nama_kategori]</option>";
								  }
								  $sqlData ="";
							  ?>
						  	</select>
						
						</div>
					</div>
				</div>
				<div class="col-lg-2">	
					<div class="form-group">
						<div class="controls" style="margin-top: 30px">
							<button type="submit" class="btn blue" name="btnTampil"><i class="icon-magnifier-add"></i> Tampilkan</button>
						</div>
					</div>
				</div>
				<div class="col-lg-6" align="right">
					<div class="form-group">
						<div class="controls" style="margin-top: 30px">
						<?php
	                    	if(isset($_POST['btnTampil'])){
	                    ?>
						 <button name="bar" type="button" onClick="cetak()" class="btn blue"><i class="icon-printer"></i> Cetak Laporan</button>
	                    <?php } ?>
						</div>
					</div>
				</div>
			</div>	
			<hr>
			<table class="table table-striped table-bordered table-hover " id="sample_4">
				<thead>
                    <tr>
               	  	  	<th width="2%"><div align="center">NO</div></th>
                        <th width="8%"><div align="center">KODE BARANG</div></th>
						<th width="19%" class="hidden-phone">KATEGORI</th>
                        <th width="33%"><div align="left">NAMA BARANG</div></th>
					  	<th width="7%" class="hidden-phone"><div align="right">HARGA BELI</div></th>
				  	  	<th width="10%" class="hidden-phone"><div align="right">HARGA JUAL</div></th>
                      	<th width="13%"><div align="center">STOK</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
                    if(isset($_POST['btnTampil'])){
						$dataKategori	= $_POST['cmbKategori'];
															
						$dataSql = mysql_query("SELECT * FROM ms_barang a
												LEFT JOIN ms_kategori b ON a.kode_kategori=b.kode_kategori 
												WHERE b.kode_kategori LIKE '$dataKategori'");
					}
					$nomor  		= 0;
					$hargaBeli		= 0;
					$hargaJual		= 0;
					$jumlahStok		= 0;
					while($dataRow	= mysql_fetch_array($dataSql)){
						$nomor ++;
						$hargaBeli	= $hargaBeli + $dataRow['harga_beli'];
						$hargaJual	= $hargaJual + $dataRow['harga_jual'];
						$jumlahStok	= $jumlahStok + $dataRow['stok_barang'];
						
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $nomor;?></div></td>
						<td><div align="center"><?php echo $dataRow['kode_barcode']; ?></div></td>
						<td class="hidden-phone"><?php echo $dataRow['kode_kategori']; ?> - <?php echo $dataRow['nama_kategori']; ?></td>
						<td><div align="left"><?php echo $dataRow['nama_barang']; ?></div></td>
						<td class="hidden-phone"><div align="right"><?php echo format_angka($dataRow['harga_jual']); ?></div></td>
					   	<td><div align="right"><?php echo format_angka($dataRow['harga_beli']); ?></div></td>
                        <td><div align="center"><?php echo format_angka($dataRow['stok_barang']); ?></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
				<tfoot>
                    <tr>
               	  	  	<th colspan="4"><div align="right">SUBTOTAL : </div></th>
					  	<th width="12%"><div align="right"><?php echo format_angka($hargaJual); ?></div></th>
						<th width="10%"><div align="right"><?php echo format_angka($hargaBeli); ?></div></th>
						<th width="8%"><div align="center"><?php echo format_angka($jumlahStok); ?></div></th>
                    </tr>
				</tfoot>
            </table>
	  </div>
  		</div>
	</div>
</div>
<script type="text/javascript"> 
    function cetak()	 
    { 
    win=window.open('./cetak/laporan_stok.php?kategori=<?php echo $dataKategori; ?>','win','width=1500, height=600, menubar=0, scrollbars=1, resizable=0, status=0'); 
    } 
</script>