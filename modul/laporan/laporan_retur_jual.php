	<?php
		include_once "config/inc.connection.php";
		include_once "config/inc.library.php";
		
		$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y')." - ".date('d-m-Y');
		$pecahData		= explode(" - ", $dataTanggal);
						
		$tglAwal		= InggrisTgl($pecahData[0]);
		$tglAkhir		= InggrisTgl($pecahData[1]);
		
     ?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="fieldset-form">
	<div class="portlet">
	    <div class="portlet-title">
	        <div class="caption">
	            <span class="caption-subject uppercase bold">Laporan Retur Penjualan Barang</span>
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
                      <th width="3%"><div align="center">NO</div></th>
                        <th width="11%" class="hidden-phone"><div align="center">TGL. TRANSAKSI</div></th>
                        <th width="9%"><div align="center">NO. TRANSAKSI</div></th>
						<th width="14%" class="hidden-phone"><div align="center">NO. PENJUALAN</div></th>
						<th width="26%" class="hidden-phone">NAMA CUSTOMER</th>
						<th width="21%" class="hidden-phone">NAMA KASIR</th>
						<th width="16%" class="hidden-phone">KETERANGAN</th>
                    </tr>
				</thead>
				<tbody>
					<?php
                    if(isset($_POST['btnTampil'])){
						$dataTanggal	= $_POST['txtTanggal'];
			
						$pecahData		= explode(" - ", $dataTanggal);
						
						$tglAwal		= InggrisTgl($pecahData[0]);
						$tglAkhir		= InggrisTgl($pecahData[1]);
															
						$dataSql 		= mysql_query("SELECT
														a.tgl_retur_jual,
														a.kode_retur_jual,
														a.kode_penjualan,
														d.kode_customer,
														d.nama_customer,
														b.kode_user,
														b.nama_user,
														a.keterangan_retur_jual
														FROM tr_retur_jual a 
														INNER JOIN ms_user b ON a.kode_user=b.kode_user
														INNER JOIN tr_penjualan c ON a.kode_penjualan=a.kode_penjualan
														LEFT JOIN ms_customer d ON c.kode_customer=d.kode_customer
														WHERE date(a.tgl_retur_jual) BETWEEN '$tglAwal' AND '$tglAkhir' 
														GROUP BY a.kode_retur_jual
														ORDER BY a.tgl_retur_jual DESC");
					}
					$nomor  				= 0;
					while($dataRow			= mysql_fetch_array($dataSql)){	
						$nomor ++;
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $nomor;?></div></td>
						<td class="hidden-phone"><div align="center"><?php echo indonesiaTgl($dataRow ['tgl_retur_jual']); ?> </div>						</td>
						<td><div align="center"><?php echo $dataRow ['kode_retur_jual']; ?></div></td>
						<td><div align="center"><?php echo $dataRow ['kode_penjualan']; ?></div></td>
						<td class="hidden-phone"><?php echo $dataRow ['kode_customer']; ?> - <?php echo $dataRow ['nama_customer']; ?></td>
						<td class="hidden-phone"><?php echo $dataRow ['kode_user']; ?> - <?php echo $dataRow ['nama_user']; ?></td>
						<td class="hidden-phone"><?php echo $dataRow ['keterangan_retur_jual']; ?></td>
                    </tr>
                    <?php } ?>
				</tbody>
            </table>

	</div>
</div>
<script type="text/javascript"> 
    function cetak()	 
    { 
    win=window.open('./cetak/laporan_retur_jual.php?awal=<?php echo $tglAwal; ?>&akhir=<?php echo $tglAkhir ?>','win','width=1500, height=600, menubar=0, scrollbars=1, resizable=0, status=0'); 
    } 
</script>