
	<?php
		
		$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y')." - ".date('d-m-Y');
		$pecahData		= explode(" s/d ", $dataTanggal);
						
		$tglAwal		= InggrisTgl($pecahData[0]);
		$tglAkhir		= InggrisTgl($pecahData[1]);
		
     ?>
 <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="fieldset-form">
	<div class="portlet">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Laporan Detail Retur Pembelian Barang</span>
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
						<label>Periode Transaksi :</label>
						<div class="controls" style="margin-top: 6px">
							<div id="defaultrange_modal" >
                                <input type="text" class="form-control" placeholder="Masukkan Periode Tanggal" name="txtTanggal" value="<?php echo $dataTanggal; ?>">
                            </div>
						
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
                        <th width="10%"><div align="center">TGL. TRANSAKSI</div></th>
                        <th width="10%"><div align="center">NO. TRANSAKSI</div></th>
						<th width="12%"><div align="center">KODE BARANG</div></th>
						<th width="40%">NAMA BARANG</th>
					  	<th width="10%"><div align="right">HARGA</div></th>
						<th width="8%"><div align="center">JUMLAH</div></th>
						<th width="8%"><div align="right">SUBTOTAL</div></th>
                    </tr>
				</thead>
				<tbody>
					<?php
                    if(isset($_POST['btnTampil'])){
						$dataTanggal	= $_POST['txtTanggal'];
			
						$pecahData		= explode(" - ", $dataTanggal);
						
						$tglAwal		= InggrisTgl($pecahData[0]);
						$tglAkhir		= InggrisTgl($pecahData[1]);
															
						$dataSql 		= mysql_query("SELECT * FROM tr_retur_beli_item a 
														INNER JOIN tr_retur_beli b ON a.kode_retur_beli=b.kode_retur_beli
														INNER JOIN ms_barang c ON a.kode_barang=c.kode_barang
														WHERE date(b.tgl_retur_beli) BETWEEN '$tglAwal' AND '$tglAkhir' 
														ORDER BY b.tgl_retur_beli DESC");
					}
					$nomor  		= 0;
					$subtotal 		= 0;
					$total			= 0;
					$harga			= 0;
					$jumlah			= 0;
					while($dataRow	= mysql_fetch_array($dataSql)){	
						$nomor ++;
						$total		= intval($dataRow ['jumlah_retur_beli']*$dataRow['harga_retur_beli']);
						$subtotal 	= $subtotal + $total;
						$jumlah 	= $jumlah + $dataRow ['jumlah_retur_beli'];
						$harga	 	= $harga + $dataRow ['harga_retur_beli'];
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $nomor;?></div></td>
						<td><div align="center"><?php echo indonesiaTgl($dataRow ['tgl_retur_beli']); ?> </div></td>
						<td><div align="center"><?php echo $dataRow ['kode_retur_beli']; ?></div></td>
						<td><div align="center"><?php echo $dataRow ['kode_barcode']; ?></div></td>
						<td><?php echo $dataRow ['nama_barang']; ?></td>
						<td><div align="right"><?php echo format_angka($dataRow ['harga_retur_beli']); ?></div></td>
						<td><div align="center"><?php echo format_angka($dataRow ['jumlah_retur_beli']); ?></div></td>
						<td><div align="right"><?php echo format_angka($total); ?></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
				<thead>
                    <tr>
                        <th colspan="5"><div align="right">GRAND TOTAL : </div></th>
						<th width="10%"><div align="right"><?php echo format_angka($harga) ?></div></th>
						<th width="8%"><div align="center"><?php echo format_angka($jumlah) ?></div></th>
						<th width="8%"><div align="right"><?php echo format_angka($subtotal) ?></div></th>
                    </tr>
				</thead>
            </table>
	 
	</div>
</div>
<script type="text/javascript"> 
    function cetak()	 
    { 
    win=window.open('./cetak/laporan_detail_retur_beli.php?awal=<?php echo $tglAwal; ?>&akhir=<?php echo $tglAkhir ?>','win','width=1500, height=600, menubar=0, scrollbars=1, resizable=0, status=0'); 
    } 
</script>