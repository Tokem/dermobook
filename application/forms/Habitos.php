<?php

class Application_Form_Habitos extends Zend_Form
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
        
        
       

    
        $fumo = new Zend_Form_Element_Text('hab_fumo');
        $fumo->setLabel('Fumo:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');     


        $bebida = new Zend_Form_Element_Text('hab_bebida_alcoolica');
        $bebida->setLabel('Bebida Alcoólica:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');     
             

        $atividade = new Zend_Form_Element_Text('hab_atividade_fisica');
        $atividade->setLabel('Atividade Física:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

        $alimentacao = new Zend_Form_Element_Text('hab_alimentacao');
        $alimentacao->setLabel('Alimentação:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

        $liquidos = new Zend_Form_Element_Text('hab_ingestao_de_liguidos');
        $liquidos->setLabel('Ingestão de Líquidos:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');


        $sono = new Zend_Form_Element_Text('hab_sono');
        $sono->setLabel('Sono:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');              

        
        $considerações = new Zend_Form_Element_Textarea('hab_consideracoes');
        $considerações->setLabel('Considerações:')
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
        
        $this->setAttrib('id','form-usuario');
        
        $this->addElements(array(
            $fumo,
            $bebida,
            $atividade,
            $alimentacao,
            $liquidos,
            $sono,
            $considerações,
            $submit,
        ));
    }


}