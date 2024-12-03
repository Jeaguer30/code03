<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_exportar extends CI_Model
{   


    
    

    /*
    function formatearFecha($fecha) {
   
        $date = new DateTime($fecha);

        $anio = $date->format('Y');
        $dia = $date->format('d');
        $mes = $date->format('n');

    
        $meses = array(
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        );

        
        return $dia . ' de ' . $meses[$mes] . ' del ' . $anio;
    }*/



    

    function exportar_data_make_query1() {
        
        $celda_header = 'height:45px; font-weight:bold; border:1px solid white; text-align: center; vertical-align:middle;';
        $celda_body = 'text-align: center; vertical-align:middle; height:40px;';
        $celda_body_start = 'vertical-align:middle; height:40px;';
    
        $string = '<table>';

        $string .= '<tr align="center" style="color:black;">';      
            $string .= '<td style="background-color:#ACB9CA;' . $celda_header . '" colspan="17">' . utf8_decode('INFORMACIÓN DEl CLIENTE') . '</td>';
            $string .= '<td style="background-color:#B4C6E7;' . $celda_header . '" colspan="5">' . utf8_decode('INFORMACIÓN DE LA SOLICITUD') . '</td>';
        $string .= '</tr>';

        $string.='  <tr align="center" style="color:black;">';    

            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('NRO').'</td>';
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('RAZON SOCIAL').'</td>'; 
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('STATUS').'</td>'; 
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('RUC').'</td>';
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('CODIGO ISCOM').'</td>';   

            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('CUENTA SD').'</td>';  
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('MES DEUDA').'</td>';     
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('NRO DIAS PAGO').'</td>';  
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('OSINERGMIN').'</td>';
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('DISTRIBUIDOR LOCAL').'</td>';  

            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('NRO SUMINISTRO DISTRITO').'</td>';  
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('ALIMENTADOR').'</td>';
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('PMI').'</td>';
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('DIRECCION SUMINISTRO').'</td>';

            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('DISTRITO').'</td>';  
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('PROVINCIA').'</td>';  
            $string .= '<td style="background-color:#8497B0;'.$celda_header.'" rowspan="1">'.utf8_decode('DEPARTAMENTO').'</td>';



            $string .= '<td style="background-color:#8EA9DB;'.$celda_header.'" rowspan="1">'.utf8_decode('ESTADO DE SOLICITUD').'</td>';
            $string .= '<td style="background-color:#8EA9DB;'.$celda_header.'" rowspan="1">'.utf8_decode('RESUMEN BREVE').'</td>';
            $string .= '<td style="background-color:#8EA9DB;'.$celda_header.'" rowspan="1">'.utf8_decode('FECHA REGISTRO').'</td>';
            $string .= '<td style="background-color:#8EA9DB;'.$celda_header.'" rowspan="1">'.utf8_decode('USUARIO DE TELEOPERADOR').'</td>';
            $string .= '<td style="background-color:#8EA9DB;'.$celda_header.'" rowspan="1">'.utf8_decode('TELEOPERADOR').'</td>';
        $string .= '</tr>';
    
    
        $this->db->select('a.*,b.*,c.descripcion as estado_solicitud, d.nombres, d.apellidos, d.usuario');
        $this->db->from('cvc_solicitudes a');
        $this->db->join('cvc_clientes_libres b', 'a.id_cliente = b.id', 'LEFT');
        $this->db->join('cvc_estado_solicitud c', 'a.id_estado_solicitud = c.id', 'LEFT');
        $this->db->join('tb_usuarios d', 'a.id_usuario = d.coduser', 'LEFT');
        $this->db->where('a.del', 0);
        $this->db->order_by('a.f_registro', 'desc');
        $query = $this->db->get();

    
        if ($query->num_rows() > 0) {
            $resultado = $query->result();
            $contador = 0;
            foreach ($resultado as $key) {
                $contador++;

                $string .= '<tr>';     

                    $string .= '<td style="' . $celda_body . '">' . $contador . '</td>';                  
                    $string .= '<td style="' . $celda_body . '">'.utf8_decode($key->razon_social).'</td>';
                    $string .= '<td style="' . $celda_body . '">'.utf8_decode($key->status).'</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->ruc . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->codigo_iscom . '</td>';

                    $string .= '<td style="' . $celda_body . '">' . $key->cuenta_sd . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->mes_deuda . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->nro_dias_pago . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->osinergmin . '</td>';
                    $string .= '<td style="' . $celda_body . '">'.utf8_decode($key->distribuidor_local).'</td>';

                    $string .= '<td style="' . $celda_body . '">' . $key->nro_suministro_distri . '</td>';
                    $string .= '<td style="' . $celda_body . '">'.utf8_decode($key->alimentador).'</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->pmi . '</td>';
                    $string .= '<td style="' . $celda_body . '">'.utf8_decode($key->direccion_suministro).'</td>';
             

                    $string .= '<td style="' . $celda_body . '">' . $key->distrito . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->provincia . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->departamento . '</td>';


                    $string .= '<td style="' . $celda_body . '">' . $key->estado_solicitud . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->resumen_breve . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->f_registro . '</td>';
                    $string .= '<td style="' . $celda_body . '">' . $key->id_usuario . '</td>';
                    $string .= '<td style="' . $celda_body . '">'.utf8_decode($key->nombres).' '.utf8_decode($key->apellidos).'</td>';
                    
                $string .= '</tr>';
            }
        } else {     
            $string .= '<tr><td colspan="4">SIN RESULTADOS</td></tr>';
        }
    
        $string .= '</table>';
        return $string;
    }


    

}  