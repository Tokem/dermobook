<?php

class Application_Form_Tratamento extends Zend_Form
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

        $nome = new Zend_Form_Element_Select('tra_nome');
        $nome->setLabel('Tratamento:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->setAttrib('class', 'form-control');     

        $db = new Application_Model_NomeTratamento();
        foreach ($db->fetchAll() as $row) {
            $nome->addMultiOption($row['tra_nome'], $row['tra_nome']);
        }        

        $data = new Zend_Form_Element_Text('tra_data_avaliacao');
        $data->setLabel('Data avaliação:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');     


        $objetivo = new Zend_Form_Element_Text('tra_objetivo');
        $objetivo->setLabel('Objetivo:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

        $valor = new Zend_Form_Element_Text('tra_valor');
        $valor->setLabel('Valor:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');


        $pagamento = new Zend_Form_Element_Text('tra_forma_pagamento');
        $pagamento->setLabel('Forma de pagamento:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');


        $id = new Zend_Form_Element_Hidden('id');
            

        $sessoes = $this->createElement('select', 'tra_qtd_ini', array(
            'label' => 'Quantidade de sessões:',
            'required' => true,'class'=>'form-control',
            'multiOptions' => array(
              ''=>'selecione a quantidade',
              '1'=>'1',
              '2'=>'2',
              '3'=>'3',
              '4'=>'4',
              '5'=>'5',
              '6'=>'6',
              '7'=>'7',
              '8'=>'8',
              '9'=>'9',
              '10'=>'10',
              '11'=>'11',
              '12'=>'12',
              '13'=>'13',
              '14'=>'14',
              '15'=>'15',
              
              ),
        ));
        

        $consideracoes = new Zend_Form_Element_Textarea('tra_consideracoes');
        $consideracoes->setLabel('Considerações:')
             ->setRequired(false)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->setAttrib('COLS', '180')
             ->setAttrib('ROWS', '4')     
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');       
       
        
        $submit = new Zend_Form_Element_Button('btn-enviar');
        $submit->setLabel('Enviar Dados')
                ->setIgnore(true)
                ->setAttrib('type','submit')
                ->setAttrib('class','btn btn-primary btn-lg')
                ->setAttrib("data-complete-text", "Enviar Dados");
        
        
        $this->addElements(array(
            $nome,
            $data,
            $objetivo,
            $valor,
            $pagamento,
            $sessoes,
            $consideracoes,
            $id,
            $submit,
        ));
    }



}

