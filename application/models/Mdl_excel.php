<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_excel extends CI_Model
{
    // var $order_column = array("nroparte","idclasificacion","clasificacion");

    function make_query( $nruc = null, $coduser = null)
    {
        // $this->db->select('v.nroparte, a.descripcion as clasificacion, v.descripcion as nombre');
        // $this->db->from('repuestos AS v');
        // $this->db->join('clasificacion AS a','v.idclasificacion = a.idclasificacion','inner');


        $this->db->select('idarchivo,nombre,fecha');
        $this->db->from('archivos');

        // $this->db->where('float',0);
        if(isset($_POST["search"]["value"]))
        {
            /*$this->db->like("nombre", $_POST["search"]["value"]);*/

            // $busc = $_POST["search"]["value"];
            // $this->db->where("(v.descripcion LIKE '%".$busc."%' )", NULL, FALSE);

            // $busc = $_POST["search"]["value"];
            // $this->db->where("(v.nroparte LIKE '%".$busc."%' 
            //                         OR a.descripcion LIKE '%".$busc."%' 
            //                         OR v.descripcion LIKE '%".$busc."%' 
            //                          )", NULL, FALSE);
        }
        if(isset($_POST["order"]))
        {
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }
        else
        {
            // $this->db->order_by('v.descripcion', 'DESC');
        }
    }

    public function get_documento($value){
        //PETICION A TABLA
        $this->db->select('idarchivo,nombre,fecha,direccion,namearchivo');
        $this->db->from('archivos');
        $this->db->where('idarchivo',$value);

        $query = $this->db->get();
        $num_fila = $query->num_rows();
        if($num_fila > 0){
            $retorno = $query->result();
        }else{
            $retorno = 'error';
        }
        return $retorno;
    }

    function make_datatables( $nruc = null, $coduser = null){
        $this->make_query();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function get_filtered_data( $nruc = null, $coduser = null){
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_data( $nruc = null, $coduser = null)
    {
        $this->db->select('idarchivo');
        $this->db->from('archivos');
        // $this->db->where('float',0);
        return $this->db->count_all_results();
    }

    function mostrar_planes()
    {
        $this->db->select('*');
        $this->db->from('clasificacion');
        $this->db->order_by("descripcion", "desc");
        // $this->db->where('enab',1);
        $query = $this->db->get();
        return $query->result();
    }

/*MOSTRAR REPUESTOS*/
    function mostrar_repuestos()
    {
        $this->db->select('*');
        $this->db->from('repuestos');
        $this->db->order_by("descripcion", "desc");
        $this->db->where('enab',1);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_imagenes($id){
        $this->db->select('imagen1,imagen2,imagen3');
        $this->db->from('repuestos');
        $this->db->where('nroparte',$id);
        $query = $this->db->get();
        return $query->result();
    }

    function update_table($idregistro,$array){
        $this->db->where('nroparte', $idregistro);
        return $this->db->update('repuestos', $array);
    }
// web
    function mostrar_plan_seleccionado($id)
    {

        $this->db->select('*');
        $this->db->from('tb_planes');
        $this->db->order_by("nombre", "desc");
        $this->db->where('id_plan',$id);
        $query = $this->db->get();
        return $query->result();
    }

    function validar_voucher_generado($tokenid)
    {
        $this->db->select('*');
        $this->db->from('pagosweb_temporal');
        // $this->db->order_by("nombre", "desc");
        $this->db->where('tokenid',$tokenid);
        $query = $this->db->get();
        return $query->result();

    }

    function actualizar_voucher_generado($idregistro,$array){
        $this->db->where('idpagos', $idregistro);
        return $this->db->update('pagosweb_temporal', $array);
    }



}