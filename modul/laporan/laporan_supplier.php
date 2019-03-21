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
	            <span class="caption-subject uppercase bold">Laporan Supplier</span>
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
               	  	  	<th width="6%"><div align="center">KODE</div></th>
                      	<th width="22%"><div align="left">NAMA BARANG</div></th>
						<th width="36%" class="hidden-phone">ALAMAT</th>
						<th width="23%" class="hidden-phone">JENIS SUPPLIER</th>
		  	  	  	  	<th width="6%" class="hidden-phone"><div align="center">SUPPLIED</div></th>
		  	  	  	  	<th width="5%" class="hidden-phone"><div align="center">RETUR</div></th>
                    </tr>
				</thead>
				<tbody>
                    <?php
                    if(isset($_POST['btnTampil'])){
						$dataTanggal	= $_POST['txtTanggal'];
			
						$pecahData		= explode(" - ", $dataTanggal);
						
						$tglAwal		= InggrisTgl($pecahData[0]);
						$tglAkhir		= InggrisTgl($pecahData[1]);
															
						$dataSql = mysql_query("SELECT
												a.kode_supplier,
												a.nama_supplier,
												a.jenis_supplier,
												a.alamat_supplier,
												(SELECT SUM(jumlah_pembelian) FROM tr_pembelian_item a1
												INNER JOIN tr_pembelian b1 ON a1.kode_pembelian=b1.kode_pembelian
												WHERE b1.kode_supplier=a.kode_supplier
												AND date(b1.tgl_pembelian) BETWEEN '$tglAwal' AND '$tglAkhir'
												) AS total_beli,
												(SELECT SUM(jumlah_retur_beli) FROM tr_retur_beli_item a1
												INNER JOIN tr_retur_beli b1 ON a1.kode_retur_beli=b1.kode_retur_beli
												INNER JOIN tr_pembelian c1 ON b1.kode_pembelian=c1.kode_pembelian
												WHERE c1.kode_supplier=a.kode_supplier
												AND date(b1.tgl_retur_beli) BETWEEN '$tglAwal' AND '$tglAkhir'
												) AS total_retur_beli
												FROM ms_supplier a ");
					}
					$nomor  		= 0;
					$beli			= 0;
					$returbeli		= 0;
					while($dataRow	= mysql_fetch_array($dataSql)){
						$nomor ++;
						$beli		= $beli + $dataRow['total_beli'];
						$returbeli	= $returbeli + $dataRow['total_retur_beli'];
						
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $nomor;?></div></td>
						<td><div align="center"><?php echo $dataRow['kode_supplier']; ?></div></td>
						<td class="hidden-phone"><?php echo $dataRow['nama_supplier']; ?></td>
						<td><div align="left"><?php echo $dataRow['alamat_supplier']; ?></div></td>
						<td><div align="left"><?php echo $dataRow['jenis_supplier']; ?></div></td>
                        <td><div align="center"><?php echo format_angka($dataRow['total_beli']); ?></div></td>
                        <td><div align="center"><?php echo format_angka($dataRow['total_retur_beli']); ?></div></td>
                    </tr>
                    <?php } ?>
				</tbody>
				<tfoot>
                    <tr>
               	  	  	<th colspan="5"><div align="right">Subtotal : </div></th>
			  	  	  <th width="6%"><div align="center"><?php echo format_angka($beli); ?></div></th>
			  	  	  <th width="5%"><div align="center"><?php echo format_angka($returbeli); ?></div></th>
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
    win=window.open('./cetak/laporan_supplier.php?awal=<?php echo $tglAwal; ?>&akhir=<?php echo $tglAkhir ?>','win','width=1500, height=600, menubar=0, scrollbars=1, resizable=0, status=0'); 
    } 
</script>