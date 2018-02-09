<?php

/**
 *
 */
class Admin extends CI_Controller
{

  public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('admin.php',(array)$output);
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

  public function pasien()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('pasien');
			$crud->columns('id','nama','tgllahir','alamat','telepon', 'umur', 'jk');
			$crud->display_as('nama','Nama Pasien')
				 ->display_as('id','ID Pasien')
				 ->display_as('alamat','Alamat')
				 ->display_as('jk','Jenis Kelamin')
				 ->display_as('telepon','Telepon');
			$crud->set_subject('Pasien');
			// $crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}




}


 ?>
