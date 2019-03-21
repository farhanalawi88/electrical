<?php
	
	if(isset($_POST['btnSave'])){	
		$message = array();
		if (trim($_POST['cmbSupplier'])=="") {
			$message[] = "Nama supplier belum diisi, silahkan pilih supplier terlebih dahulu !";		
		}
		if (empty($_POST['txtPembelian'])) {
			$message[] = "Maaf daftar pembelian belum ada yang dipilih, silahkan pilih terlebih dahulu !";		
		}
		
		$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
		$cmbSupplier	= $_POST['cmbSupplier'];
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtReferensi	= $_POST['txtReferensi'];
		$txtTotal 		= $_POST['txtTotal'];
		$txtTotal		= str_replace(",","",$txtTotal);
				
		if(count($message)==0){			
			// PENOMORAN TRANSAKSI
			$initSql 		="SELECT inisial_supplier FROM ms_supplier WHERE kode_supplier='$cmbSupplier'";
			$initQry 		= mysql_query($initSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$initRow 		= mysql_fetch_array($initQry);

			$bulan			= substr($txtTanggal,5,2);
			$romawi 		= getRomawi($bulan);
			$tahun			= substr($txtTanggal,2,2);
			$dataInit		= $initRow['inisial_supplier'];
			$nomorTrans		= "/PI/".$dataInit."/".$romawi."/".$tahun;
			$queryTrans		= "SELECT max(kode_pi) as maxKode FROM tr_pi WHERE year(tgl_pi)='$txtTanggal' and kode_supplier='$cmbSupplier'";
			$hasilTrans		= mysql_query($queryTrans);
			$dataTrans		= mysql_fetch_array($hasilTrans);
			$noTrans		= $dataTrans['maxKode'];
			$noUrutTrans	= $noTrans + 1;
			$IDTrans		=  sprintf("%04s", $noUrutTrans);
			$kodeTrans		= $IDTrans.$nomorTrans;
			// INSERT TRANSAKSI
			$qrySaveTrans		= mysql_query("INSERT INTO tr_pi SET kode_pi='$kodeTrans', 
																		tgl_pi='$txtTanggal', 
																		status_pi='Open', 
																		no_referensi='$txtReferensi',
																		kode_supplier='$cmbSupplier',
																		keterangan_pi='$txtKeterangan', 
																		kode_user='".$_SESSION['kode_user']."'") 
								  or die ("Gagal query".mysql_error());
			// INSERT BELI
			
			if($qrySaveTrans){
				foreach ($_POST['txtPembelian'] as $key=>$val) {
					$txtPembelian		= $_POST['txtPembelian'][$key];
					$txtTagihan 		= $_POST['txtTagihan'][$key];
					$itemTransSql 		="SELECT * FROM tr_pembelian WHERE kode_pembelian='$txtPembelian'";
					$itemTransQry 		= mysql_query($itemTransSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
					$itemTransRow 		= mysql_fetch_assoc($itemTransQry);
					$itemTransQty 		= mysql_num_rows($itemTransQry);
					if ($itemTransQty >= 1) {
						$beliSql = "INSERT INTO tr_pi_item SET kode_pi='$kodeTrans',
																no_tagihan_po='$txtTagihan',
																kode_pembelian='$itemTransRow[kode_pembelian]',
																kode_transaksi='$itemTransRow[kode_transaksi]',
																total_pembelian='$itemTransRow[total_pembelian]'";
						mysql_query($beliSql, $koneksidb) or die ("Gagal Query detail barang : ".mysql_error());
							
					
					}

					
				}
				$_SESSION['info'] = 'success';	
				$_SESSION['pesan'] = 'Transaksi order barang dengan nomor transaksi '.$kodeTrans.' berhasil dibuat';
				echo '<script>window.location="?page=dtlpi&id='.encrypt($kodeTrans).'"</script>';
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
$dataReferensi	= isset($_POST['txtReferensi']) ? $_POST['txtReferensi'] : '';
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>
<SCRIPT language="JavaScript">
	function submitform() {
		document.form1.submit();
	}
</SCRIPT>		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Form Purchase Invoice</span></div>
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
							<label>Nama Supplier :</label>
							<select class="form-control select2" data-placeholder="Pilih Supplier" name="cmbSupplier" onChange="javascript:submitform();">
								<option value=""></option>
								<?php
								  $dataSql = "SELECT * FROM ms_supplier WHERE status_supplier='Active' ORDER BY kode_supplier ASC";
								  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
								  while ($dataRow = mysql_fetch_array($dataQry)) {
									if ($dataSupplier == $dataRow['kode_supplier']) {
										$cek = " selected";
									} else { $cek=""; }
										echo "<option value='$dataRow[kode_supplier]' $cek>$dataRow[nama_supplier]</option>";
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
	                      	<th width="10%"><div align="center">NO. TAGIHAN</div></th>
	                      	<th width="10%"><div align="center">TGL. ORDER</div></th>
	                        <th width="15%"><div align="center">NO. ORDER </div></th>
							<th width="15%">REFERENSI DARI</th>
	                        <th width="25%">NO. REFERENSI</th>
							<th width="20%">NAMA CUSTOMER</th>
							<th width="15%"><div align="right">NOMINAL</div></th>
	                    </tr>
					</thead>
					<tbody>
	                    <?php
							
							$dataSql = "SELECT * FROM tr_transaksi a
										INNER JOIN tr_pembelian b ON b.kode_transaksi=a.kode_transaksi
										INNER JOIN tr_penjualan c ON c.kode_transaksi=a.kode_transaksi
										INNER JOIN ms_user d ON a.kode_user=d.kode_user
										INNER JOIN ms_referensi e ON c.kode_referensi=e.kode_referensi
										WHERE b.kode_supplier='$dataSupplier' AND b.status_pembelian='Open'
										AND NOT b.kode_pembelian IN (SELECT kode_pembelian FROM tr_pi_item)
										ORDER BY b.tgl_pembelian ASC";
							$dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
							$nomor  = 0; 
							$total 	= 0;
							while ($data = mysql_fetch_array($dataQry)) {
							$nomor++;
							$Kode 		= $data['kode_pembelian'];
							$total 		= $total + $data['total_pembelian'];
						?>
	                    <tr>
	                        <td>
	                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
	                                <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtPembelian[<?php echo $Kode; ?>]" />
	                                <span></span>
	                            </label>
	                        </td><td><div align="right"><input class="form-control input-sm" type="text" name="txtTagihan[<?php echo $Kode; ?>]" onkeyup="javascript:this.value=this.value.toUpperCase();"/></div></td>
							<td><div align="center"><?php echo IndonesiaTgl($data ['tgl_transaksi']); ?></div></td>
							<td <?php echo $dataStatus ?>><div align="center"><?php echo $data ['kode_pembelian']; ?></a></div></td>
							<td><?php echo $data ['nama_referensi']; ?></td>
							<td><?php echo $data ['no_referensi']; ?></td>
							<td><?php echo $data ['nama_customer']; ?></td>
							<td><div align="right"><?php echo number_format($data ['total_pembelian'],2); ?></div></td>
	                    </tr>
	                    <?php } ?>
					</tbody>
					<tfoot>
	                    <tr>
	                        <th colspan="7"><div align="right">GRAND TOTAL :</div> </th>
							<th width="15%"><div align="right"><?php echo number_format($total,2); ?></div></th>
	                    </tr>
					</tfoot>
	            </table>
				<input class="form-control" type="hidden" name="txtTotal" value="<?php echo number_format($total,2); ?>"/>
									
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn green" name="btnSave"><i class="fa fa-save"></i> Save Transaction</button>
						<a href="?page=dtpi" class="btn green"><i class="fa fa-undo"></i> Cancel Transaction</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

				
										
								