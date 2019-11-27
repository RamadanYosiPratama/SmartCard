<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class guru extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_model'); 
        $this->load->model('Users_model'); 
        $this->load->library('form_validation'); 
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload'); 
		$this->load->library('datatables'); 
    }
	
	
    public function index()
    {
				
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
		
		$this->load->view('header_list', $dataAdm);
        $this->load->view('guru/guru_list');
		$this->load->view('footer_list');
    } 
    
	// Fungsi JSON
    public function json() {
        header('Content-Type: application/json');
        echo $this->Guru_model->json();
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
		
		
        $row = $this->Guru_model->get_by_id($id);
        if ($row) {
            $data = array(
				'button' => 'Read',
				'back'   => site_url('guru'),
				'id_guru' => $row->id_guru,
				'niGn' => $row->niGn,
				'nama_guru' => $row->nama_guru,
				'alamat' => $row->alamat,
				'jenis_kelamin' => $row->jenis_kelamin,
				'email' => $row->email,
				'telp' => $row->telp,
				'photo' => $row->photo,
			);
			
			$this->load->view('header', $dataAdm); 
            $this->load->view('guru/guru_read', $data); 
			$this->load->view('footer');
        } else {
			$this->load->view('header', $dataAdm); 
            $this->session->set_flashdata('message', 'Record Not Found');
			$this->load->view('footer'); 
            redirect(site_url('guru'));
        }
    }

    public function create() 
    {
			
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
		
        $data = array(
            'button' => 'Create',
            'action' => site_url('guru/create_action'),
			'back'   => site_url('guru'),
			'id_guru' => set_value('id_guru'),
			'niGn' => set_value('niGn'),
			'nama_guru' => set_value('nama_guru'),
			'alamat' => set_value('alamat'),
			'jenis_kelamin' => set_value('jenis_kelamin'),
			'email' => set_value('email'),
			'telp' => set_value('telp'),
			'photo' => set_value('photo'),
		);
		
		$this->load->view('header',$dataAdm ); 
        $this->load->view('guru/guru_form', $data);
		$this->load->view('footer'); 
    }
    
    public function create_action() 
    {
				
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
		
        $this->_rules();
		
		
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } 
		else {
			
			$config['upload_path']   = './guru/';    
			$config['allowed_types'] = 'jpg|png|jpeg'; 	
			$config['file_name']     = url_title($this->input->post('niGn')); 
			$this->upload->initialize($config);
			
			if(!empty($_FILES['photo']['name'])){
				
				if ($this->upload->do_upload('photo')){
					$photo = $this->upload->data();	
					$dataphoto = $photo['file_name'];					
					$this->load->library('upload', $config);
					
					 $data = array(
						'niGn' => $this->input->post('niGn',TRUE),
						'nama_guru' => $this->input->post('nama_guru',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
						'email' => $this->input->post('email',TRUE),
						'telp' => $this->input->post('telp',TRUE),
						'photo' => $dataphoto,
					);
			
					$this->Guru_model->insert($data);
				
				}
				
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('guru'));
			}
			// Jika file photo kosong 
			else{
				
				$data = array(
						'niGn' => $this->input->post('niGn',TRUE),
						'nama_guru' => $this->input->post('nama_guru',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
						'email' => $this->input->post('email',TRUE),
						'telp' => $this->input->post('telp',TRUE),						
					);
			
				$this->Guru_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('guru'));
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
		
		
        $row = $this->Guru_model->get_by_id($id);
		
		
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('guru/update_action'),
				'back'   => site_url('guru'),
				'id_guru' => set_value('id_guru', $row->id_guru),
				'niGn' => set_value('niGn', $row->niGn),
				'nama_guru' => set_value('nama_guru', $row->nama_guru),
				'alamat' => set_value('alamat', $row->alamat),
				'jenis_kelamin' => set_value('jenis_kelamin', $row->jenis_kelamin),
				'email' => set_value('email', $row->email),
				'telp' => set_value('telp', $row->telp),
				'photo' => set_value('photo', $row->photo),
			);
			
			$this->load->view('header',$dataAdm ); 
            $this->load->view('guru/guru_form', $data); 
			$this->load->view('footer'); 
        } 
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('guru'));
        }
    }
    
    public function update_action(){
				
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $this->_rules(); 
		
	
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_guru', TRUE));
        } 
		
		else {
			
		
			$config['upload_path']   = './guru/';   
			$config['allowed_types'] = 'jpg|png|jpeg'; 		
			$config['file_name']     = url_title($this->input->post('niGn')); 
			$this->upload->initialize($config);
			
			
			if(!empty($_FILES['photo']['name'])){
				
				
				unlink("../images/guru/".$this->input->post('photo'));	
				
				
				
				if ($this->upload->do_upload('photo')){
					$photo = $this->upload->data();	
					$dataphoto = $photo['file_name'];					
					$this->load->library('upload', $config);
					
					$data = array(
						'id_guru' => $this->input->post('id_guru',TRUE),
						'niGn' => $this->input->post('niGn',TRUE),
						'nama_guru' => $this->input->post('nama_guru',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
						'email' => $this->input->post('email',TRUE),
						'telp' => $this->input->post('telp',TRUE),
						'photo' => $dataphoto,
						);
					
					$this->Guru_model->update($this->input->post('id_guru', TRUE), $data);
				}
				
				 $this->session->set_flashdata('message', 'Update Record Success');
				 redirect(site_url('guru'));
			}
			
			else{
				$data = array(
						'id_guru' => $this->input->post('id_guru',TRUE),
						'niGn' => $this->input->post('niGn',TRUE),
						'nama_guru' => $this->input->post('nama_guru',TRUE),
						'alamat' => $this->input->post('alamat',TRUE),
						'jenis_kelamin' => $this->input->post('jenis_kelamin',TRUE),
						'email' => $this->input->post('email',TRUE),
						'telp' => $this->input->post('telp',TRUE),						
						);           
				
				$this->Dosen_model->update($this->input->post('guru', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('guru'));
			}
        }
    }
    
    public function delete($id){
			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
        $row = $this->Guru_model->get_by_id($id);
		
		
        if ($row){
			
			
			unlink("./guru/".$row->photo);
			
            $this->Guru_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('guru'));
        } 
		
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('guru'));
        }
    }
	
	
    public function _rules() 
    {
	$this->form_validation->set_rules('niGn', 'niGn', 'trim|required');
	$this->form_validation->set_rules('nama_guru', 'nama guru', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('telp', 'telp', 'trim|required');	

	$this->form_validation->set_rules('id_guru', 'id_guru', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

