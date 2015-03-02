<?php

class Application_Form_Sensibilidade extends Zend_Form
{

    public function init()
    {
         /*validadores*/
        $validarTamanho = new Zend_Validate_StringLength(4,100);
        $validarEmail = new Zend_Validate_EmailAddress();
        
        /*filtros*/
        $stripTags =  new Zend_Filter_StripTags();
        $trim = new Zend_Filter_StringTrim();
        
        

        $tatil= new Zend_Form_Element_Text('sen_tatil: ');
        $tatil->setLabel('Tátil:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');

        $termica= new Zend_Form_Element_Text('sen_termica');
        $termica->setLabel('Térmica:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');


        $dolorosa= new Zend_Form_Element_Text('sen_dolorosa');
        $dolorosa->setLabel('dolorosa: ')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');
                

        $consideracoes = new Zend_Form_Element_Textarea('sen_consideracoes');
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

        $this->setAttrib('id','form-perimetria');
        
        $this->addElements(array(
            $tatil,
            $termica,
            $dolorosa,
            $consideracoes,
            $submit,
        ));
    }



}

