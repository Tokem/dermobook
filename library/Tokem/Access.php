<?php

class Tokem_Access
{
       
    public function  permissions(){
        
          /*Adiciona os papeis */ 
        $acl = new Zend_Acl();
        $acl->addRole(new Zend_Acl_Role('administrador'));   
        $acl->addRole(new Zend_Acl_Role('usuario'));
        $acl->addRole(new Zend_Acl_Role('cliente'));
        
        /*Adicionaos recursos ou paginas que podem ser vistas*/
        $acl->addResource('index')
        ->addResource('usuario')
        ->addResource('cliente')
        ->addResource('financeiro')
        ->addResource('frequencia')
        ->addResource('tratamento');
        
        //$acl->deny('administrador','cliente','operador');
        
        try {
            //$acl->allow(array('administrador','operador','cliente','social'));
            $acl->allow('administrador',array('usuario','cliente','index','tratamento','financeiro','frequencia'));
            $acl->allow('usuario',array('cliente','index','tratamento','financeiro','frequencia'));
            $acl->allow('cliente',array('cliente','tratamento','frequencia'));
            
        } catch (Exception $exc) {
            echo "<pre>".$exc->getMessage()."</pre>";
        }
        
       Zend_Registry::set('acl', $acl);
        
    }
   
}
