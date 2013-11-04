<?php

namespace Application\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;


class ProdutoTable extends AbstractTableGateway{
    
    protected $table = 'tbl_produtos';
    
    public function __construct( Adapter $adapter ) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Produto());
        $this->initialize();
    }
    
    public function fetchAll($pageNumber = 1, $itemCountPerPage = 2){
        
        $select = new Select();
        $select->from($this->table)->order('produto_nome');
        
        $adapter = new DbSelect($select, $this->adapter, $this->resultSetPrototype);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage($itemCountPerPage);
        
        return $paginator;
    }
    
    public function getProduto($idProdtuo) {
        
        $idProdtuo = (int) $idProdtuo;
        
        $rowSet = $this->select(array('produto_id' => $idProdtuo));
        $row = $rowSet->current();
        
        if ( !$row ){
            throw new \Exception("Produto de id $idProdtuo não encontrado");
        }
        
        return $row;
    }
    
    public function saveProduto(Produto $produto) {
        
        $data = array(
            'produto_nome' => $produto->produto_nome,
            'produto_preco' => $produto->produto_preco,
            'produto_foto' => $produto->produto_foto,
            'produto_descricao' => $produto->produto_descricao,
            'produto_status' => $produto->produto_status
        );
        
        $idProduto = (int) $produto->produto_id;
        
        if ( $idProduto == 0 ){
            $this->insert($data);
        } else {
            if ( $this->getProduto($idProdtuo) ){
                $this->update($data, array('produto_id' => $idProduto));
            } else {
                throw new \Exception("O produto de id $idProdtuo não pode ser atualizado,pois não existe.");
            }
        }
    }
}

