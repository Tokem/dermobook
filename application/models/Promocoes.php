<?php

class Application_Model_Promocoes extends Zend_Db_Table
{
    protected $_name = "dermo_promocoes";
    protected $_primary = "pro_id";



    public function getAll(){

    	$db = $this->getDefaultAdapter();
        
        $lista = $db->select()->from(array('pro' => 'dermo_promocoes'))
        	     ->distinct()
                 ->order('RAND()')
                 ->limit(1);

        return $return =  $db->fetchAll($lista);
    }
}

