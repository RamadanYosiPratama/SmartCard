<?php
/*****************************************************/
/* File        : Admin.php                           */
/* Lokasi File : ./application/controllers/Admin.php */
/* Copyright   : Yosef Murya & Badiyanto             */
/* Publish     : Penerbit Langit Inspirasi           */
/*---------------------------------------------------*/
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class Admin
class Admin extends CI_Controller {
	
	// Konstrutor 
	function __construct() {
		parent::__construct();
		$this->load->model('Users_model');
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	}
	
	// Fungsi untuk menampilkan halaman utama admin
	public function index() {
		// Menampilkan data berdasarkan id-nya yaitu username
		$row = $this->Users_model->get_by_id($this->session->userdata['username']);
		$data = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'Universitas Langit Inspirasi',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);
		
		$this->load->view('beranda',$data); // Menampilkan halaman utama admin
		
	}
	
	// Fungsi melakukan logout
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
/* Please DO NOT modify this information : */
?>