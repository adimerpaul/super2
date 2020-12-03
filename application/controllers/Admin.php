<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index()
    {
        $this->load->view('login');
    }
    public function login(){
        if ($_POST['email']=='admin@gmail.com' && $_POST['password']=='admin'){
            echo "SI";
        }else{
            echo "NO";
        }
    }
    public function productos(){
        $query=$this->db->query("SELECT * FROM tbproductos");
        echo json_encode($query->result_array());
    }
    public function modificar($id){
//        $id=$_POST['id'];
//        echo $id;
//        exit;
        $target_path = "img/grupos/";
        $target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
//            echo "El archivo ".  basename( $_FILES['uploadedfile']['name'])." ha sido subido";
            $patch=$target_path;
        } else{
//            echo "Ha ocurrido un error, trate de nuevo!";
            $patch="";
        }
        $this->db->query("UPDATE tbproductos SET img='$patch' WHERE CodAut='$id'");
        $query=$this->db->query("SELECT * FROM tbproductos WHERE CodAut='$id'");
        echo json_encode($query->result_array()[0]);
//        $query=$this->db->query("SELECT * FROM tbproductos");
//        echo json_encode($query->result_array());

    }
    public function actualizar(){
        $Producto=$_POST['Producto'];
        $CodAut=$_POST['CodAut'];
        $descripcion=$_POST['descripcion'];
        $this->db->query("UPDATE tbproductos SET Producto='$Producto',descripcion='$descripcion' WHERE CodAut='$CodAut'");
        $query=$this->db->query("SELECT * FROM tbproductos WHERE CodAut='$CodAut'");
        echo json_encode($query->result_array()[0]);
    }
}
