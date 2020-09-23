<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remitos extends CI_Model {

	function __construct()
	{
        parent::__construct();
	}
	
    function getRemitosList()
    {
        $empresaId = empresa();

        $this->db->select('T.rema_id as remitoId, T.fecha, T.comprobante, A.prov_id as provid,  A.nombre as provnombre');
        $this->db->from('alm.alm_recepcion_materiales as T');
        $this->db->join('alm.alm_proveedores A','T.prov_id = A.prov_id');
        $this->db->where('T.empr_id', $empresaId);
        $query = $this->db->get();
        if( $query->num_rows() > 0)
        {
            $data['data']   = $query->result_array();  
            return $data;
        } 
        else {
            return false;
        }
    }

    function getcodigo()
    {
        $this->db->select('T.arti_id as artId, T.barcode as artBarCode, T.descripcion as artDescription,T.es_loteado, T.es_caja, T.cantidad_caja');
        $this->db->from('alm.alm_articulos as T');
        $this->db->where('empr_id', empresa());
        $this->db->where('T.eliminado',false);
     
    	$query = $this->db->get();

		if($query->num_rows()>0)
        {
	       return $query->result();
	    }
	    else
        {
	       return false;
	    }
	}

    function getdeposito()
    {
        $empresaId = empresa();
     
        $query = $this->db->get_where('alm.alm_depositos', array('empr_id' => $empresaId));
            if($query->num_rows()>0){
            return $query->result();
        }
        else{
            return false;
        }
    }

	function getproveedor()
    {
        $empresaId = empresa();
		$query     = $this->db->get_where('alm.alm_proveedores', array('empr_id' => $empresaId));
			if($query->num_rows()>0){
	   	 	return $query->result();
	    }
	    else{
	    	return false;
	    }
	}
	
	function getdescrip($data = null)
    {
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['artId'];
			//Datos del usuario
			$query = $this->db->get_where('alm.alm_articulos', array('arti_id' => $id));
			if($query->num_rows()>0){
                return $query->result();
            }
            else{
                return false;
            }
		}
	}

    function getConsulta($id) 
    {
        $this->db->select('alm.alm_recepcion_materiales.comprobante, alm.alm_recepcion_materiales.fecha, alm.alm_proveedores.nombre as provnombre');
        $this->db->from('alm.alm_recepcion_materiales');
        $this->db->join('alm.alm_proveedores', 'alm.alm_proveedores.prov_id = alm.alm_recepcion_materiales.prov_id'); 
        $this->db->where('alm.alm_recepcion_materiales.rema_id', $id);
        $query= $this->db->get();   

        if ($query->num_rows()!=0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    function getDetaRemitos($idRemito)
    {
        $empresaId = empresa();
        
        $sql = "SELECT T.dere_id as detaremitoid, T.rema_id as id_remito, T.lote_id as loteid, T.cantidad, 
            art.barcode as codigo, alm.alm_lotes.depo_id as depositoid, 
            art.arti_id as artId, art.barcode as artBarCode, art.descripcion as artDescription, 
            alm.alm_depositos.descripcion as depositodescrip
            FROM alm.alm_deta_recepcion_materiales as T
            JOIN alm.alm_lotes ON alm.alm_lotes.lote_id = T.lote_id
            JOIN alm.alm_articulos art ON art.arti_id = alm.alm_lotes.arti_id
            JOIN alm.alm_depositos ON alm.alm_depositos.depo_id = alm.alm_lotes.depo_id
            WHERE T.rema_id = $idRemito
            AND art.empr_id = $empresaId
            ";

        $query = $this->db->query($sql);
        if( $query->num_rows() > 0)
        {
            return $query->result_array();  
        } 
        else {
            return 0;
        }
    }

    function alerta($codigo,$de)
    {
        //arriba es artId, prodId
        $empresaId = empresa();

        $sql       = "SELECT  alm.alm_lotes.cantidad
            FROM alm.alm_lotes
            WHERE alm.alm_lotes.id_empresa = $empresaId
            AND alm.alm_lotes.artId        = $codigo 
            AND alm.alm_lotes.depositoid   = $de 
            AND alm.alm_lotes.lotestado    = 'AC'
        ";
        $query = $this->db->query($sql);
        foreach($query->result() as $row)
        {   
            $datos = $row->cantidad;
        }
        return $datos;
    }

	function getlote($idHerramienta,$idDeposito)
    {
        $empresaId = empresa();

        $sql       = "SELECT alm.alm_lotes.lote_id as loteid
    		FROM alm.alm_lotes
            WHERE alm.alm_lotes.id_empresa = $empresaId
            AND alm.alm_lotes.artId        = $idHerramienta 
            AND alm.alm_lotes.depositoid   = $idDeposito";
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }	
	}

    function insert_orden($data)
    {
        $data['empr_id'] =empresa();
        $data['prov_id']  = $data['provid'];unset($data['provid']);

        $this->db->insert("alm.alm_recepcion_materiales", $data);

        return $this->db->insert_id();
    }

    /**
     * @param   Int     $ultimoId   id del remito insertado.
     * @param   Int     $co         cantidad
     * @param   Int     $dep        id de deposito
     * @param   Array   $indice     ids de insumos
     * @param   Array   $ar         id de articulos
     */
    function detaorden($ultimoId,$lote,$co,$dep,$indice,$list_art,$prov_id)
    {
    	$i = 0;
    	
    	foreach ($indice as $row) {
    		if(isset($list_art[$row])){
    			if($dep[$row]){
                    $a   = $list_art[$row];                 
                    $d   = $dep[$row];                
                    $res = $lote[$row];
    				
    				if($res > 0){ //si tiene id de lote
    					if($co[$row]){ //cant
    						$datos2 = array(
                             'rema_id' => $ultimoId, 
                             'lote_id'    => $res,
                             'cantidad'  => $co[$row]
    		        		);
        		        
        		        	$result = $this->insert_detaremito($datos2);
        		        
    					}
    					$this->sumarlote($res,$co[$row]);
    				}
    				else {
                        $cod    = $this->traercodigoart($list_art[$row]);
                        $datos3 = array(
                            'codigo'     => $cod,		
                            'fecha'      => date("Y-m-d H:i:s"),
                            'cantidad'   => $co[$row],
                            'arti_id'      => $list_art[$row],  //artId arriba/ local prodId 
                            'prov_id' =>$prov_id,
                            'estado_id'  => '1',
                            'depo_id' => $dep[$row]
    						);
    					$this->insert_lote($datos3); //inserta en lote
                        $ultimolote = $this->db->insert_id();
                        
                        $datos2     = array(
                            'rema_id' => $ultimoId, 
                            'lote_id'    => $ultimolote,
                            'cantidad'  => $co[$row]
    		        	);
    					$result = $this->insert_detaremito($datos2); //inserta en detaremito
    				}
    			}
    		}
    	$i++;
    	}
    	return $result ;
    }

    function loteres($idArticulo,$idDeposito)
    {
        $empresaId = empresa();

        $sql       = "SELECT alm.alm_lotes.lote_id as loteid
            FROM alm.alm_lotes
            WHERE alm.alm_lotes.empr_id = $empresaId
            AND alm.alm_lotes.arti_id        = $idArticulo 
            AND alm.alm_lotes.depo_id   = $idDeposito
            ";
        $query = $this->db->query($sql);
        if($query->result()){
            foreach ($query->result() as $row){       
                $datos = $row->loteid;     
            }
            return $datos;
        }
        else 
        {
            return 0;
        }   
    }

    function insert_detaremito($data2)
    {
        $data2['empr_id'] = empresa();

        $query = $this->db->insert("alm.alm_deta_recepcion_materiales", $data2);
        return $query;
    }

    function sumarlote($res,$co)
    {
        $sql = "SELECT alm.alm_lotes.cantidad
            FROM alm.alm_lotes
            WHERE alm.alm_lotes.lote_id = $res";
        $query = $this->db->query($sql); //aca esta la canidad
        foreach ($query->result() as $row)
        {         
            $datos = $row->cantidad;     
        }
        $re = $datos + $co;
       
        $this->updatelote($re,$res);
        return $re; 
    }

    function updatelote($re,$res)
    {
        $sql = "UPDATE alm.alm_lotes 
            SET alm.alm_lotes.cantidad = $re 
            WHERE alm.alm_lotes.lote_id = $res
            ";
        $query = $this->db->query($sql);
         return $query;
    }

    function traercodigoart($d)
    {
        //artId
        $sql = "SELECT barcode as artBarCode
            FROM  alm.alm_articulos
            WHERE alm.alm_articulos.arti_id = $d
        ";
        $query = $this->db->query($sql);
        if($query->result() ){
            foreach ($query->result() as $row){     
                $datos = $row->artBarCode;//artDescription;     
            } 
        return $datos;
        }
        else 
        {
            return 0;
        }
    }

    function insert_lote($data3)
    {
        $data3['empr_id'] = empresa();
        $query   = $this->db->insert("alm.alm_lotes",$data3);
        return $query;
    }


    function getsolicitante(){
    	$query= $this->db->get_where('solicitud_reparacion');
    		if($query->num_rows()>0){
       	 	return $query->result();
        }
        else{
        	return false;
        }
    }

    function getlotecant($id){
    	$sql="SELECT  alm.alm_lotes.cantidad
    	FROM alm.alm_lotes
    	WHERE alm.alm_lotes.depositoid=$id AND alm.alm_lotes.lotestado='AC'
    	";
    	$query= $this->db->query($sql);
    	/*if($query->num_rows()>0){
    	   	 	return $query->result();
    	    }
    	    else{
    	    	return false;
    	    }*/
    	$i=0;
                   foreach ($query->result_array() as $row)
                   {   
                       
                       $datos[$i]= $row['cantidad'];
                       $i++;
                   }
    	    return $datos;
    }

    function lote($val,$co,$d){
    	if ($val!=0) {
    	 	$cant= $this->lotecantidad($val); //obtengo la cantidad segun el lote
    	 	print_r($cant);
    	}
    	if ($cant >=$co) {
    		$res=$cant - $co;
    	}	
    	else {
    		echo  "No hay insumos suficientes"; 
    		//$res=$co - $cant;
    	}	
    	$datos3 = array(	        			
    		'cantidad'=>$res
    	);		        	
    	print_r($datos3);	        	
    	$this->update_tbllote($val,$datos3);
    }

    function lotecantidad($v){
    	$sql="SELECT  alm.alm_lotes.cantidad
    			FROM alm.alm_lotes
    			WHERE alm.alm_lotes.lote_id as loteid=$v";
    	$query= $this->db->query($sql);
      	foreach ($query->result() as $row){     
            $datos= $row->cantidad;   
        }
        return $datos;
    }

    function update_tbllote($id,$data3){
        $this->db->where('loteid', $id);
        $query = $this->db->update("alm.alm_lotes",$data3);
        return $query;
    }

    public function guardar_detalles($id, $detalles)
    {
        foreach ($detalles as $o) {
            $o['empr_id'] = empresa();
            $o['lote_id'] = $this->verificar_lote($o);
            $o['rema_id'] = $id;
            unset($o['codigo']);unset($o['depo_id']);unset($o['fec_vencimiento']);unset($o['loteado']);
            $this->db->insert('alm.alm_deta_recepcion_materiales', $o);
        };

        return true;
    }

    public function verificar_lote($data)
    {
        //? SI EXISTE LOTE RETORNA ID

        if($data['loteado'] == 1){

            $this->db->where('depo_id', $data['depo_id']);
            $this->db->where('codigo', $data['codigo']);

        }else{
            
            $this->db->where('depo_id', $data['depo_id']);
            $this->db->where('arti_id', $data['arti_id']);
            $data['codigo'] = 1;
        }
        
        $res =  $this->db->get('alm.alm_lotes')->row();

        //? SI EXISTE LOTE LO ACTUALIZA
        if($res){ $this->actualizar_lote($res->lote_id, $data); return $res->lote_id;}

        //? SI NO EXISTE LOTE LO CREA
        unset($data['loteado']);

        $this->insert_lote($data);

        return $this->db->insert_id();
    }

    public function actualizar_lote($id, $data)
    {
        $this->db->where('lote_id', $id);
        $this->db->set('cantidad','cantidad +'.$data['cantidad'], false);
        return $this->db->update('alm.alm_lotes');
    }

}