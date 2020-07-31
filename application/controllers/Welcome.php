<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}
    public function guardar()
    {
        $this->db->query("INSERT INTO `tbclientes` SET
Nombres='".$_POST['nombre']."',
celular='".$_POST['celular']."',
password='".$_POST['password']."'
");
        $query=$this->db->query("SELECT * FROM tbclientes WHERE Cod_Aut='".$this->db->insert_id()."'");
        echo json_encode($query->result_array());
    }
    public function getgrupos(){
        $query=$this->db->query("SELECT * FROM tbgrupos g WHERE g.Cod_grup IN (SELECT tbproductos.cod_grup FROM tbproductos)");
        echo json_encode($query->result_array());
    }
    public function getproductos($id){
        $query=$this->db->query("SELECT * FROM tbproductos WHERE cod_grup='$id'");
//p INNER JOIN tbstockm s ON p.cod_prod=s.cod_prod AND cod_grup='$id'");
        echo json_encode($query->result_array());
    }
    public function getcom($id){
	    $query=$this->db->query("SELECT * FROM tbproductos p INNER JOIN tbcomposicion c ON p.cod_prod=c.cod_prod WHERE p.cod_prod='$id'");
        echo json_encode($query->result_array());
    }
}
