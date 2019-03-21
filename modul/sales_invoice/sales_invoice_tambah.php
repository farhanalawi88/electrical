<?php
	
	if(isset($_POST['btnSave'])){	
		$message = array();
		if (trim($_POST['cmbSumber'])=="") {
			$message[] = "Informasi referensi belum diisi, silahkan pilih terlebih dahulu !";		
		}
		if (empty($_POST['txtPenjualan'])) {
			$message[] = "Maaf daftar penjualan belum ada yang dipilih, silahkan pilih terlebih dahulu !";		
		}
		
		$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
		$cmbSumber		= $_POST['cmbSumber'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtTotal 		= $_POST['txtTotal'];
		$txtTotal		= str_replace(",","",$txtTotal);
		$txtOngkir 		= $_POST['txtOngkir'];
				
		if(count($message)==0){			
			// PENOMORAN TRANSAKSI

			$bulan			= substr($txtTanggal,5,2);
			$romawi 		= getRomawi($bulan);
			$tahun			= substr($txtTanggal,2,2);
			$nomorTrans		= "/SI/".$romawi."/".$tahun;
			$queryTrans		= "SELECT max(kode_si) as maxKode FROM tr_si WHERE year(tgl_si)='$txtTanggal'";
			$hasilTrans		= mysql_query($queryTrans);
			$dataTrans		= mysql_fetch_array($hasilTrans);
			$noTrans		= $dataTrans['maxKode'];
			$noUrutTrans	= $noTrans + 1;
			$IDTrans		=  sprintf("%04s", $noUrutTrans);
			$kodeTrans		= $IDTrans.$nomorTrans;
			// INSERT TRANSAKSI
			$qrySaveTrans		= mysql_query("INSERT INTO tr_si SET kode_si='$kodeTrans', 
																		tgl_si='$txtTanggal', 
																		status_si='Open', 
																		kode_referensi='$cmbSumber',
																		keterangan_si='$txtKeterangan', 
																		kode_user='".$_SESSION['kode_user']."'") 
								  or die ("Gagal query".mysql_error());
			// INSERT BELI
			
			if($qrySaveTrans){
				foreach ($_POST['txtPenjualan'] as $key=>$val) {
					$txtPenjualan		= $_POST['txtPenjualan'][$key];
					$txtTagihan 		= $_POST['txtTagihan'][$key];
					$itemTransSql 		="SELECT * FROM tr_penjualan WHERE kode_penjualan='$txtPenjualan'";
					$itemTransQry 		= mysql_query($itemTransSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
					$itemTransRow 		= mysql_fetch_assoc($itemTransQry);
					$itemTransQty 		= mysql_num_rows($itemTransQry);
					if ($itemTransQty >= 1) {
						$beliSql = "INSERT INTO tr_si_item SET kode_si='$kodeTrans',
																no_tagihan_so='$txtTagihan',
																kode_penjualan='$itemTransRow[kode_penjualan]',
																kode_transaksi='$itemTransRow[kode_transaksi]',
																total_penjualan='$itemTransRow[total_penjualan]'";
						mysql_query($beliSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
							
					
					}

				}
				$_SESSION['info'] = 'success';	
				$_SESSION['pesan'] = 'Sales Invoice dengan nomor transaksi '.$kodeTrans.' berhasil dibuat';
				echo '<script>window.location="?page=dtlsi&id='.encrypt($kodeTrans).'"</script>';
			}
			else{
				$message[] = "Gagal penyimpanan ke database";
			}
		}	
	} 
	
	if (! count($message)==0 ){
		echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>";
			$Num=0;
			foreach ($message as $indeks=>$pesan_tampil) { 
			$Num++;
				echo "&nbsp;&nbsp;$Num. $pesan_tampil<br>";	
			} 
		echo "</div>"; 
	}


$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataSumber		= isset($_POST['cmbSumber']) ? $_POST['cmbSumber'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<SCRIPT language="JavaScript">
	function submitform() {
		document.form1.submit();
	}
</SCRIPT>		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Sales Invoice</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="fieldset-form" autocomplete="off" name="form1">
			<div class="form-body">
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">Tgl. Invoice :</label>
							<div class="input-icon left">
								<i class="icon-calendar"></i>
								<input class="form-control input-md date-picker" data-date-format="dd-mm-yyyy" type="text" name="txtTanggal" value="<?php echo $dataTanggal; ?>" readonly="readonly"/>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Referensi Dari :</label>
							<select class="form-control select2" data-placeholder="Pilih Referensi" name="cmbSumber" onChange="javascript:submitform();">
								<option value=""></option>
								<?php
								  $dataSql = "SELECT * FROM ms_referensi WHERE status_referensi='Active' ORDER BY kode_referensi ASC";
								  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
								  while ($dataRow = mysql_fetch_array($dataQry)) {
									if ($dataSumber == $dataRow['kode_referensi']) {
										$cek = " selected";
									} else { $cek=""; }
										echo "<option value='$dataRow[kode_referensi]' $cek>$dataRow[nama_referensi]</option>";
								  }
								  $sqlData ="";
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Dibuat Oleh :</label>
							<div class="input-icon left">
								<i class="icon-user"></i>
								<input class="form-control" type="text" value="<?php echo $userRow['nama_user']; ?>" disabled/>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Keterangan :</label>
							<div class="input-icon left">
								<i class="fa fa-edit"></i>
								<input class="form-control" type="text" value="<?php echo $dataKeterangan; ?>" name="txtKeterangan" onkeyup="javascript:this.value=this.value.toUpperCase();"/>
							</div>
						</div>
					</div>
				</div>
				<div class="batas"></div>
				<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
					<thead>
	                    <tr>
	       	  	  	  	  	<th class="table-checkbox" width="3%">
	                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
	                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
	                                <span></span>
	                            </label>
	                        </th>
	                      	<th width="10%"><div align="center">TGL. PENJUALAN</div></th>
	                        <th width="15%"><div align="center">NO. PENJUALAN </div></th>
	                        <th width="25%">NO. REFERENSI</th>
							<th width="15%">NAMA CUSTOMER</th>
							<th width="5%"><div align="right">ONGKIR</div></th>
							<th width="5%"><div align="right">TOTAL</div></th>
							<th width="5%"><div align="right">SUBTOTAL</div></th>
	                    </tr>
					</thead>
					<tbody>
	                    <?php
							
							$dataSql 		= "SELECT * FROM tr_transaksi a
												INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
												INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
												INNER JOIN ms_user d ON a.kode_user=d.kode_user
												INNER JOIN ms_referensi e ON c.kode_referensi=e.kode_referensi
												WHERE c.kode_referensi='$dataSumber' AND c.status_penjualan='Open'
												AND NOT c.kode_penjualan IN (SELECT kode_penjualan FROM tr_si_item)
												ORDER BY c.tgl_penjualan ASC";
							$dataQry 		= mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
							$nomor  		= 0; 
							$total 			= 0;
							$ongkir			= 0;
							$subtotal 		= 0;
							while ($data 	= mysql_fetch_array($dataQry)) {
							$nomor++;
							$Kode 			= $data['kode_penjualan'];
							$total 			= $total + $data['total_penjualan'];
							$ongkir			= $ongkir + $data['total_ongkir'];
							$subtotal		= $subtotal + ($data['total_penjualan']+$data['total_ongkir']);
						?>
	                    <tr>
	                        <td>
	                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
	                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtPenjualan[<?php echo $Kode; ?>]" />
	                                <span></span>
	                            </label>
	                        </td>
	                        </td>
							<td><div align="center"><?php echo IndonesiaTgl($data ['tgl_transaksi']); ?></div></td>
							<td <?php echo $dataStatus ?>><div align="center"><?php echo $data ['kode_penjualan']; ?></a></div></td>
							<td><?php echo $data ['no_referensi']; ?></td>
							<td><?php echo $data ['nama_customer']; ?></td>
							<td><div align="right"><?php echo number_format($data ['total_ongkir'],2); ?></div></td>
							<td><div align="right"><?php echo number_format($data ['total_penjualan'],2); ?></div></td>
							<td><div align="right"><?php echo number_format($data ['total_penjualan']+$data ['total_ongkir'],2); ?></div></td>
	                    </tr>
	                    <?php } ?>
					</tbody>
					<tfoot>
	                    <tr>
	                        <th colspan="5"><div align="right">GRAND TOTAL :</div> </th>
							<th><div align="right"><?php echo number_format($ongkir,2); ?></div></th>
							<th><div align="right"><?php echo number_format($total,2); ?></div></th>
							<th><div align="right"><?php echo number_format($subtotal,2); ?></div></th>
	                    </tr>
					</tfoot>
	            </table>
				<input class="form-control" type="hidden" name="txtTotal" value="<?php echo format_angka($total); ?>"/>
									
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn green" name="btnSave"><i class="fa fa-save"></i> Save Transaction</button>
						<a href="?page=dtsi" class="btn green"><i class="fa fa-undo"></i> Cancel Transaction</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

				
										
								