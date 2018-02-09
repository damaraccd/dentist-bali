<?php

/**
 *
 */
class M_pasien extends CI_Model
{
  public $title;
  public $content;
  public $date;

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->helper('form');
    $this->load->helper('url');
  }

  public function get_riwayat_pasien($value)
  {
    $query = $this->db->query("SELECT * FROM medis INNER JOIN pasien ON medis.idpasien = pasien.id WHERE pasien.id = '$value'");
    return $query;
  }
}


 ?>
