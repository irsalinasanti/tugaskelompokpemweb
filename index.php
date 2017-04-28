<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="dist/semantic.min.css">
<link rel="icon" href="foto/home.ico" type="image/x-icon">
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous">

</script>
<script src="dist/semantic.min.js"></script>
  <!-- Standard Meta -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<!-- Site Properties -->
<title>MultiSheet Import</title>

<link rel="stylesheet" type="text/css" href="dist/components/reset.css">
<link rel="stylesheet" type="text/css" href="dist/components/site.css">

<link rel="stylesheet" type="text/css" href="dist/components/container.css">
<link rel="stylesheet" type="text/css" href="dist/components/grid.css">
<link rel="stylesheet" type="text/css" href="dist/components/header.css">
<link rel="stylesheet" type="text/css" href="dist/components/image.css">
<link rel="stylesheet" type="text/css" href="dist/components/menu.css">

<link rel="stylesheet" type="text/css" href="dist/components/divider.css">
<link rel="stylesheet" type="text/css" href="dist/components/list.css">
<link rel="stylesheet" type="text/css" href="dist/components/segment.css">
<link rel="stylesheet" type="text/css" href="dist/components/dropdown.css">
<link rel="stylesheet" type="text/css" href="dist/components/icon.css">

<script type="dist/semantic.min.js">$('.autumn.leaf').transition('fade');
</script>
</head>
<body style="background-color: #A0A0A0;font-family: 'Roboto'"><br><br><br><br><br><br><br><br>
<div class="ui container" style="margin-top: 15px">
  <div class="ui stackable menu" style="background-color: #0E6EB8">
    <a class="item" style="font-size: 18px;color: white">Index</a>
  </div>
  

  <center>
  <form name="myForm" id="myForm" onSubmit="return validateForm()" action="import.php" method="post" enctype="multipart/form-data">
    <center><h3><p style="color: white;font-family: 'Roboto'">Tugas Kelompok Upload 5 File</p></h3></center><br>
    <div class="ui inverted blue button">
      <form method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="">
    
    <input class="button" type="submit" value="Preview" />
    
</form>
      
            <?php           
            require "excel_reader.php";
            require "koneksi.php";
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            foreach ($_FILES['files']['name'] as $j => $name) {
                if (strlen($_FILES['files']['name'][$j]) > 1) {
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$j],$name)) {

                        chmod($_FILES['files']['name'][$j],0777);
                
                  $data = new Spreadsheet_Excel_Reader($_FILES['files']['name'][$j],$name,false);
                  echo $name;
                
            //    menghitung jumlah baris file xls
                  $baris = $data->rowcount($sheet_index=0);
                  $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
                   if($drop == 1){
            //             kosongkan tabel pegawai
                      $truncate ="TRUNCATE TABLE kelompok_mhs";
                       mysql_query($truncate);
                   };
                  echo "<table border = '1'>
        
          <tbody>";

          //    data Header
                $baris = $data->rowcount($sheet_index=0);
                for ($i=1; $i<2; $i++)
                {
            //       membaca data (kolom ke-1 sd terakhir)
                  $nim           = $data->val($i, 1,0);
                  $nama           = $data->val($i, 2,0);
                  $prov            = $data->val($i, 3,0);
                  $univ         = $data->val($i, 4,0);
                  $prodi     = $data->val($i, 5,0);
                  echo "<tr>
                <th>".$nim."</th>
                  <th>".$nama."</th>
                  <th>".$prov."</th>
                  <th>".$univ."</th>
                  <th>".$prodi."</th>
              </tr>";
              }
                
            //    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
                $baris = $data->rowcount($sheet_index=0);
                for ($i=2; $i<=$baris; $i++)
                {
            //       membaca data (kolom ke-1 sd terakhir)
                  $nim           = $data->val($i, 1,0);
                  $nama          = $data->val($i, 2,0);
                  $prov          = $data->val($i, 3,0);
                  $univ          = $data->val($i, 4,0);
                  $prodi       = $data->val($i, 5,0);
                  echo "<tr>
                <td>".$nim."</th>
                  <td>".$nama."</td>
                  <td>".$prov."</td>
                  <td>".$univ."</td>
                  <td>".$prodi."</td>
              </tr>";
                 $query = "INSERT into kelompok_mhs (
                        nim,
                        nama,
                        prov,
                        univ,
                        prodi)values('$nim','$nama','$prov','$univ','$prodi')";
                  $hasil = mysql_query($query);
            //      setelah data dibaca, masukkan ke tabel pegawai sql
                }
                
                
                
            //    hapus file xls yang udah dibaca
                
            
          echo "</tbody>
      </table>";
                    }
                }
            }    
                
    }
   ?>
    
    </center>
  </div>
  <div class="ui container segment align bottom" style="background-color: #0E6EB8;color: white">
    <center><p> Irsalina Santi Khasanah (15650008) </p></center>
    <center><p> Riko Putro Nugroho (15650038) </p></center>
    <center><p> Jazilatul Atiyah (15650055) </p></center>

  </div>
</form>

</body>
</html>