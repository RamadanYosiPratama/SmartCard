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
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->helper('my_function'); // Memanggil fungsi my_function yang terdapat pada helper	
    }
  
  // Fungsi untuk menampilkan halaman nilai 
  public function index(){
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
	  
	  // Menampung data yang diberi nilai
      $data = array(
        'button' => 'Proses',		
        'action' => site_url('nilai/nilaiKhs_action'),
	    'nis' => set_value('nis'),
		'id_thn_akad' => set_value('id_thn_akad'),
	  );
				
        $this->load->view('header',$dataAdm ); // Menampilkan bagian header dan object data users 
        $this->load->view('nilai/nilaiKhs_form', $data); // Menampilkan halaman utama yaitu form nilai 
		$this->load->view('footer'); // Menampilkan bagian footer
    }
	
	// Fungsi untuk melakukan aksi menampilkan data nilai
    public function nilaiKhs_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rulesKhs(); // Rules atau aturan bahwa setiap form harus diisi
	

		if ($this->form_validation->run() == FALSE) {
				$this->nilaiKhs();
		} 
	
		else {
			$nis=$this->input->post('nis',TRUE);
			$thn_akad=$this->input->post('id_thn_akad',TRUE);
			
		
			$sql = "SELECT krs.id_thn_akad
						 , krs.kode_matapelajaran
						 , matapelajaran.nama_matapelajaran
						 , matapelajaran.lama_belajar
						 , krs.nilai
					FROM
					   krs
					INNER JOIN matapelajaran 
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
			  
			  // Mengkonversi semester dalam bentuk integer ke string
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
							'mhs_nis'=>$nis,
							'mhs_nama'=>$mhs->nama_lengkap,
							'mhs_kelas'=>$mhs->nama_kelas,
							'thn_akad'=>$smt->thn_akad."(". $tampilSemester.")"
							);
						  
			$this->load->view('header',$dataAdm); 
			$this->load->view('nilai/khs',$data); 
			$this->load->view('footer'); // Menampilkan bagian footer
		}
   }
   
    
    public function _rulesKhs(){
	 $this->form_validation->set_rules('nis', 'nis', 'trim|required|min_length[10]|max_length[10]');
	 $this->form_validation->set_rules('id_thn_akad','id_thn_akad', 'trim|required');
	}
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update) Transkrip
	public function _rulesTranskrip(){
	 	
	 $this->form_validation->set_rules('nis', 'nis', 'trim|required|min_length[10]|max_length[10]');
	}
	
	// Fungsi untuk membuat Transkrip
	public function buatTranskrip(){
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
	  
      // Menampung data berdasarkan nim yang diinputkan  
      $data = array(
        'button' => 'Proses',
        'action' => site_url('nilai/buatTranskrip_action'),
	    'nis' => set_value('nis')		
	    );
				
        $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
        $this->load->view('nilai/buatTranskrip_form', $data); // Menampilkan halaman form buat transkrip
		$this->load->view('footer'); // Menampilkan bagian footer
    }
	
	// Fungsi untuk melakukan aksi buat transkrip
	public function buatTranskrip_action(){
		// Jika session data username tidak ada maka akan dialihkan kehalaman login			
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rulesTranskrip(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form buat transkrip belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
				$this->buatTranskrip();
		} 
		// Jika form buat transkrip telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
			$nis=$this->input->post('nis',TRUE);
			
			// Query menampilkan semua data pada tabel krs
			$this->db->select('*');
			$this->db->from('krs');
			$this->db->where('nis', $nis);
			$query=$this->db->get();
			foreach ($query->result() as $value)
			{				
             		
				cekNilai($value->nis,$value->kode_matapelajaran,$value->nilai);
				  
			}
			
			$this->db->select('t.kode_matapelajaran,m.nama_matapelajaran,m.lama_belajar,t.nilai');
			$this->db->from('transkrip as t');
			$this->db->join('matapelajaran as m','m.kode_matapelajaran = t.kode_matapelajaran');
			$trans = $this->db->get()->result();
			

			$mhs=$this->db->select('nama_lengkap,id_kelas')
							->from('siswa')
							->where(array('nis'=>$nis))
							->get()->row();

			$kelas=$this->db->select('nama_kelas')
							->from('kelas')
							->where(array('id_kelas'=>$mhs->id_kelas))
							->get()->row()->nama_kelas;		
			
			
			$data=array('trans'=>$trans,
						'nis'=>$nis,
						'nama'=>$mhs->nama_lengkap,
						'kelas'=>$kelas);
			
			// Menampilkan data berdasarkan id-nya yaitu username
			$rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
			$dataAdm = array(	
					'wa'       => 'Web administrator',
					'univ'     => 'SmartCard Course',
					'username' => $rowAdm->username,
					'email'    => $rowAdm->email,
					'level'    => $rowAdm->level,
				);  
					
			$this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 
			$this->load->view('nilai/buatTranskrip',$data); // Menampilkan form membuat transkrip
			$this->load->view('footer'); // Menampilkan bagian footer
		}
   }
   
   // Fungsi menampilkan form Input Nilai
    public function inputNilai(){
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
	  
	  // Menampung data yang diinputkan
      $data = array(
        'button' => 'Proses',
		'back'   => site_url('nilai/inputNilai'),
        'action' => site_url('nilai/inputNilai_action'),
	    'kode_matapelajaran' => set_value('kode_matapelajaran'),
		'id_thn_akad' => set_value('id_thn_akad'),
	    );		
		
        $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users	 
        $this->load->view('nilai/inputNilai_form', $data); // Menampilkan halaman form input nilai
		$this->load->view('footer'); // Menampilkan bagian footer
    }
	
	// Fungsi untuk melakukan aksi menampilkan nilai 
	public function inputNilai_action(){  
	 // Jika session data username tidak ada maka akan dialihkan kehalaman login			
	 if (!isset($this->session->userdata['username'])) {
		redirect(base_url("login"));
	 }
	
	 $this->_rulesInputNilai(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form nilai belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
				$this->inputNilai();
		} 
		// Jika form nilai telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
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
		  
		  // Menampung data yang diinputkan berdasarkan kode matakuliah dan id tahun akademik
		  $data=array('button' => 'Input',
					  'back'   => site_url('nilai/inputNilai'),
		              'list_nilai'=>$qry,
					  'action' => site_url('nilai/simpan_action'),
					  'kode_matapelajaran'=>$kode_mk,
					  'id_thn_akad'=>$id_thn_akad);
		  
		  // Menampilkan data berdasarkan id-nya yaitu username
		  $rowAdm = $this->Users_model->get_by_id($this->session->userdata['username']);
		  $dataAdm = array(	
			'wa'       => 'Web administrator',
			'univ'     => 'SmartCard Course',
			'username' => $rowAdm->username,
			'email'    => $rowAdm->email,
			'level'    => $rowAdm->level,
			);
		
		  $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users
		  $this->load->view('nilai/listNilai',$data); // Menampilkan halaman list nilai
		  $this->load->view('footer'); // Menampilkan bagian footer
		 }
	 
	}
	
	// Fungsi untuk melakukan aksi simpan data
	public function simpan_action(){
     // Jika session data username tidak ada maka akan dialihkan kehalaman login			
	 if (!isset($this->session->userdata['username'])) {
		redirect(base_url("login"));
	 }	
	 
	 $nilaiLis=array();	 
	 $id_krs = $_POST['id_krs']; // input data berdasarkan id_krs	  
	 $nilai  = $_POST['nilai'];  // input data berdasarkan nilai
	 	
     for ($i=0; $i<sizeof($id_krs); $i++)
     {
 	   
	   $this->db->set('nilai',$nilai[$i])->where('id_krs',$id_krs[$i])->update('krs');	 
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
     // Menampung data yang diinputkan	
	 $data=array(
				 'id_krs'=>$id_krs,
				 'button' => 'Input',
			     'back'   => site_url('nilai/inputNilai'),
				 );
	 
	 $this->load->view('header',$dataAdm); // Menampilkan bagian header dan object data users 	
	 $this->load->view('nilai/nilai',$data); // Menampilkan halaman form nilai
	 $this->load->view('footer'); // Menampilkan bagian footer
	}
	
	public function _rulesInputNilai()
    {
	 $this->form_validation->set_rules('kode_matapelajaran', 'kode_matapelajaran', 'trim|required');
	 $this->form_validation->set_rules('id_thn_akad','id_thn_akad', 'trim|required');
	}
}


?>