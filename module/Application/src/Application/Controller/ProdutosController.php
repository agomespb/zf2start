<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\ProdutoForm;
use Application\Model\Produto;

class ProdutosController extends AbstractActionController{
    
    protected $produtoTable;
    
    public function getProdutoTable( ) {
        
        if ( !$this->produtoTable ){
            $sm = $this->getServiceLocator();
            $this->produtoTable = $sm->get('produto_table');
        }
        
        return $this->produtoTable;
        
    }

    public function indexAction( ) {
        
    }
    
    public function novoAction( ) {
        
        $form = new ProdutoForm();
        $form->setAttribute('class', 'form-horizontal');
        
        $request = $this->getRequest();
        if( $request->isPost() ){
            
            $produto = new Produto();
            
            $data = $request->getPost();
            
            $form->setInputFilter($produto->getInputFilter());
            $form->setData($data);
            
            if ( $form->isValid() ){
                $produto->exchangeArray($data);
                $this->getProdutoTable()->saveProduto($produto);
            }
            
            var_dump($data);
        }
        
        $view = new ViewModel(array(
            
            'form' => $form
            
        ));
        
        $view->setTemplate('application/produtos/form.phtml');
        
        return $view;
        
        
    }
}