<?php

class Application_Form_Perimetria extends Zend_Form
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
        $busto = new Zend_Form_Element_Text('per_busto');
        $busto->setLabel('Busto:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');
        
        $cicatriz = new Zend_Form_Element_Text('per_cicatriz_umbilical');
        $cicatriz->setLabel('Cicatriz Umbilical')
              ->setRequired(true)
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->addValidator($validarEmail)
              ->setAttrib('class', 'form-control');
        
        $cintura = new Zend_Form_Element_Text('per_cintura');
        $cintura->setLabel('Cintura')
              ->setRequired(true)
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->setAttrib('class', 'form-control');
        
        $acima = new Zend_Form_Element_Text('per_5_cm_acima');
        $acima->setLabel('5 cm acima:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');                
        
        
        $gluteos = new Zend_Form_Element_Text('per_gluteos');
        $gluteos->setLabel('Glúteos:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control'); 


        $MSEbraco = new Zend_Form_Element_Text('per_mse_braco');
        $MSEbraco->setLabel('MSE braço:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');
                

        $MSEantebraco = new Zend_Form_Element_Text('per_mse_antebraco');
        $MSEantebraco->setLabel('MSE antebraço:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control'); 
                

        $MSDbraco  = new Zend_Form_Element_Text('per_msd_braco ');
        $MSDbraco ->setLabel('MSD braço :')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control'); 
                


        $MSDantebraco = new Zend_Form_Element_Text('per_msd_antebraco');
        $MSDantebraco->setLabel('MSD antebraço:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control'); 
                

        $MIEcoxa  = new Zend_Form_Element_Text('per_mie_coxa ');
        $MIEcoxa ->setLabel('MIE coxa :')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control'); 
                


        $MIEperna = new Zend_Form_Element_Text('per_mie_perna');
        $MIEperna->setLabel('MIE perna:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control'); 
                

        $MIDcoxa = new Zend_Form_Element_Text('per_mid_coxa');
        $MIDcoxa->setLabel('MID coxa:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');                                      
        

        $MIDperna = new Zend_Form_Element_Text('per_mid_perna');
        $MIDperna->setLabel('MID perna:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');


        $consideracoes = new Zend_Form_Element_Textarea('per_consideracoes');
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
            $busto,
            $cicatriz,
            $cintura,
            $acima,
            $gluteos,
            $MSEbraco,
            $MSEantebraco,
            $MSDbraco,
            $MSDantebraco,
            $MIEcoxa,
            $MIEperna,
            $MIDcoxa,
            $MIDperna,
            $consideracoes,
            $submit,
        ));
    }



}

