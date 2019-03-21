<?php 
$dataTanggal	= date('Y');

$userSql = "SELECT * FROM ms_user WHERE kode_user='".$_SESSION['kode_user']."'";
$userQry = mysql_query($userSql, $koneksidb)  or die ("Query penjualan salah : ".mysql_error());
$userRow = mysql_fetch_array($userQry);
?>



<div class="row">
	<div class="col-sm-6">
		<div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption"><span class="caption-subject uppercase">Grafik Barang Terjual</span></div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
			<div class="portlet-body">
				<div id='container_1'></div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption"><span class="caption-subject uppercase">Grafik Transaksi Penjualan</span></div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
			<div class="portlet-body">
				<div id='container_2'></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption"><span class="caption-subject uppercase">Grafik Penjualan & Pembelian</span></div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div id='container_3'></div>
            </div>
        </div>
    </div>
</div>

<script src="assets/scripts/highcharts.js"></script>
<script src="assets/scripts/modules/data.js"></script>
<script src="assets/scripts/highcharts-3d.js"></script>
<script src="assets/scripts/modules/drilldown.js"></script>
<script src="assets/scripts/modules/exporting.js"></script>
<script type="text/javascript">

Highcharts.chart('container_2', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Total Transaksi Penjualan',
        style: {
            fontSize: '14px',
            fontFamily: 'Abel'
        }
    },
    subtitle: {
        text: 'Tahun <?php echo date('Y') ?>',
        style: {
            fontSize: '14px',
            fontFamily: 'Abel'
        }
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Transaksi'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Transaksi in <?php echo date('Y') ?>: <b>{point.y:.1f} Quantity</b>'
    },
    series: [{
        name: 'Penjualan',


        data: [
            <?php 
                $dataTahun      = date('Y');
                $pilihan        = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                foreach ($pilihan as $nilai) {
                $tahunSql       = "SELECT
                                        IFNULL(SUM(a.jumlah_penjualan),0) AS total_penjualan 
                                    FROM
                                        tr_penjualan_item a
                                        INNER JOIN tr_penjualan b ON a.kode_penjualan=b.kode_penjualan
                                    WHERE
                                        YEAR (b.tgl_penjualan) = '$dataTahun' 
                                        AND MONTH (b.tgl_penjualan) = '$nilai'";        
                $tahunQry       = mysql_query($tahunSql, $koneksidb) or die(mysql_error());
                while( $dataRow = mysql_fetch_assoc($tahunQry)){
                   $jml_pegawai = $dataRow['total_penjualan'];                 
                }             
            ?>
                  
               ['<?php echo $nilai; ?>', <?php echo $jml_pegawai ?>],
            
            <?php } ?>
        ],
        dataLabels: {
            enabled: true,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Abel'
            }
        }
    }]
});
</script>
<script type="text/javascript">

    Highcharts.chart('container_1', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Grafik Total Penjualan',
            style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
        },
        subtitle: {
            text: 'Setiap Brand/Merk',
            style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total Transaksi',
            data: [

                <?php
                    $tmp2Sql ="SELECT
                                        a.nama_merk,
                                        (SELECT IFNULL(SUM(c.jumlah_penjualan),0) FROM ms_barang b
                                INNER JOIN tr_penjualan_item c ON c.kode_barang=b.kode_barang
                                INNER JOIN tr_penjualan d ON c.kode_penjualan=d.kode_penjualan
                                WHERE b.kode_merk=a.kode_merk) as total_masuk
                                FROM
                                        ms_merk a";
                    $tmp2Qry = mysql_query($tmp2Sql, $koneksidb) or die ("Gagal Query Tmp".mysql_error()); 
                    while($tmp2Row = mysql_fetch_assoc($tmp2Qry)) {    
                ?>
                    ['<?php echo $tmp2Row['nama_merk'] ?>',<?php echo $tmp2Row['total_masuk'] ?>],
               
                <?php } ?>
                
            ]
        }]
    });
</script>
<script type="text/javascript">

    Highcharts.chart('container_3', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Transaksi Penjualan & Pembelian',
        style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
    },
    subtitle: {
        text: 'Tahun <?php echo date('Y') ?>',
        style: {
                fontSize: '14px',
                fontFamily: 'Abel'
            }
    },
    xAxis: {
        categories: [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'May',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ],
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        }
    },
    yAxis: {
        title: {
            text: 'Total Transaksi',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: true
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Penjualan',
        data: [<?php 
                $dataTahun      = date('Y');
                $pilihan        = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                foreach ($pilihan as $nilai) {
                $tahunSql       = "SELECT
                                    IFNULL(SUM(b.total_penjualan),0) AS total_penjualan 
                                    FROM
                                    tr_si a
                                    INNER JOIN tr_si_item b ON a.kode_si = b.kode_si
                                    WHERE  YEAR (a.tgl_si) = '$dataTahun' 
                                        AND MONTH (a.tgl_si) = '$nilai'
                                        AND status_si='Close'";        
                $tahunQry       = mysql_query($tahunSql, $koneksidb) or die(mysql_error());
                while( $dataRow = mysql_fetch_assoc($tahunQry)){
                   $jml_pegawai = $dataRow['total_penjualan'];                 
                }             
            ?>
                  
               <?php echo $jml_pegawai ?>,
            
            <?php } ?>]
        

    }, {
        name: 'Pembelian',
        data: [<?php 
                $dataTahun      = date('Y');
                $pilihan        = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                foreach ($pilihan as $nilai) {
                $tahunSql       = "SELECT
                                    IFNULL(SUM(b.total_pembelian),0) AS total_pembelian 
                                    FROM
                                    tr_pi a
                                    INNER JOIN tr_pi_item b ON a.kode_pi = b.kode_pi
                                    WHERE  YEAR (a.tgl_pi) = '$dataTahun' 
                                        AND MONTH (a.tgl_pi) = '$nilai'
                                        AND a.status_pi='Close'";        
                $tahunQry       = mysql_query($tahunSql, $koneksidb) or die(mysql_error());
                while( $dataRow = mysql_fetch_assoc($tahunQry)){
                   $jml_pegawai = $dataRow['total_pembelian'];                 
                }             
            ?>
                  
               <?php echo $jml_pegawai ?>,
            
            <?php } ?>]

    }],
    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }
});
</script>