<?php

class Application_Form_NomeTratamento extends Zend_Form
{

    public function init()
    {
         /*validadores*/
        $validarTamanho = new Zend_Validate_StringLength(4,100);
        $validarEmail = new Zend_Validate_EmailAddress();
        
        /*filtros*/
        $stripTags =  new Zend_Filter_StripTags();
        $trim = new Zend_Filter_StringTrim();
        
        /*Elementos do formulario*/
        $nome = new Zend_Form_Element_Text('tra_nome');
        $nome->setLabel('Nome do Tratamento:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

   
        
        $submit = new Zend_Form_Element_Button('btn-enviar');
        $submit->setLabel('Enviar Dados')
                ->setIgnore(true)
                ->setAttrib('type','submit')
                ->setAttrib('class','btn btn-primary btn-lg')
                ->setAttrib("data-complete-text", "Enviar Dados");
        
        
        $this->addElements(array(
            $nome,
            $submit,
        ));
    }



}

