<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Matapelajaran_model extends CI_Model
{
    // Property yang bersifat public   
    public $table = 'matapelajaran';
    public $id = 'kode_matapelajaran';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   function __construct()
    {
        parent::__construct();
    }

    function json() {       
		$this->datatables->select("m.kode_matapelajaran, m.nama_matapelajaran, p.nama_kelas");
        $this->datatables->from(' matapelajaran as m');

        $this->datatables->join('kelas as p','m.id_kelas= p.id_kelas');
        $this->datatables->add_column('action', anchor(site_url('matapelajaran/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  ".anchor(site_url('matapelajaran/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  ".anchor(site_url('matapelajaran/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_matapelajaran');
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
        $this->db->like('kode_matapelajaran', $q);
		$this->db->or_like('kode_matapelajaran', $q);
		$this->db->or_like('nama_matapelajaran', $q);
		$this->db->or_like('lamabelajar', $q);
		$this->db->or_like('id_kelas', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kode_matapelajaran', $q);
		$this->db->or_like('kode_matapelajaran', $q);
		$this->db->or_like('nama_matapelajaran', $q);
		$this->db->or_like('lamabelajar', $q);
		$this->db->or_like('id_kelas', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }


    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }


    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
