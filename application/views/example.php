<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<script type = 'text/javascript' src = "<?php echo base_url();
   ?>js/ubah_angka.js"></script>

<?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>
	<div>
		<a href='<?php echo site_url('examples/pasien')?>'>Pasien</a> |
		<a href='<?php echo site_url('examples/medis')?>'>Medis</a> |
		<a href='<?php echo site_url('examples/diagnosa')?>'>Diagnosa</a> |
		<a href='<?php echo site_url('examples/therapi')?>'>Therapi</a> |
		<a href='<?php echo site_url('examples/user')?>'>User</a> |
		<a href='<?php echo site_url('')?>'>Recycle Bin</a> |

		<a href='<?php echo site_url('examples/customers_management')?>'>Customers</a> |
		<a href='<?php echo site_url('examples/orders_management')?>'>Orders</a> |
		<a href='<?php echo site_url('examples/products_management')?>'>Products</a> |
		<a href='<?php echo site_url('examples/offices_management')?>'>Offices</a> |
		<a href='<?php echo site_url('examples/employees_management')?>'>Employees</a> |
		<a href='<?php echo site_url('examples/film_management')?>'>Films</a> |
		<a href='<?php echo site_url('examples/multigrids')?>'>Multigrid [BETA]</a>

	</div>
	<div style='height:20px;'></div>
    <div>
		<?php echo $output; ?>
    </div>

		<script type="text/javascript">

		// menghitung total harga
		// we used jQuery 'keyup' to trigger the computation as the user type
		$('.harga').keyup(function () {
			// initialize the sum (total harga) to zero
		    var sum = 0;
			// we use jQuery each() to loop through all the textbox with 'harga' class
			// and compute the sum for each loop
		    $('.harga').each(function() {
		        sum += Number($(this).val());
		    });
			// set the computed value to 'totalPrice' textbox
			$('#field-total').val(sum);
		});

		// menghitung kembalian
		$('#field-bayar').keyup(function(){
			var a = $('#field-total').val();
			b = $('#field-bayar').val();
			hasil = parseInt(b) - parseInt(a);
			$('#field-kembali').val(hasil);
		});

		// menghitung Umur
		$('#field-tgllahir').change(function(){
	    var str = $('#field-tgllahir').val();
	    var tahunlahir = str.substring(10, 6);
			var d = new Date();
			var tahunini = d.getFullYear();
			var umur = parseInt(tahunini) - parseInt(tahunlahir);
			$('#field-umur').val(umur);
	    // document.getElementById("demo").innerHTML = res;
		});
		</script>

</body>
</html>
