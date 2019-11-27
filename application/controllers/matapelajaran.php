 <?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class matapelajaran extends CI_Controller
{
    // Konstruktor	 
	function __construct()
    {
        parent::__construct();
        $this->load->model('Matapelajaran_model');
		$this->load->model('Users_model'); 
        $this->load->library('form_validation'); 
		$this->load->library('datatables');
    }
	
    public function index(){	

		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		$row = $this->Users_model->get_by_id($this->session->userdata['username']); 
		$data = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $row->username,
			'email'    => $row->email,
			'level'    => $row->level,
		);		
		$this->load->view('header_list',$data); 
        $this->load->view('matapelajaran/matapelajaran_list'); 
		$this->load->view('footer_list'); 
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Matapelajaran_model->json();
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
		
		$sql   = "SELECT * FROM kelas, matapelajaran 
		          WHERE kelas.id_kelas = matapelajaran.id_kelas
				  AND matapelajaran.kode_matapelajaran = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		
        if ($row) {
			
            $data = array(
			'button' => 'Read',
			'back'   => site_url('matapelajaran'),
			'kode_matapelajaran' => $row->kode_matapelajaran,
			'nama_matapelajaran' => $row->nama_matapelajaran,
			'lama_belajar' => $row->lama_belajar,
			'nama_kelas' => $row->nama_kelas,
			);
			
			$this->load->view('header',$dataAdm);
            $this->load->view('matapelajaran/matapelajaran_read', $data);
			$this->load->view('footer');
        } 
		
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matapelajaran'));
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
		

        $data = array(
            'button' => 'Create',
			'back'   => site_url('matapelajaran'),
            'action' => site_url('matapelajaran/create_action'),
			'kode_matapelajaran' => set_value('kode_matapelajaran'),
			'nama_matapelajaran' => set_value('nama_matapelajaran'),
			'lama_belajar' => set_value('lama_belajar'),
			'id_kelas' => set_value('id_kelas'),
		);
		$this->load->view('header',$dataAdm);	
        $this->load->view('matapelajaran/matapelajaran_form', $data); 
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
            $data = array(
			'kode_matapelajaran' => $this->input->post('kode_matapelajaran',TRUE),
			'nama_matapelajaran' => $this->input->post('nama_matapelajaran',TRUE),
			'lama_belajar' => $this->input->post('lama_belajar',TRUE),
			'id_kelas' => $this->input->post('id_kelas',TRUE),
			);
           
            $this->Matapelajaran_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('matapelajaran'));
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
		
		
        $row = $this->Matapelajaran_model->get_by_id($id);
		
		
        if ($row) {
            $data = array(
                'button' => 'Update',
				'back'   => site_url('matapelajaran'),
                'action' => site_url('matapelajaran/update_action'),
				'kode_matapelajaran' => set_value('kode_pelajaran', $row->kode_matapelajaran),
				'nama_matapelajaran' => set_value('nama_matapelajaran', $row->nama_matapelajaran),
				'lama_belajar' => set_value('lama_belajar', $row->lama_belajar),
				'id_kelas' => set_value('id_kelas', $row->id_kelas),
				);
			$this->load->view('header',$dataAdm); 	
            $this->load->view('matapelajaran/matapelajaran_form', $data); 
			$this->load->view('footer');
        } 
		
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matapelajaran'));
        }
    }
    
    public function update_action(){
				
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $this->_rules();
		

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_matapelajaran', TRUE));
        } 

		else {
            $data = array(
			'kode_matapelajaran' => $this->input->post('kode_matapelajaran',TRUE),
			'nama_matapelajaran' => $this->input->post('nama_matapelajaran',TRUE),
			'lama_belajar' => $this->input->post('lama_belajar',TRUE),
			'id_kelas' => $this->input->post('id_kelas',TRUE),
			);

            $this->Matapelajaran_model->update($this->input->post('kode_matapelajaran', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('matapelajaran'));
        }
    }
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Matapelajaran_model->get_by_id($id);
		
	
        if ($row) {
            $this->Matapelajaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('matapelajaran'));
        } 
		
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('matapelajaran'));
        }
    }
	

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_matapelajaran', 'kode matapelajaran', 'trim|required');
	$this->form_validation->set_rules('nama_matapelajaran', 'nama matapelajaran', 'trim|required');
	$this->form_validation->set_rules('lama_belajar', 'lama belajar', 'trim|required');
	$this->form_validation->set_rules('id_kelas', 'id kelas', 'trim|required');
	$this->form_validation->set_rules('kode_matapelajaran', 'kode_matapelajaran', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}


?>