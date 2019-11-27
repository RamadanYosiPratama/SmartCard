<?php
/*******************************************************/
/* File        : kelas.php                           */
/* Lokasi File : ./application/controllers/kelas.php */
/* Copyright   : Yosef Murya & Badiyanto               */
/*-----------------------------------------------------*/
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Deklarasi pembuatan class 
class kelas extends CI_Controller
{
	// Konstrutor 
    function __construct()
    {
        parent::__construct();
        $this->load->model('kelas_model'); // Memanggil kelas_model yang terdapat pada models
		$this->load->model('Users_model'); // Memanggil Users_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library        
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman utama jurusan
    public function index()
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu username
		$row = $this->Users_model->get_by_id($this->session->userdata['username']);
		$data = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);		
		$this->load->view('header_list',$data); // Menampilkan bagian header dan object data users 
        $this->load->view('kelas/kelas_list'); // Menampilkan halaman utama kelas
		$this->load->view('footer_list'); // Menampilkan bagian footer		 
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->kelas_model->json(); // Menampilkan data json yang terdapat pada kelas_model
    }
	
	// Fungsi menampilkan form Create kelas
    public function create() 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		// Menampilkan data berdasarkan id-nya yaitu username
		$row = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);	
		
		// Menampung data yang diinputkan 
        $data = array(
            'button' => 'Create',
			'back'   => site_url('kelas'),
            'action' => site_url('kelas/create_action'),
			'id_kelas' => set_value('id_kelas'),
			'kode_kelas' => set_value('kode_kelas'),
			'nama_kelas' => set_value('nama_kelas'),
	);
		$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users 
        $this->load->view('kelas/kelas_form', $data); // Menampilkan form kelas
		$this->load->view('footer'); // Menampilkan bagian footer
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action() 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form kelas belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		// Jika form kelas telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
            $data = array(
				'id_kelas' => $this->input->post('kode_kelas',TRUE),
				'kode_kelas' => $this->input->post('kode_kelas',TRUE),
				'nama_kelas' => $this->input->post('nama_kelas',TRUE),
	    );

            $this->kelas_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kelas'));
        }
    }
    
	// Fungsi menampilkan form Update kelas
    public function update($id) 
    {	
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu username
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
				'wa'       => 'Web administrator',
				'univ'     => 'SmartCard Course',
				'username' => $rowAdm->username,
				'email'    => $rowAdm->email,
				'level'    => $rowAdm->level,
		);	
		
		// Menampilkan data berdasarkan id-nya yaitu kelas
        $row = $this->kelas_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data kelas ditampilkan ke form edit kelas
        if ($row) {
			
            $data = array(
                'button' => 'Update',
				'back'   => site_url('kelas'),
                'action' => site_url('kelas/update_action'),
				'id_kelas' => set_value('id_kelas', $row->id_kelas), 
				'kode_kelas' => set_value('kode_kelas', $row->kode_kelas),
				'nama_kelas' => set_value('nama_kelas', $row->nama_kelas),
	    );
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
            $this->load->view('kelas/kelas_form', $data); // Menampilkan form kelas 
			$this->load->view('footer'); // Menampilkan bagian footer
        } 
		// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas'));
        }
    }
    
	// Fungsi untuk melakukan aksi update data
    public function update_action() 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form kelas belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kelas', TRUE));
        } 
		// Jika form kelas telah diisi dengan benar 
		// maka sistem akan melakukan update data kelas kedalam database
		else {			
		    $data = array(
				'kode_kelas' => $this->input->post('kode_kelas',TRUE),
				'nama_kelas' => $this->input->post('nama_kelas',TRUE),
			);

            $this->kelas_model->update($this->input->post('id_kelas', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kelas'));
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id) 
    {
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $row = $this->kelas_model->get_by_id($id);
		
		//jika id kelas yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->kelas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kelas'));
        } 
		//jika id kelas yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() 
    {
	$this->form_validation->set_rules('kode_kelas', 'kode kelas', 'trim|required');
	$this->form_validation->set_rules('nama_kelas', 'nama kelas', 'trim|required');

	$this->form_validation->set_rules('id_kelas', 'id_kelas', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file kelas.php */
/* Location: ./application/controllers/kelas.php */
/* Please DO NOT modify this information : */
?>