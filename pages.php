
<?php
	$pg=$_GET['page'];
		if($pg=="home"){ include"modul/home.php"; }
	// DATA KONFIGURASI
		elseif($pg=="confstore"){ include"modul/konfigurasi/conf_toko.php"; }
		elseif($pg=="confprofile"){ include"modul/konfigurasi/conf_profil.php"; }
		elseif($pg=="confpassword"){ include"modul/konfigurasi/conf_password.php"; }
		elseif($pg=="confbackup"){ include"modul/konfigurasi/conf_backup.php"; }
	// DATA USER
		elseif($pg=="dtusr"){ include"modul/user/user_data.php"; }
		elseif($pg=="addusr"){ include"modul/user/user_tambah.php"; }
		elseif($pg=="edtusr"){ include"modul/user/user_ubah.php"; }
	// DATA GROUP
		elseif($pg=="dtgrp"){ include"modul/group/group_data.php"; }
		elseif($pg=="addgrp"){ include"modul/group/group_tambah.php"; }
		elseif($pg=="edtgrp"){ include"modul/group/group_ubah.php"; }
	// DATA DATA SATUAN
		elseif($pg=="dtstn"){ include"modul/satuan/satuan_data.php"; }
		elseif($pg=="addstn"){ include"modul/satuan/satuan_tambah.php"; }
		elseif($pg=="edtstn"){ include"modul/satuan/satuan_ubah.php"; }
	// DATA HARGA
		elseif($pg=="dthrg"){ include"modul/harga/harga_data.php"; }
		elseif($pg=="dtlhrg"){ include"modul/harga/harga_detail.php"; }
		elseif($pg=="addhrg"){ include"modul/harga/harga_tambah.php"; }
		elseif($pg=="imprthrg"){ include"modul/harga/harga_import.php"; }
	// DATA MERK
		elseif($pg=="dtmrk"){ include"modul/merk/merk_data.php"; }
		elseif($pg=="addmrk"){ include"modul/merk/merk_tambah.php"; }
		elseif($pg=="edtmrk"){ include"modul/merk/merk_ubah.php"; }
	// DATA KATERGORI
		elseif($pg=="dtktgr"){ include"modul/kategori/kategori_data.php"; }
		elseif($pg=="addktgr"){ include"modul/kategori/kategori_tambah.php"; }
		elseif($pg=="edtktgr"){ include"modul/kategori/kategori_ubah.php"; }
	// DATA EXPEDISI
		elseif($pg=="dtexpds"){ include"modul/expedisi/expedisi_data.php"; }
		elseif($pg=="addexpds"){ include"modul/expedisi/expedisi_tambah.php"; }
		elseif($pg=="edtexpds"){ include"modul/expedisi/expedisi_ubah.php"; }
	// DATA DATA MODUL
		elseif($pg=="dtmdl"){ include"modul/modul/modul_data.php"; }
		elseif($pg=="addmdl"){ include"modul/modul/modul_tambah.php"; }
		elseif($pg=="edtmdl"){ include"modul/modul/modul_ubah.php"; }
	// DATA SUPPLIER
		elseif($pg=="dtsupp"){ include"modul/supplier/supplier_data.php"; }
		elseif($pg=="addsupp"){ include"modul/supplier/supplier_tambah.php"; }
		elseif($pg=="edtsupp"){ include"modul/supplier/supplier_ubah.php"; }
	// DATA REFERENSI
		elseif($pg=="dtreff"){ include"modul/referensi/referensi_data.php"; }
		elseif($pg=="addreff"){ include"modul/referensi/referensi_tambah.php"; }
		elseif($pg=="edtreff"){ include"modul/referensi/referensi_ubah.php"; }
	// DATA BARANG
		elseif($pg=="dtitm"){ include"modul/barang/barang_data.php"; }
		elseif($pg=="additm"){ include"modul/barang/barang_tambah.php"; }
		elseif($pg=="edtitm"){ include"modul/barang/barang_ubah.php"; }
		elseif($pg=="brcditm"){ include"modul/barang/barang_barcode.php"; }
	// DATA TRANSAKSI
		elseif($pg=="addtrx"){ include"modul/tr_transaksi/tr_transaksi_tambah.php"; }
		elseif($pg=="dttrx"){ include"modul/tr_transaksi/tr_transaksi_data.php"; }
		elseif($pg=="dtltrx"){ include"modul/tr_transaksi/tr_transaksi_detail.php"; }
	// DATA INVOICE PEMBELIAN
		elseif($pg=="addpi"){ include"modul/purchase_invoice/purchase_invoice_tambah.php"; }
		elseif($pg=="dtpi"){ include"modul/purchase_invoice/purchase_invoice_data.php"; }
		elseif($pg=="dtlpi"){ include"modul/purchase_invoice/purchase_invoice_detail.php"; }
	// DATA RETUR JUAL
		elseif($pg=="addrtrpjl"){ include"modul/retur_jual/retur_jual_tambah.php"; }
		elseif($pg=="dtrtrpjl"){ include"modul/retur_jual/retur_jual_data.php"; }
		elseif($pg=="dtlrtrpjl"){ include"modul/retur_jual/retur_jual_detail.php"; }
	// DATA RETUR BELI
		elseif($pg=="addsi"){ include"modul/sales_invoice/sales_invoice_tambah.php"; }
		elseif($pg=="dtsi"){ include"modul/sales_invoice/sales_invoice_data.php"; }
		elseif($pg=="dtlsi"){ include"modul/sales_invoice/sales_invoice_detail.php"; }
	// LAPORAN
		elseif($pg=="rptpjl"){ include"modul/laporan/laporan_penjualan.php"; }
		elseif($pg=="rptodr"){ include"modul/laporan/laporan_pembelian.php"; }
		elseif($pg=="rptbrg"){ include"modul/laporan/laporan_barang.php"; }
		elseif($pg=="rptlabarugi"){ include"modul/laporan/laporan_laba_rugi.php"; }
		elseif($pg=="rpthrgbrg"){ include"modul/laporan/laporan_harga_barang.php"; }
		elseif($pg=="rptfakturbeli"){ include"modul/laporan/laporan_faktur_pembelian.php"; }
		else {
		echo "<div class='col-md-12'><div class='alert alert-dismissable alert-warning'><i class='icon-exclamation-sign'></i> Belum Ada Modul</div></div>";
		}
?>
		
		