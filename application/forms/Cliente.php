<?php

class Application_Form_Cliente extends Zend_Form
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
        
        /*Elementos do formulario*/
        $nome = new Zend_Form_Element_Text('cli_nome');
        $nome->setLabel('Nome:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');
        
        $idade = new Zend_Form_Element_Text('cli_idade');
        $idade->setLabel('Idade:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->setAttrib('class', 'form-control');

        $datanasc = new Zend_Form_Element_Text('cli_data_nasc');
        $datanasc->setLabel('Data Nasc:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

        $profissao = new Zend_Form_Element_Text('cli_profissao');
        $profissao->setLabel('Profissão:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');

        $cpf = new Zend_Form_Element_Text('cli_cpf');
        $cpf->setLabel('CPF:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control');
     
        
        $email = new Zend_Form_Element_Text('cli_email');
        $email->setLabel('Email')
              ->setRequired(true)
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->addValidator($validarEmail)
              ->setAttrib('class', 'form-control');
        
        $telefone = new Zend_Form_Element_Text('cli_telefone');
        $telefone->setLabel('Telefone')
              ->setRequired(true)
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->setAttrib('class', 'form-control');
        
        $senha = new Zend_Form_Element_Password('cli_senha');
        $senha->setLabel('Password:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');
        
        
        $repetir = new Zend_Form_Element_Password('repeat-password');
        $repetir->setLabel('Repeat password:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->addValidator('identical', true, array('cli_senha'))
                ->setIgnore(true)
                ->setAttrib('class', 'form-control');
       
        $anotacoes = new Zend_Form_Element_Textarea('cli_anotacao');
        $anotacoes->setLabel('Anotações:')
             ->setRequired(false)
             ->setAttrib('COLS', '180')
             ->setAttrib('ROWS', '4')     
             ->addValidator($validarTamanho)
             ->setAttrib('class', 'form-control cleditor');
        
        
       
        $ativo = new Zend_Form_Element_Hidden('cli_ativo');
        $ativo->addFilter($stripTags)
                  ->addFilter($trim)->setValue(1);


        $permissao = new Zend_Form_Element_Hidden('cli_permissao');
        $permissao->addFilter($stripTags)
                  ->addFilter($trim)->setValue("cliente");         

        
        $tipo = new Zend_Form_Element_Hidden('cli_tipo');
        $tipo->addFilter($stripTags)
                  ->addFilter($trim)->setValue(2);
        
        $permissao = new Zend_Form_Element_Hidden('cli_permissao');
        $permissao->addFilter($stripTags)
                  ->addFilter($trim)->setValue("cliente");

        $indicacao = $this->createElement('select', 'cli_indicacao', array(
            'label' => 'Como conheceu?',
            'required' => true,'class'=>'form-control',
            'multiOptions' => array(
                ''=>'selecione a opção',
                'Google'=>'Google',
                'Instagram'=>'Instagram',
                'Facebook'=>'Facebook',
                'Amigo'=>'Amigo',
                'SMS'=>'SMS',
                'Email'=>'Email'),

        ));           
       
        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setLabel('Enviar Dados')
                ->setIgnore(true)
                ->setAttrib('class','btn btn-info');
        
        $this->setAttrib('id','form-usuario');
        
        $this->addElements(array(
            $indicacao,
            $nome,
            $idade,
            $datanasc,
            $profissao,
            $email,
            $cpf,
            $telefone,
            $senha,
            $repetir,
            $anotacoes,
            $ativo,
            $permissao,
            $tipo,
            $submit,
        ));
    }


}

