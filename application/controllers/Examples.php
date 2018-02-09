<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',(array)$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	// mycode

	// pasien code start
	public function pasien()
	{
			$crud = new grocery_CRUD();

			// $crud->set_theme('datatables');

			$crud->set_table('pasien');

			$crud->where('status','1');

			$crud->columns('id','nama','alamat','telepon', 'umur');
			$crud->add_fields('nama','tgllahir','alamat','telepon','umur','jk');
			$crud->edit_fields('nama','tgllahir','alamat','telepon', 'jk','status');

			$crud->add_action('Riwayat', '', '','ui-icon-plus',array($this,'getpasienid'));

			$crud->display_as('nama','Nama Pasien')
				 ->display_as('id','ID Pasien')
				 ->display_as('tgllahir','Tanggal Lahir')
				 ->display_as('jk','Jenis Kelamin')
				 ->display_as('telepon','Telepon');

			$crud->field_type('jk','enum',array('Laki - laki','Perempuan'));

			$crud->set_subject('Pasien');
			$crud->unset_delete();

			$crud->callback_add_field('umur', function() {
				return '<input type="text" id="umur" name="umur"class="umur" >';
			});

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function getpasienid($primary_key, $row)
	{
		return site_url('pasien/riwayat_pasien').'?id='.$row->id;
	}

	// pasien code end


// User code start here
	public function user()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('user');

			// $crud->set_theme('datatables');

			$crud->where('status','1');

			$crud->columns('iduser','fullname','email','nickname','level');
			$crud->add_fields('iduser','fullname','nickname','email');
			$crud->edit_fields('iduser','fullname','nickname','email');

			$crud->display_as('fullname','Nama User')
				 ->display_as('iduser','ID User');

				 $crud->set_subject('User');
				 $crud->unset_delete();
				 $crud->unset_export();
				 $crud->unset_print();


			// password hashing
			$crud->field_type('password', 'password');
			$crud->callback_before_insert(array($this,'encrypt_password_callback'));
			$crud->callback_before_update(array($this,'encrypt_password_callback'));
			$crud->callback_edit_field('password',array($this,'decrypt_password_callback'));
				// password hashing ends

			$output = $crud->render();

			$this->_example_output($output);
	}

	// code for password hashing
	function encrypt_password_callback($post_array, $primary_key = null)
	{
	$this->load->library('encrypt');

	$key = 'super-secret-key';
	$post_array['password'] = $this->encrypt->encode($post_array['password'], $key);
	return $post_array;
	}

	function decrypt_password_callback($value)
	{
	$this->load->library('encrypt');

	$key = 'super-secret-key';
	$decrypted_password = $this->encrypt->decode($value, $key);
	return "<input type='password' name='password' value='$decrypted_password' />";
	}
	// code for password hashing end



	// medis code start here
	public function medis()
	{
			$crud = new grocery_CRUD();

			// $crud->set_theme('datatables');

			$crud->set_table('medis');

			$crud->columns('noinvoice','iduser','idpasien','diagnosa','therapi','jasa', 'obat','total','bayar','kembali');
			$crud->fields('idinvoice','noinvoice','iduser','idpasien','diagnosa','therapi','jasa', 'obat','total','bayar','kembali');
			$crud->add_fields('noinvoice','iduser','idpasien','tanggal','diagnosa','therapi','jasa', 'obat','total','bayar','kembali');
			$crud->edit_fields('noinvoice','iduser','idpasien','tanggal','diagnosa','therapi','jasa', 'obat','total','bayar','kembali');

			$crud->set_relation('iduser','user','nickname');
			$crud->set_relation('idpasien','pasien','nama');
			$crud->set_relation_n_n('diagnosa', 'pasien_diagnosa', 'diagnosa', 'idinvoice', 'iddiagnosa', 'namadiagnosa','priority');
			// $crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');

			$crud->display_as('noinvoice','No Nota')
				 ->display_as('idpasien','Nama Pasien')
				 ->display_as('iduser','Admin');

			$crud->set_subject('Medis');
			$crud->unset_delete();

			// kode otomatis
			$crud->callback_add_field('noinvoice', function () {

				$this->db->select('Right(noinvoice,1) as kode',false);
				$this->db->order_by('noinvoice','DESC');
				$this->db->limit('1');
				$query = $this->db->get('medis');
				if ($query->num_rows() <> 0) {
					$data = $query->row();
					$kode = intval($data->kode)+1;
				}else {
					$kode = 1;
				}
				$kodemax = str_pad($kode,STR_PAD_LEFT);
				$kodejadi = "INVOICE"."-".$kodemax;

			return '<input type="text" maxlength="20" value="'. $kodejadi .'" name="noinvoice">';
			});
			// kode otomatis ends

			// kode pengurangan dan pertambahan total harga, bayar dan kembali
			$crud->callback_add_field('jasa', function() {
				return 'RP. <input type="text" id="field-jasa" name="jasa" class="harga" >';
			});

			$crud->callback_add_field('obat', function() {
				return 'RP. <input type="text" id="field-obat" name="obat" class="harga" >';
			});

			$crud->callback_add_field('total', function() {
				return 'RP. <input type="text" id="field-total" name="total" readonly>';
			});

			$crud->callback_add_field('bayar', function() {
				return 'RP. <input type="text" id="field-bayar" name="bayar">';
			});

			$crud->callback_add_field('kembali', function() {
				return 'RP. <input type="text" id="field-kembali" name="kembali" readonly>';
			});
			// kode pengurangan dan pertambahan total harga, bayar dan kembali ends

			$output = $crud->render();

			$this->_example_output($output);
	}

	// medis code end here





	public function diagnosa()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('diagnosa');
			$crud->columns('iddiagnosa','namadiagnosa','edited_at');
			$crud->add_fields('namadiagnosa');
			$crud->display_as('iddiagnosa','No')
				 ->display_as('namadiagnosa','Nama Diagnosa')
				 ->display_as('edited_at','Terakhir update pada :');
			$crud->set_subject('Diagnosa');
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function therapi()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('therapi');
			$crud->columns('idtherapi','namatherapi','edited_at');
			$crud->add_fields('namatherapi');
			$crud->display_as('idtherapi','No')
				 ->display_as('namatherapi','Nama Therapi')
				 ->display_as('edited_at','Terakhir update pada :');
			$crud->set_subject('Therapi');
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	// end of mycode

	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');

			$crud->required_fields('lastName');

			$crud->set_field_upload('file_url','assets/uploads/files');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}



}
