<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class siswa extends CI_Controller
{
     // Konstruktor			
	function __construct()
    {
        parent::__construct();
        $this->load->model('siswa_model'); 
		$this->load->model('Users_model'); 
        $this->load->library('form_validation'); 
		$this->load->helper(array('form', 'url')); 
		$this->load->library('upload'); 
		$this->load->library('datatables');
    }
	
	
    public function index(){   
			
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
		
		$this->load->view('header_list', $dataAdm); 
        $this->load->view('siswa/siswa_list'); 
		$this->load->view('footer_list'); 
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->siswa_model->json();
    }
	
    public function read($id){
			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
	
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);
		
		
        $row = $this->siswa_model->get_by_id($id);
		
		
        if ($row) {
            $data = array(
				'button' => 'Read',
				'back'   => site_url('siswa'),
				'nis' => $row->nis,
				'nama_lengkap' => $row->nama_lengkap,
				'nama_panggilan' => $row->nama_panggilan,
				'alamat' => $row->alamat,
				'email' => $row->email,
				'telp' => $row->telp,
				'tempat_lahir' => $row->tempat_lahir,
				'tgl_lahir' => $row->tgl_lahir,
				'jenis_kelamin' => $row->jenis_kelamin,
				'agama' => $row->agama,
				'photo' => $row->photo,
				'id_kelas' => $row->id_kelas,
			);
            $this->load->view('header', $dataAdm); 
			$this->load->view('siswa/siswa_read', $data); 
			$this->load->view('footer'); 
        }
		
		else {
			$this->load->view('header', $dataAdm); // Menampilkan bagian header dan object data users
            $this->session->set_flashdata('message', 'Record Not Found');
			$this->load->view('footer'); // Menampilkan bagian footer
            redirect(site_url('siswa'));
        }
    }
	
	    public function create(){
					
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);
	  
	  // Menampung data yang diinputkan
      $data = array(
        'button' => 'Create',
		'back'   => site_url('siswa'),
        'action' => site_url('siswa/create_action'),
	    'nis' => set_value('nis'),
	    'nama_lengkap' => set_value('nama_lengkap'),
	    'nama_panggilan' => set_value('nama_panggilan'),
	    'alamat' => set_value('alamat'),
	    'email' => set_value('email'),
	    'telp' => set_value('telp'),
	    'tempat_lahir' => set_value('tempat_lahir'),
	    'tgl_lahir' => set_value('tgl_lahir'),
	    'jenis_kelamin' => set_value('jenis_kelamin'),
	    'agama' => set_value('agama'),
		'photo' => set_value('photo'),
	    'id_kelas' => set_value('id_kelas'),
	  );
        $this->load->view('header',$dataAdm );  	 
        $this->load->view('siswa/siswa_form', $data); 
		$this->load->view('footer'); 
    }
    
	
    public function create_action(){
		
				
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); 
		
		
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		
		else {	
		
			$config['upload_path']   = './images/';    
			$config['allowed_types'] = 'jpg|png|jpeg'; 		
			$config['file_name']     = url_title($this->input->post('nis'));
			$this->upload->initialize($config);
			
		
			if(!empty($_FILES['photo']['name'])){
				
				if ($this->upload->do_upload('photo')){
					$photo = $this->upload->data();	
					$dataphoto = $photo['file_name'];					
					$this->load->library('upload', $config);		    
					
					$data = array(
						'nis' => $this->input->post('nis',TRUE),
						'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
						'nama_panggilan' => $this->input->post('nama_panggilan',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'email' => $this->input->post('email',TRUE),
						'telp' => $this->input->post('telp',TRUE),
						'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
						'tgl_lahir' => $this->input->post('tgl_lahir',TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
						'agama' => $this->input->post('agama',TRUE),
						'photo' => $dataphoto, 
						'id_kelas' => $this->input->post('id_kelas',TRUE),
					); 
					
					$this->siswa_model->insert($data);
				}
				
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('siswa'));			
			}
			
			else{		
			
				$data = array(
					'nis' => $this->input->post('nis',TRUE),
					'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
					'nama_panggilan' => $this->input->post('nama_panggilan',TRUE),
					'alamat' => $this->input->post('alamat',TRUE),
					'email' => $this->input->post('email',TRUE),
					'telp' => $this->input->post('telp',TRUE),
					'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
					'tgl_lahir' => $this->input->post('tgl_lahir',TRUE),
					'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
					'agama' => $this->input->post('agama',TRUE),					
					'id_kelas' => $this->input->post('id_kelas',TRUE),
				);            
				
				$this->siswa_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('siswa'));	
			}
					
        }
    }
    

    public function update($id){
			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		
		$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		$dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);
		
		
        $row = $this->siswa_model->get_by_id($id);
		
		
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('siswa'),
                'action' => site_url('siswa/update_action'),
				'nis' => set_value('nis', $row->nis),
				'nama_lengkap' => set_value('nama_lengkap', $row->nama_lengkap),
				'nama_panggilan' => set_value('nama_panggilan', $row->nama_panggilan),
				'alamat' => set_value('alamat', $row->alamat),
				'email' => set_value('email', $row->email),
				'telp' => set_value('telp', $row->telp),
				'tempat_lahir' => set_value('tempat_lahir', $row->tempat_lahir),
				'tgl_lahir' => set_value('tgl_lahir', $row->tgl_lahir),
				'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
				'agama' => set_value('agama', $row->agama),
				'photo' => set_value('photo', $row->photo),
				'id_kelas' => set_value('id_kelas', $row->id_kelas),
			);
		    $this->load->view('header',$dataAdm); 
            $this->load->view('siswa/siswa_form', $data); 
			$this->load->view('footer'); 
        } 
		
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }

    public function update_action(){
		
				
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules(); 		
		
	
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('nis', TRUE));
        } 
	
		else{	
		
			$config['upload_path']   = './images/';    
			$config['allowed_types'] = 'jpg|png|jpeg'; 		
			$config['file_name']     = url_title($this->input->post('nis')); 
			

			if(!empty($_FILES['photo']['name'])){	
	
				unlink("./images/".$this->input->post('photo'));	
				
			
				if ($this->upload->do_upload('photo')){
					$photo = $this->upload->data();	
					$dataphoto = $photo['file_name'];					
					$this->load->library('upload', $config);
					
		
					$data = array(
						'nis' => $this->input->post('nis',TRUE),
						'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
						'nama_panggilan' => $this->input->post('nama_panggilan',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'email' => $this->input->post('email',TRUE),
						'telp' => $this->input->post('telp',TRUE),
						'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
						'tgl_lahir' => $this->input->post('tgl_lahir',TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
						'agama' => $this->input->post('agama',TRUE),
						'photo' => $dataphoto, 
						'id_kelas' => $this->input->post('id_kelas',TRUE),
					); 
					
					$this->siswa_model->update($this->input->post('nis', TRUE), $data);
				}
				
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('siswa'));			
			}
			
			else{		
				
				$data = array(
					'nis' => $this->input->post('nis',TRUE),
					'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
					'nama_panggilan' => $this->input->post('nama_panggilan',TRUE),
					'alamat' => $this->input->post('alamat',TRUE),
					'email' => $this->input->post('email',TRUE),
					'telp' => $this->input->post('telp',TRUE),
					'tempat_lahir' => $this->input->post('tempat_lahir',TRUE),
					'tgl_lahir' => $this->input->post('tgl_lahir',TRUE),
					'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
					'agama' => $this->input->post('agama',TRUE),					
					'id_kelas' => $this->input->post('id_kelas',TRUE),
				);            
				
				$this->siswa_model->update($this->input->post('nis', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('siswa'));	
			}
			
        }
    }
    public function delete($id){
			
					
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $row = $this->siswa_model->get_by_id($id);
		
		
        if ($row){
			
			unlink("../images/".$row->photo);
			
            $this->siswa_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('siswa'));
        } 
	
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }
	
	
    public function _rules() 
    {
	$this->form_validation->set_rules('nis', 'nis', 'trim|required');
	$this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'trim|required');
	$this->form_validation->set_rules('nama_panggilan', 'nama panggilan', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');
	$this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'trim|required');
	$this->form_validation->set_rules('tgl_lahir', 'tgl lahir', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('agama', 'agama', 'trim|required');
	$this->form_validation->set_rules('id_kelas', 'id kelas', 'trim|required');
	$this->form_validation->set_rules('nis', 'nis', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}