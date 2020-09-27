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
    public function ingreso(){
	    if(isset($_POST['mesa'])){
	        $mesa=$_POST['mesa'];
        }else{
            $mesa=0;
        }
	    $query=$this->db->query("SELECT * FROM  tbclientes WHERE Id='".$_POST['carnet']."'");
	    if ($query->num_rows()==0){
	    $this->db->query("INSERT INTO `tbclientes` 
        (`Cod_Aut`,
            `Id`,
            `Cod_ciudad`,
            `Cod_Nacio`,
            `cod_car`,
            `Nombres`,
            `Telf`,
            `Direccion`,
            `EstCiv`,
            `edad`,
            `Empresa`,
            `Categoria`,
            `CIVend`,
            `ListBlack`,
            `MotivoListBlack`,
            `TipoPaciente`,
            `Imp_Pieza`,
            `SupraCanal`,
            `Canal`,
            `celular`,
            `password`,
            `mesa`) VALUES 
            (NULL,
            '".$_POST['carnet']."',
            '',
            '',
            '0',
            '".$_POST['nombre']."',
            NULL,
            NULL,
            '',
            '',
            '',
            '0',
            '',
            '0',
            '',
            '',
            '0',
            '',
            '',
            '".$_POST['celular']."',
            '',
            '$mesa');");

            $query=$this->db->query("SELECT * FROM  tbclientes WHERE Id='".$_POST['carnet']."'");
            echo json_encode($query->result_array());
        }else{
            $this->db->query("UPDATE `tbclientes` SET 
            `Nombres` = '".$_POST['nombre']."',
            `celular` = '".$_POST['celular']."',
            `mesa` = '".$_POST['mesa']."' WHERE `Id` = '".$_POST['carnet']."';");
            $query=$this->db->query("SELECT * FROM  tbclientes WHERE Id='".$_POST['carnet']."'");
            echo json_encode($query->result_array());

        }
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
//        $query=$this->db->query("SELECT * FROM sucursales");
        $query=$this->db->query("SELECT * FROM tbdatfac");
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
    public function comanda($nro){
        $this->db->query("SELECT Nro  FROM tbdatfac WHERE Nro='$nro'");

        echo  ($this->db->query("SELECT Nro  FROM tbdatfac WHERE Nro='$nro'")->row()->Nro)+1;
//        json_encode($query->result_array());
    }
    public function ventasadj(){
        $cod_producto=$this->db->query("SELECT cod_prod as prod FROM tbproductos WHERE CodAut='".$_POST['idproducto']."'")->row()->prod;
        $cod_producto_p=$this->db->query("SELECT cod_prod as prod FROM tbproductos WHERE CodAut='".$_POST['idproductop']."'")->row()->prod;
        $this->db->query("INSERT INTO tbventas_adj SET
        comanda='".$_POST['comanda']."',
        ci='0',
        mesa='0',
        Monto='0',
        cant='".$_POST['cantidad']."',
        cod_pro='$cod_producto',
        Cod_pro_p='$cod_producto_p',
        Nro='".$_POST['nro']."'
        ");
    }
    public function pedidodetalles(){
//	    $cod_producto=$this->db->query("SELECT cod_prod as prod FROM tbproductos WHERE CodAut='".$_POST['idproducto']."'")->row()->prod;
        $cod_producto=$this->db->query("SELECT cod_prod as prod FROM tbproductos WHERE CodAut='".$_POST['idproducto']."'")->row()->prod;


        $this->db->query("INSERT INTO pedidodetalles SET
        idproducto='".$_POST['idproducto']."',
        producto='".trim($_POST['producto'])."',
        precio='".$_POST['precio']."',
        cantidad='".$_POST['cantidad']."',
        subtotal='".$_POST['subtotal']."',
        detalle='".$_POST['detalle']."',
        idpedido='".$_POST['idpedido']."'
        ");
//        $query=$this->db->query("SELECT p2.CodAut, p2.Producto,c.Tipo,0 as 'cantidad' FROM tbproductos p INNER JOIN tbcomposicion c ON p.cod_prod=c.Cod_Prod_r INNER JOIN tbproductos p2 ON c.cod_prod=p2.cod_prod WHERE p.cod_prod='$cod_producto'");
//
//        $this->db->query("INSERT INTO tbventas_adj SET
//        comanda='".$_POST['comanda']."',
//        ci='".trim($_POST['ci'])."',
//        mesa='0',
//        morto='0',
//        cantidad='".$_POST['cantidad']."',
//        detalle='".$_POST['detalle']."',
//        idpedido='".$_POST['idpedido']."'
//        ");


        $this->db->query("INSERT INTO `tbventas` (
        `CodAut`,
        `Comanda`,
        `Comandas`,
        `ci`,
        `MESA`,
        `PVentUnit`,
        `Monto`,
        `cant`,
        `cod_pro`,
        `Fech_Venta`,
        `FechaFac`,
        `Elnado`,
        `NroCierre`,
        `FeCierre`,
        `Cod_Plan`,
        `Nro`,
        `AlmaOrig`,
        `Cobrado`,
        `IdCli`,
        `Planch`,
        `Recoge`,
        `Fecha_entre`,
        `NroLote`,
        `AutDescu`,
        `Efectivo`,
        `CtasCobrar`,
        `CantCaja`,
        `Porciento`,
        `UnidPeso`,
        `HtelReg`,
        `NroCobro`,
        `CodTeat`,
        `ColumNro`,
        `ColumTxt`,
        `NomFuncion`,
        `Fech_Espec`,
        `AtCliente`,
        `tarjeta`) VALUES (
        NULL,
        '".$_POST['comanda']."',
        '0',
        '".$_POST['ci']."',
        '".$_POST['mesa']."',
        '".$_POST['precio']."',
        '".$_POST['subtotal']."',
        '".$_POST['cantidad']."',
        '".$cod_producto."',
        '".date("Y-m-d H:i:s")."',
        '0000-00-00 00:00:00',
        '0',
        '0',
        NULL,
        '',
        '".$_POST['nro']."',
        '0',
        '1',
        '',
        '0',
        '0',
        '0000-00-00',
        '',
        '0',
        '0',
        '0',
        '0',
        '0',
        '0',
        '0',
        '',
        '0',
        '0',
        '',
        '',
        '0000-00-00',
        '',
        '');");
        echo "1";
    }
}
