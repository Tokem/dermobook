<?php

class Application_Form_Inspecao extends Zend_Form
{

    public function init()
    {
         /*validadores*/
        $validarTamanho = new Zend_Validate_StringLength(4,100);
        $validarEmail = new Zend_Validate_EmailAddress();
        $validarUrl = new Zend_Validate_Hostname();
        
        /*filtros*/
        $stripTags =  new Zend_Filter_StripTags();
        $trim = new Zend_Filter_StringTrim();
        
        
        $consideracoes = new Zend_Form_Element_Textarea('ins_consideracoes');
        $consideracoes->setLabel('Considerações:')
             ->setRequired(false)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->setAttrib('COLS', '180')
             ->setAttrib('ROWS', '4')     
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');
       

    
        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setLabel('Enviar Dados')
                ->setIgnore(true)
                ->setAttrib('class','btn btn-info');       

        
        $this->addElements(array(
            $consideracoes,
            $submit,
        ));
    }


}