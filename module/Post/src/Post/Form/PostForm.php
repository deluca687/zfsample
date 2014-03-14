<?php
namespace Post\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('post');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'content',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-default',
                "style" => 'margin-top:10px'
            ),
        ));
    }
}