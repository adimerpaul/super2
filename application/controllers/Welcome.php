<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('super');
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
    public function login()
    {
        $query=$this->db->query("SELECT * FROM `tbclientes` WHERE  
celular='".$_POST['celular']."' AND
password='".$_POST['password']."'
");
//        $query=$this->db->query("SELECT * FROM tbclientes WHERE Cod_Aut='".$this->db->insert_id()."'");
        echo json_encode($query->result_array());
    }
    public function getgrupos(){
        $query=$this->db->query("SELECT * FROM tbgrupos g WHERE g.Cod_grup IN (SELECT tbproductos.cod_grup FROM tbproductos)");
        echo json_encode($query->result_array());
    }
    public function getproductos($id){
//        $query=$this->db->query("SELECT * FROM tbproductos WHERE cod_grup='$id' ");
//p INNER JOIN tbstockm s ON p.cod_prod=s.cod_prod AND cod_grup='$id'");
        $query=$this->db->query(
            "SELECT p.CodAut,p.cod_prod,p.Precio,p.Producto,p.stock,p.descripcion, (SELECT g.codAut  FROM tbgrupos g WHERE g.Cod_grup=p.cod_grup) as 'cod_grup',( 
IF( (select count(*) FROM tbstockm s WHERE s.cod_prod=p.cod_prod )=1, 
(select s.Saldo FROM tbstockm s WHERE s.cod_prod=p.cod_prod ) ,0) )as 'Saldo' 
FROM tbproductos p WHERE p.cod_grup='$id'"
        );
        echo json_encode($query->result_array());
    }
    public function getcom($id){
//	    $query=$this->db->query("SELECT * FROM tbproductos p INNER JOIN tbcomposicion c ON p.cod_prod=c.cod_prod WHERE p.cod_prod='$id'");
//        $query=$this->db->query("SELECT p2.Producto FROM tbproductos p
//INNER JOIN tbcomposicion c ON p.cod_prod=c.cod_prod INNER JOIN tbproductos p2 ON c.Cod_Prod_r=p2.cod_prod WHERE p.cod_prod='$id'");
        $query=$this->db->query("SELECT p2.CodAut, p2.Producto,c.Tipo,0 as 'cantidad' FROM tbproductos p INNER JOIN tbcomposicion c ON p.cod_prod=c.Cod_Prod_r INNER JOIN tbproductos p2 ON c.cod_prod=p2.cod_prod WHERE p.cod_prod='$id'");
        echo json_encode($query->result_array());
    }
    public function sucursales(){
        $query=$this->db->query("SELECT * FROM sucursales");
        echo json_encode($query->result_array());
    }
    public function pedido(){
        $this->db->query("INSERT INTO pedidos SET
        nombre='".$_POST['nombre']."',
        celular='".$_POST['celular']."',
        lat='".$_POST['lat']."',
        lng='".$_POST['lng']."',
        idsucursal='".$_POST['idsucursal']."',
        costoenvio='".$_POST['costoenvio']."',
        idcliente='".$_POST['idcliente']."',
        total='".$_POST['total']."'
        ");
        echo $this->db->insert_id();
    }
    public function pedidodetalles(){
        $this->db->query("INSERT INTO pedidodetalles SET
        idproducto='".$_POST['idproducto']."',
        producto='".$_POST['producto']."',
        precio='".$_POST['precio']."',
        cantidad='".$_POST['cantidad']."',
        subtotal='".$_POST['subtotal']."',
        detalle='".$_POST['detalle']."',
        idpedido='".$_POST['idpedido']."'
        ");
        echo "1";
    }
}
