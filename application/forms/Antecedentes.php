<?php

class Application_Form_Antecedentes extends Zend_Form
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
        
        $anticoncepcionais = new Zend_Form_Element_Radio('ant_anticoncepcionais_hormonais');
        $anticoncepcionais->setLabel('Anticoncepcionais Hormonais')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não'));


        $tratamento = new Zend_Form_Element_Radio('ant_tratamento_medico');
        $tratamento->setLabel('Tratamento Médico')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não'));

       
        $antecedentesCirurgicos = new Zend_Form_Element_Radio('ant_antecedentes_cirurgicos');
        $antecedentesCirurgicos->setLabel('Antecedentes Cirurgicos')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não'));

        $gestante = new Zend_Form_Element_Radio('ant_gestate');
        $gestante->setLabel('Gestante')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 

        $alergia = new Zend_Form_Element_Radio('ant_alergias');
        $alergia->setLabel('Alergia')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 

        $alteracoesDermatologicas = new Zend_Form_Element_Radio('ant_alteracoes_dermatologicas');
        $alteracoesDermatologicas->setLabel('Alterações Dermatologicas:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 


        $alteracoesNeurologicas = new Zend_Form_Element_Radio('ant_alteracoes_neurologicas');
        $alteracoesNeurologicas->setLabel('Alterações Neurológicas:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 


        $alteracoesRespiratorias = new Zend_Form_Element_Radio('ant_alteracoes_respiratorias');
        $alteracoesRespiratorias->setLabel('Alterações Respiratorias:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não'));

        $alteracoesUrinarias = new Zend_Form_Element_Radio('ant_alteracoes_urinarias');
        $alteracoesUrinarias->setLabel('Alterações Urinarias:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 

        $neoplasias = new Zend_Form_Element_Radio('ant_neoplasias');
        $neoplasias->setLabel('Neoplasias:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 


        $diabetes = new Zend_Form_Element_Radio('ant_diabetes');
        $diabetes->setLabel('Diabetes:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 



        $epilepsia = new Zend_Form_Element_Radio('ant_epilepsia');
        $epilepsia->setLabel('Epilepsia:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 



        $hipertensao = new Zend_Form_Element_Radio('ant_hipertensao');
        $hipertensao->setLabel('Hipertensão:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 


        $cicloMestrual = new Zend_Form_Element_Radio('ant_ciclo_menstrual_regular');
        $cicloMestrual->setLabel('Ciclco Mestrual Regular:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 

        $varizes = new Zend_Form_Element_Radio('ant_varizes');
        $varizes->setLabel('Varizes:')
        ->setSeparator('')
        ->setMultiOptions(array('1'=>'Sim','0'=>'Não')); 


        $considerações = new Zend_Form_Element_Textarea('ant_consideracoes');
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
            $anticoncepcionais,
            $tratamento,
            $antecedentesCirurgicos,
            $gestante,
            $alergia,
            $alteracoesDermatologicas,
            $alteracoesNeurologicas,
            $alteracoesRespiratorias,
            $alteracoesUrinarias,
            $neoplasias,
            $diabetes,
            $epilepsia,
            $hipertensao,
            $cicloMestrual,
            $varizes,
            $considerações,
            $submit,
        ));
    }


}