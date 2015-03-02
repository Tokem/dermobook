<?php

class Application_Model_Tratamento extends Zend_Db_Table
{
    protected $_name = "dermo_tratamento";
    protected $_primary = "tra_id";
    


     public function getAll($id){
    	$db = $this->getDefaultAdapter();
        
        $lista = $db->select()->from(array('tr' => 'dermo_tratamento'))
        	     ->distinct()
			     ->join(array('trp' => 'dermo_tratamento_pacientes'),'tr.tra_id = trp.tra_codigo_fk')
			     ->where("trp.cli_codigo_fk=$id")
                 ->order(array('tr.tra_id DESC'));;
			     // ->query()->fetchAll();    

		// echo $lista;		     
		// exit;
        return $tratamento =  $db->fetchAll($lista);
    }

    
}

