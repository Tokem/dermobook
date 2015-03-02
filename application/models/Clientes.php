<?php

class Application_Model_Clientes extends Zend_Db_Table
{
    protected $_name = "dermo_clientes";
    protected $_primary = "cli_codigo";
    
    
    
    function findByEmail($email) {
        
         $db = $this->getDefaultAdapter();
        
         $select  = $db->select()->distinct()
                  ->from(array('cli'=>'dermo_clientes'),array('cli_email'))
                  ->where("cli_email LIKE '%$email%'");
         
         return $cliente =  $db->fetchRow($select);
    }
    
}

