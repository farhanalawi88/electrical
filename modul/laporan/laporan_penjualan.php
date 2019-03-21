<?php
	
	$dataTglAwal	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : date('d-m-Y');
	$dataTglAkhir	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');
	$cmbAct			= isset($_POST['cmbAct']) ? $_POST['cmbAct'] : '';	
	$cmbStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';	
?>	
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><span class="caption-subject uppercase">Laporan Penjualan Barang</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<form action="./export/laporan_penjualan.php" method="post" name="form1" class="form-horizontal form-bordered" target="_BLANK">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label">Periode Penjualan :</label>
					<div class="col-md-3">
                        <div class="input-group">
                            <input type="text" class="form-control date-picker" name="txtTglAwal" data-date-format="dd-mm-yyyy" value="<?php echo $dataTglAwal ?>">
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control date-picker" name="txtTglAkhir" data-date-format="dd-mm-yyyy" value="<?php echo $dataTglAkhir ?>"> 
                        </div>
                    </div>
                </div>
                <div class="form-group last">
					<label class="col-md-2 control-label">Status Penjualan :</label>
					<div class="col-md-2">
						<select name="cmbStatus" class="select2 form-control" data-placeholder="Pilih Status">
							<option value="%">PILIH SEMUA</option>
							<?php
								$arrStatus	= array("Close","Open","Cancel");
							  	foreach ($arrStatus as $index => $value) {
								if ($value==$dataStatus) {
									$cek="selected";
								} else { $cek = ""; }
								echo "<option value='$value' $cek>$value</option>";
							  	}
							?>
						</select>
					</div>
				</div>		
				<div class="form-group last">
					<label class="col-md-2 control-label">Outout Type :</label>
					<div class="col-md-2">
						<select name="cmbAct" class="select2 form-control">
							<?php
								$arrAct	= array("EXCEL","PDF");
							  	foreach ($arrAct as $index => $value) {
								if ($value==$dataAct) {
									$cek="selected";
								} else { $cek = ""; }
								echo "<option value='$value' $cek>$value</option>";
							  	}
							?>
						</select>
					</div>
				</div>		
			</div>
			<div class="form-actions">
		        <div class="form-group">
		            <div class="col-md-offset-2 col-md-10">
		                <button type="submit" class="btn green">EXPORT REPORT</button>
		            </div>
		        </div>
			</div>
		</form>
	</div>
</div>