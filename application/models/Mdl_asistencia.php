<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdl_asistencia extends CI_Model
{
	public function validar_registro($usuario,$fecha){
        $this->db->select('*');
        $this->db->from('tb_asistencia');
        $this->db->where('usuario', $usuario);
        $this->db->where('date(fecha_ingreso)', $fecha);
        $query = $this->db->get();
        $num_fila = $query->num_rows();
        return $num_fila;
    }
    public function obtener_registros($usuario,$fecha){
        $this->db->select('*');
        $this->db->from('tb_asistencia');
        $this->db->where('usuario', $usuario);
        $this->db->where('date(fecha_ingreso)', $fecha);
        $query = $this->db->get();
        $num_fila = $query->num_rows();
        if($num_fila > 0){
            $retorno = $query->result();
        }else{
            $retorno = 'error';
        }
        return $retorno;
    }

    function actualizarFechaSalida($idregistro,$array){
        $this->db->where('id_asistencia', $idregistro);
        return $this->db->update('tb_asistencia', $array);
    }
}