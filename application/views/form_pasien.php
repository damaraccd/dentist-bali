<!DOCTYPE html>

<html lang="id">

<head>

      <meta charset="utf-8">

      <title>Riwayat Pasien</title>

      <link href="<?php echo base_url().'assets/css/bootstrap.css'?>" rel="stylesheet">

			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <link href="<?php echo base_url().'assets/css/jquery.dataTables.min.css'?>" rel="stylesheet">

</head>

<body>



<div class="container">

      <h1>Riwayat <small>Pasien</small></h1>

			<?php
						foreach($data->result_array() as $i):
									$namapasien=$i['nama'];
									$alamat = $i['alamat'];
									$umur = $i['umur'];
									$jk = $i['jk'];

			 endforeach; ?>
			 <table class="table table-bordered" id="mydata">
			 			<thead>
			 						<tr>
			 									<th>Nama Pasien</th>
			 									<th>Alamat</th>
			 									<th>Umur</th>
			 									<th>Jenis Kelamin</th>
			 						</tr>
			 			</thead>
			 			<tbody>
			 						<tr>
			 									<td><?php echo $namapasien;?> </td>
			 									<td><?php echo $alamat;?> </td>
			 									<td><?php echo $umur; ?> </td>
			 									<td><?php echo $jk; ?> </td>
			 						</tr>
			 			</tbody>
			 </table>


      <table class="table table-bordered" id="mydata">
            <thead>
                  <tr>
                        <th>Tanggal</th>
                        <th>Diagnosa</th>
                        <th>Therapi</th>
                        <th>Harga</th>
                  </tr>
            </thead>
            <tbody>
                  <?php
                        foreach($data->result_array() as $i):
                              $tanggal=$i['tanggal'];
                              $diagnosa=$i['diagnosa'];
                              $therapi=$i['therapi'];
															$total = $i['total'];
                  ?>
                  <tr>
                        <td><?php echo $tanggal;?> </td>
                        <td><?php echo $diagnosa;?> </td>
                        <td><?php echo $therapi;?> </td>
                        <td><?php echo $total;?> </td>
                  </tr>
                  <?php endforeach;?>
            </tbody>
      </table>

</div>

<script src="<?php echo base_url().'assets/js/jquery-2.2.4.min.js'?>"> </script>

<script src="<?php echo base_url().'assets/js/bootstrap.js'?>"> </script>

<script src="<?php echo base_url().'assets/js/jquery.dataTables.min.js'?>"> </script>

<script src="<?php echo base_url().'assets/js/moment.js'?>"> </script>

<script>

      $(document).ready(function(){

            $('#mydata').DataTable();

      });

</script>

</body>

</html>
