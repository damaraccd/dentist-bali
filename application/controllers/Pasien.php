<?php

/**
 *
 */
class Pasien extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->model('M_pasien');
  }

  public function index()
  {
    $this->load->view('form_pasien.php');
  }

  public function riwayat_pasien()
  {
    $value = $_REQUEST['id'];
    $result['data'] = $this->M_pasien->get_riwayat_pasien($value);
    $this->load->view('form_pasien.php',$result);
  }
}


 ?>
