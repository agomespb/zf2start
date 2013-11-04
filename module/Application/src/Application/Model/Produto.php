<?php

namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as inputFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class Produto implements InputFilterAwareInterface {
    
    public $produto_id;
    public $produto_nome;
    public $produto_preco;
    public $produto_foto;
    public $produto_descricao;
    public $produto_status;
    
    protected $inputFilter;
    
    public function exchangeArray($data) {
        
        $this->produto_id = (isset($data['produto_id'])) ? $data['produto_id'] : Null ;
        $this->produto_nome = (isset($data['produto_nome'])) ? $data['produto_nome'] : Null;
        $this->produto_preco = (isset($data['produto_preco'])) ? $data['produto_preco'] : Null;
        $this->produto_foto = (isset($data['produto_foto'])) ? $data['produto_foto'] : Null;
        $this->produto_descricao = (isset($data['produto_descricao'])) ? $data['produto_descricao'] : Null;
        $this->produto_status = (isset($data['produto_status'])) ? $data['produto_status'] : Null;
    
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception('Not Used');
    }
    
    public function getInputFilter() {
        
        if ( !$this->inputFilter ){

            $inputFilter = new InputFilter();
            $factory = new inputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'produto_id',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int')
                 ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'produto_nome',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array(
                        'name'    => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Preencha este campo!'
                            )
                        )
                    )
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'produto_preco',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array(
                        'name'    => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Preencha este campo!'
                            )
                        )
                    )
                )                
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'produto_foto',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'produto_descricao',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Preencha este campo!'
                            )
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        TRUE,
                        'options' => array(
                            'ecoding' => 'UTF-8',
                            'min' => 10,
                            'max' => 550,
                            'message' => 'A descrição dever conter entre 10 e 550 caracteres.'
                        )
                    )
                )
            )));            
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'produto_status',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                )
            )));
            
            $this->inputFilter = $inputFilter;
            
        }
        
        return $this->inputFilter;
    }
}