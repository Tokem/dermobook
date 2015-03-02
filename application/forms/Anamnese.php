<?php

class Application_Form_Anamnese extends Zend_Form
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
        
        
       
        $queixa = new Zend_Form_Element_Textarea('ana_queixa_principal');
        $queixa->setLabel('Queixa Princinpal:')
             ->setRequired(false)
             ->setAttrib('COLS', '180')
             ->setAttrib('ROWS', '4')     
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');

        $diagnosticoCli = new Zend_Form_Element_Textarea('ana_diagnostico_clinico');
        $diagnosticoCli->setLabel('Diagnostico Clínico:')
             ->setRequired(false)
             ->setAttrib('COLS', '180')
             ->setAttrib('ROWS', '4')     
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');

        
        $diagnosticoCin = new Zend_Form_Element_Textarea('ana_diagnostico_cinetico_funcional');
        $diagnosticoCin->setLabel('Diagnostico cinetico funcional:')
             ->setRequired(false)
             ->setAttrib('COLS', '180')
             ->setAttrib('ROWS', '4')     
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');

        /*Elementos do formulario*/
        $hda = new Zend_Form_Element_Text('ana_hda');
        $hda->setLabel('HDA:')
             ->setRequired(true)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');     

        $hda = new Zend_Form_Element_Text('ana_hda');
        $hda->setLabel('HDA:')
             ->setRequired(true)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');          

        $hf = new Zend_Form_Element_Text('ana_hf');
        $hf->setLabel('HF:')
             ->setRequired(true)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');               

        $medico = new Zend_Form_Element_Text('ana_medico_responsavel');
        $medico->setLabel('Médico Responsável:')
             ->setRequired(true)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control'); 

    
        $peso = new Zend_Form_Element_Text('ana_peso');
        $peso->setLabel('Peso:')
             ->setRequired(true)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');     

        $consideracoes = new Zend_Form_Element_Textarea('ana_consideracoes');
        $consideracoes->setLabel('Considerações:')
             ->setRequired(false)
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
            $queixa,
            $diagnosticoCli,
            $diagnosticoCin,
            $hda,
            $hf,
            $medico,
            $peso,
            $consideracoes,
            $submit,
        ));
    }


}