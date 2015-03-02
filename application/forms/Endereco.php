<?php

class Application_Form_Endereco extends Zend_Form
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
       
        $logradouro = new Zend_Form_Element_Text('end_logradouro');
        $logradouro->setLabel('Endereço:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');


        $numero = new Zend_Form_Element_Text('end_numero');
        $numero->setLabel('Numero:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');               



        $bairro = new Zend_Form_Element_Text('end_bairro');
        $bairro->setLabel('Bairro:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');         
        

        $cidade = new Zend_Form_Element_Text('end_cidade');
        $cidade->setLabel('Cidade:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

        $estado = new Zend_Form_Element_Text('end_estado');
        $estado->setLabel('Estado:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

        $cep = new Zend_Form_Element_Text('end_cep');
        $cep->setLabel('Cep:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');                    
        
        $complemento = new Zend_Form_Element_Text('end_complemento');
        $complemento->setLabel('Complemento:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');          


        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setLabel('Enviar Dados')
                ->setIgnore(true)
                ->setAttrib('class','btn btn-info');
        
        $this->setAttrib('id','form-usuario');
        
        $this->addElements(array(
            $cep,
            $logradouro,
            $numero,
            $bairro,
            $cidade,
            $estado,
            $complemento,
            $submit,
        ));
    }


}