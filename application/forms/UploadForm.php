<?php

class Application_Form_UploadForm extends Zend_Form
{

    public function init()
    {
        // File Input
        $file = new Zend_Form_Element_File('image-file');
        $file->setAttrib('id', 'image-file')
             ->setAttrib('class', 'file');

        $this->setAttrib('enctype', "multipart/form-data");
        $this->setAttrib('id', "form-perfil-image");


        $this->addElement($file);

    }
}