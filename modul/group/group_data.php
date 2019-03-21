<?php     
  if(isset($_POST['btnHapus'])){
    $txtID    = $_POST['txtID'];
    foreach ($txtID as $id_key) {
        
      $hapus=mysql_query("DELETE FROM sys_group WHERE group_id='$id_key'", $koneksidb) 
        or die ("Gagal kosongkan tmp".mysql_error());
        
      if($hapus){
        $_SESSION['info'] = 'success';
        $_SESSION['pesan'] = 'Data group berhasil dihapus';
        echo '<script>window.location="?page=dtgrp"</script>';
      } 
    }
  }
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="portlet box green">
    <div class="portlet-title">
      <div class="caption">
        <span class="caption-subject uppercase">Data Group & Level</span>
      </div>
      <div class="actions">
        <a href="?page=addgrp" class="btn green active"><i class="icon-plus"></i> ADD DATA</a> 
        <button class="btn green active" name="btnHapus" type="submit" onclick="return confirm('Anda yakin ingin menghapus data penting ini !!')"><i class="icon-trash"></i> DELETE DATA</button>
      </div>
    </div>
    <div class="portlet-body">      
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
          <thead>
            <tr>
              <th class="table-checkbox">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                    <span></span>
                </label>
            </th>
            <th width="30%">NAMA GROUP</th>
            <th width="60%">KETERANGAN</th>
            <th width="10%">LEVEL</th>
            <th width="10%"><div align="center">STATUS</div></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $dataSql = "SELECT * FROM sys_group ORDER BY group_id DESC";
            $dataQry = mysql_query($dataSql, $koneksidb)  or die ("Query supplier salah : ".mysql_error());
            $nomor  = 0; 
            while ($data = mysql_fetch_array($dataQry)) {
            $nomor++;
            $Kode = $data['group_id'];
          ?>
        <tr class="odd gradeX">
            <td>
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" value="<?php echo $Kode; ?>" name="txtID[<?php echo $Kode; ?>]" />
                    <span></span>
                </label>
            </td>
            <td><a href="?page=edtgrp&amp;id=<?php echo encrypt($Kode); ?>"><?php echo $data['group_nama']; ?></a></td>
            <td><?php echo $data ['group_keterangan']; ?></td>
            <td><?php echo $data ['group_level']; ?></td>
            <td>
              <div align="center">
                <?php 
                if($data ['group_status']=='Active'){
                  echo "<label class='label label-success'>Active</label>";
                }else{
                  echo "<label class='label label-danger'>Non Active</label>";
                }
                ?>            
              </div></td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</form>