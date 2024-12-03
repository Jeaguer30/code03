<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_counters extends CI_Model
{
    var $order_column = array("coduser","nombre","apellido",null,null,"usuario");

    function make_query()
    {
        $this->db->select('coduser, nombre, apellido, correo, tel, usuario');
        $this->db->from('usuarios');
        $this->db->where('float',0);
        if(isset($_POST["search"]["value"]))
        {
            /*$this->db->like("coduser", $_POST["search"]["value"]);
            $this->db->or_like("nombre", $_POST["search"]["value"]);
            $this->db->or_like("apellido", $_POST["search"]["value"]);
            $this->db->or_like("usuario", $_POST["search"]["value"]);*/
            $busc = $_POST["search"]["value"];
            $this->db->where("(coduser LIKE '%".$busc."%' OR nombre LIKE '%".$busc."%' OR apellido LIKE '%".$busc."%' OR usuario LIKE '%".$busc."%' )", NULL, FALSE);
        }
        if(isset($_POST["order"]))
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this->db->order_by('coduser', 'DESC');
        }
    }
    function make_datatables(){
        $this->make_query();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function get_filtered_data(){
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_data()
    {
        $this->db->select('coduser');
        $this->db->from('usuarios');
        $this->db->where('float',0);
        return $this->db->count_all_results();
    }

    public function get_counters_by_id($value)
    {
        $query = $this->db->select('*')
            ->from('usuarios')
            ->where('coduser', $value)
            ->limit(1)
            ->get();
        return $query->result();
    }

    public function update( $id = null, $ruc = null, $data = null)
    {
        $query = $this->db->where('coduser',$id)
                            ->where('nruc',$ruc)
                            ->update('usuarios', $data);
        return $query;
    }


    function exporexcsj($titutlo,$filas,$where,$key,$tabla,$n,$area,$innerjoin,$idunion){

        $string = '
			<table>
				<tr>
					<td colspan="'.$n.'">
						<h1>REPORTE SELECCIONADO DE '.$area.'</h1>
					</td>
				</tr>
				<tr>
					<td colspan="'.$n.'"></td>
				</tr>
				<tr>
					<td colspan="'.$n.'" align="right">
						<p><b>Fecha de reporte:</b> '.date('d/m/Y H:i').'</p>
					</td>
				</tr>
				<tr>
					<td colspan="'.$n.'"></td>
				</tr>
				<tr align="center" style="color:#FFFFFF;">';
        foreach($titutlo as $getvalor){
            $string .= '<td style="font-weight:bold;background-color:#1D68A6;border:1px solid black;vertical-align:middle;" rowspan="2">'.utf8_decode($getvalor).'</td>';
        }
        $string .= '
				</tr>
				<tr>
					<td colspan="'.$n.'"></td>
				</tr>
				';
        //UNIENDO TABLAS
        if(is_array($innerjoin)){
            $i = 0;
            foreach($innerjoin as $k=>$va){
                $this->db->join($k, ''.$k.'.'.$va.' = '.$tabla.'.'.$idunion[$i].'');
                $i++;
            }

        }
        //PETICION A TABLA
        $this->db->select($filas);
        if(is_array($where)){
            $this->db->where_in($key,$where);
        }
        $this->db->from($tabla);
        //CONSULTAR VOUCHER
        $query = $this->db->get();
        foreach($query->result() as $item){
            $string .= ' 
					<tr align="center">';
            foreach($filas as $v){
                $string .= '<td style="border:1px solid black;">'.utf8_decode($item->$v).'</td>';
            }
            $string .= '</tr>';
        }
        $string .= '</table>';
        return $string;
    }

    function exporexcfsj($titutlo,$filas,$campo,$fd,$fh,$tabla,$n,$area,$innerjoin,$idunion){

        $string = '
			<table>
				<tr>
					<td colspan="'.$n.'">
						<h1>REPORTE DE RANGO DE FECHAS '.$area.'</h1>
					</td>
				</tr>
				<tr>
					<td colspan="'.$n.'"></td>
				</tr>
				<tr>
					<td colspan="'.$n.'" align="right">
						<p><b>Fecha desde:</b> '.$fd.' / <b>Fecha Hasta:</b> '.$fh.'</p>
					</td>
				</tr>
				<tr>
					<td colspan="'.$n.'"></td>
				</tr>
				<tr>
					<td colspan="'.$n.'" align="right">
						<p><b>Fecha de reporte:</b> '.date('d/m/Y H:i').'</p>
					</td>
				</tr>
				<tr>
					<td colspan="'.$n.'"></td>
				</tr>
				<tr align="center" style="color:#FFFFFF;">';
        foreach($titutlo as $getvalor){
            $string .= '<td style="font-weight:bold;background-color:#1D68A6;border:1px solid black;vertical-align:middle;" rowspan="2">'.utf8_decode($getvalor).'</td>';
        }
        $string .= '
				</tr>
				<tr>
					<td colspan="'.$n.'"></td>
				</tr>
				';
        //UNIENDO TABLAS
        if(is_array($innerjoin)){
            $i = 0;
            foreach($innerjoin as $k=>$va){
                $this->db->join($k, ''.$k.'.'.$va.' = '.$tabla.'.'.$idunion[$i].'');
                $i++;
            }

        }
        //PETICION A TABLA
        $this->db->select($filas);
        $this->db->where(''.$campo.' >=',$fd);
        $this->db->where(''.$campo.' <=',$fh);
        $this->db->from($tabla);
        //CONSULTAR VOUCHER
        $query = $this->db->get();
        foreach($query->result() as $item){
            $string .= ' 
					<tr align="center">';
            foreach($filas as $v){
                $string .= '<td style="border:1px solid black;">'.utf8_decode(strtoupper($item->$v)).'</td>';
            }
            $string .= '</tr>';
        }
        $string .= '</table>';
        return $string;
    }


}