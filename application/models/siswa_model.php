<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class siswa_model extends CI_Model
{
	   
    public $table = 'siswa';
    public $id = 'nis';
    public $order = 'DESC';
    
	// Konstrutor    
    function __construct()
    {
        parent::__construct();
    }
	
	
    function json() {		
        $this->datatables->select("nis, nama_lengkap, alamat, email, telp, IF(jenis_kelamin = 'P', 'Perempuan', 'Laki-laki') as jenisKelamin");
        $this->datatables->from('siswa');        
        $this->datatables->add_column('action', anchor(site_url('siswa/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  ".anchor(site_url('siswa/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('siswa/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'nis');
        return $this->datatables->generate();
    }
	
     
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }


    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
	
    function total_rows($q = NULL) {
        $this->db->like('nis', $q);
		$this->db->or_like('nis', $q);
		$this->db->or_like('nama_lengkap', $q);
		$this->db->or_like('nama_panggilan', $q);
		$this->db->or_like('alamat', $q);
		$this->db->or_like('email', $q);
		$this->db->or_like('telp', $q);
		$this->db->or_like('tempat_lahir', $q);
		$this->db->or_like('tgl_lahir', $q);
		$this->db->or_like('jenis_kelamin', $q);
		$this->db->or_like('agama', $q);		
		$this->db->or_like('id_kelas', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('nis', $q);
		$this->db->or_like('nis', $q);
		$this->db->or_like('nama_lengkap', $q);
		$this->db->or_like('nama_panggilan', $q);
		$this->db->or_like('alamat', $q);
		$this->db->or_like('email', $q);
		$this->db->or_like('telp', $q);
		$this->db->or_like('tempat_lahir', $q);
		$this->db->or_like('tgl_lahir', $q);
		$this->db->or_like('jenis_kelamin', $q);
		$this->db->or_like('agama', $q);		
		$this->db->or_like('id_kelas', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Menambahkan data kedalam database
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // Merubah data kedalam database
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // Menghapus data kedalam database
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

