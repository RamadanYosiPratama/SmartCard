<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai extends CI_Controller
{
  
  // Konstruktor	
  function __construct()
    {
        parent::__construct();
        $this->load->model('Transkrip_model'); 
		$this->load->model('Users_model');
        $this->load->library('form_validation');
		$this->load->helper('my_function'); 
    }
  

  public function index(){
	  			
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
        'button' => 'Proses',		
        'action' => site_url('nilai/nilaiKhs_action'),
	    'nis' => set_value('nis'),
		'id_thn_akad' => set_value('id_thn_akad'),
	  );
				
        $this->load->view('header',$dataAdm ); 
        $this->load->view('nilai/nilaiKhs_form', $data);  
		$this->load->view('footer'); 
    }

    public function nilaiKhs_action(){
				
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rulesKhs(); 
	
		
		if ($this->form_validation->run() == FALSE) {
				$this->nilaiKhs();
		} 
		
		else {
			$nim=$this->input->post('nis',TRUE);
			$thn_akad=$this->input->post('id_thn_akad',TRUE);

			$sql = "SELECT krs.id_thn_akad
						 , krs.kode_matapelajaran
						 , matapelajaran.nama_matapelajaran
						 , krs.nilai
					FROM
					   krs
					INNER JOIN matakuliah 
					ON (krs.kode_matapelajaran = matapelajaran.kode_matapelajaran)
					WHERE krs.nis=$nis AND krs.id_thn_akad=$thn_akad";		     
			  $query = $this->db->query($sql)->result();
			  
			  $smt = $this->db->select('thn_akad, semester')
							  ->from('thn_akad_semester')
							  ->where(array('id_thn_akad'=>$thn_akad))->get()->row();	 
			  
			  
			  $query_str="SELECT siswa.nis
							 , siswa.nama_lengkap
							 , kelas.nama_kelas
						  FROM
							 siswa
							INNER JOIN kelas 
							ON (siswa.id_kelas = kelas.id_kelas);";
			  $mhs=$this->db->query($query_str)->row();
			  

			  if($smt->semester == 1){
				  $tampilSemester ="Ganjil";
			  }
			  else{
				  $tampilSemester ="Genap";
			  }
		
			  $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
			  $dataAdm = array(	
					'wa'       => 'Web administrator',
					'univ'     => 'SmartCard Course',
					'username' => $rowAdm->username,
					'email'    => $rowAdm->email,
					'level'    => $rowAdm->level,
				);
			  
			  $data = array('button' => 'Detail',
							'back'   => site_url('nilai'),
							'mhs_data'=>$query,
							'mhs_nim'=>$nis,
							'mhs_nama'=>$mhs->nama_lengkap,
							'mhs_kelas'=>$mhs->nama_kelas,
							'thn_akad'=>$smt->thn_akad."(". $tampilSemester.")"
							);
						  
			$this->load->view('header',$dataAdm); 
			$this->load->view('nilai/khs',$data); 
			$this->load->view('footer'); 
		}
   }
   
 
    public function _rulesKhs(){
	 $this->form_validation->set_rules('nis', 'nis', 'trim|required|min_length[10]|max_length[10]');
	 $this->form_validation->set_rules('id_thn_akad','id_thn_akad', 'trim|required');
	}
	
	public function _rulesTranskrip(){
	 	
	 $this->form_validation->set_rules('nis', 'nis', 'trim|required|min_length[10]|max_length[10]');
	}
	
	
	public function buatTranskrip(){
	  			
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
        'button' => 'Proses',
        'action' => site_url('nilai/buatTranskrip_action'),
	    'nim' => set_value('nim')		
	    );
				
        $this->load->view('header',$dataAdm); 
        $this->load->view('nilai/buatTranskrip_form', $data);
		$this->load->view('footer'); 
    }
	

	public function buatTranskrip_action(){
				
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rulesTranskrip(); 

		if ($this->form_validation->run() == FALSE) {
				$this->buatTranskrip();
		} 
		
		else {
			$nim=$this->input->post('nis',TRUE);
			
			
			$this->db->select('*');
			$this->db->from('krs');
			$this->db->where('nis', $nis);
			$query=$this->db->get();
			foreach ($query->result() as $value)
			{				
             			
				cekNilai($value->nis,$value->kode_matapelajaran,$value->nilai);
				  
			}
	
			$this->db->select('t.kode_matapelajaran,m.nama_matapelajaran,t.nilai');
			$this->db->from('transkrip as t');
			$this->db->join('matapelajaran as m','m.kode_matapelajaran = t.kode_matapelajaran');
			$trans = $this->db->get()->result();
			

			$mhs=$this->db->select('nama_lengkap,id_kelas')
							->from('siswa')
							->where(array('nis'=>$nis))
							->get()->row();

			$prodi=$this->db->select('nama_kelas')
							->from('kelas')
							->where(array('id_kelas'=>$mhs->id_kelas))
							->get()->row()->nama_kelas;		
			
			
			$data=array('trans'=>$trans,
						'nis'=>$nis,
						'nama'=>$mhs->nama_lengkap,
						'kelas'=>$kelas);
			
		
			$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
			$dataAdm = array(	
					'wa'       => 'Web administrator',
					'univ'     => 'SmartCard Course',
					'username' => $rowAdm->username,
					'email'    => $rowAdm->email,
					'level'    => $rowAdm->level,
				);  
					
			$this->load->view('header',$dataAdm); 
			$this->load->view('nilai/buatTranskrip',$data); 
			$this->load->view('footer'); 
		}
   }
   

    public function inputNilai(){
	  		
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
        'button' => 'Proses',
		'back'   => site_url('nilai/inputNilai'),
        'action' => site_url('nilai/inputNilai_action'),
	    'kode_matapelajaran' => set_value('kode_matapelajaran'),
		'id_thn_akad' => set_value('id_thn_akad'),
	    );		
		
        $this->load->view('header',$dataAdm); 
        $this->load->view('nilai/inputNilai_form', $data);
		$this->load->view('footer'); 
    }
	

	public function inputNilai_action(){  
		
	 if (!isset($this->session->userdata['username'])) {
		redirect(base_url("login"));
	 }
	
	 $this->_rulesInputNilai(); 
		

		if ($this->form_validation->run() == FALSE) {
				$this->inputNilai();
		} 

		else {
		  $kode_mk =$this->input->post('kode_matapelajaran',TRUE);
		  $id_thn_akad=$this->input->post('id_thn_akad',TRUE);		 
		 
		  $this->db->select('k.id_krs, k.nis, m.nama_lengkap, k.nilai, d.nama_matapelajaran' );
		  $this->db->from('krs as k');
		  $this->db->join('siswa as m','m.nis = k.nis');
		  $this->db->join('matapelajaran as d','k.kode_matapelajaran = d.kode_matapelajaran');		   
		  $this->db->where('k.id_thn_akad', $id_thn_akad);
		  $this->db->where('k.kode_matapelajaran',$kode_mk);
		  $qry=$this->db->get()->result();
		  
		
		  $data=array('button' => 'Input',
					  'back'   => site_url('nilai/inputNilai'),
		              'list_nilai'=>$qry,
					  'action' => site_url('nilai/simpan_action'),
					  'kode_matapelajaran'=>$kode_mk,
					  'id_thn_akad'=>$id_thn_akad);
		  

		  $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		  $dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
			);
		
		  $this->load->view('header',$dataAdm);
		  $this->load->view('nilai/listNilai',$data); 
		  $this->load->view('footer'); 
		 }
	 
	}
	

	public function simpan_action(){
   			
	 if (!isset($this->session->userdata['username'])) {
		redirect(base_url("login"));
	 }	
	 
	 $nilaiLis=array();	 
	 $id_krs = $_POST['id_krs']; 	  
	 $nilai  = $_POST['nilai'];  
	 	
     for ($i=0; $i<sizeof($id_krs); $i++)
     {
 	   
	   $this->db->set('nilai',$nilai[$i])->where('id_krs',$id_krs[$i])->update('krs');	 
	 }
	 

	 $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
	 $dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
		);
	
	 $data=array(
				 'id_krs'=>$id_krs,
				 'button' => 'Input',
			     'back'   => site_url('nilai/inputNilai'),
				 );
	 
	 $this->load->view('header',$dataAdm);	
	 $this->load->view('nilai/nilai',$data); 
	 $this->load->view('footer'); 
	}
	
	public function _rulesInputNilai()
    {
	 $this->form_validation->set_rules('kode_matapelajaran', 'kode_matapelajaran', 'trim|required');
	 $this->form_validation->set_rules('id_thn_akad','id_thn_akad', 'trim|required');
	}
}

?>