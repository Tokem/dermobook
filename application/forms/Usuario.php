<?php

class Application_Form_Usuario extends Zend_Form
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
        $nome = new Zend_Form_Element_Text('cli_nome');
        $nome->setLabel('Nome:')
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
        $senha->setLabel('Senha:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->setAttrib('class', 'form-control');
        
        
        $repetir = new Zend_Form_Element_Password('repeat-password');
        $repetir->setLabel('Repetir a senha:')
                ->setRequired(true)
                ->addFilter($stripTags)
                ->addFilter($trim)
                ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                ->addValidator('identical', true, array('cli_senha'))
                ->setIgnore(true)
                ->setAttrib('class', 'form-control');
        
       $permissao = $this->createElement('select', 'cli_permissao', array(
            'label' => 'Permissão:',
            'required' => true,'class'=>'form-control',
            'multiOptions' => array(''=>'selecione a permissão','administrador'=>'Administrador','operador'=>'Operador','social'=>'Social'),
        ));
       
        $ativo = new Zend_Form_Element_Hidden('cli_ativo');
        $ativo->addFilter($stripTags)
                  ->addFilter($trim)->setValue(1);
        $tipo = new Zend_Form_Element_Hidden('cli_tipo');
        $tipo->addFilter($stripTags)
                  ->addFilter($trim)->setValue(1);
        
        $submit = new Zend_Form_Element_Button('btn-usuario');
        $submit->setLabel('Cadastrar Usuário')
                ->setIgnore(true)
                ->setAttrib('type','submit')
                ->setAttrib('class','btn btn-primary btn-lg')
                ->setAttrib("data-loading-text", "Verifique o campo email!")
                ->setAttrib("data-complete-text", "Cadastrar Usuário");
        
        
        $this->setAttrib('id','form-usuario');
        
        $this->addElements(array(
            $nome,
            $email,
            $telefone,
            $senha,
            $repetir,
            $permissao,
            $ativo,
            $tipo,
            $submit,
        ));
    }



}

