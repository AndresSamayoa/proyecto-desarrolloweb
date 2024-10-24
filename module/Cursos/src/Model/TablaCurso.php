<?php

namespace Cursos\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class TablaCurso
{
    /** @var TableGatewayInterface */
   private $tableGateway;

   public function __construct(TableGatewayInterface $tableGateway)
   {
       $this->tableGateway = $tableGateway;
   }

   public function fetchAll()
   {
       return $this->tableGateway->select();
   }

   public function fetchAllSelect()
   {
        $list = array();
        $result = $this->tableGateway->select();

        foreach ($result as $row) {
            $list[$row->id] = $row->nombre;
        }

       return $list;
   }

   public function getCurso($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->select(['id' => $id]);
       $row = $rowset->current();
       if (!$row) {
           throw new RuntimeException(sprintf(
               'Could not find row with identifier %d',
               $id
           ));
       }

       return $row;
   }

   public function getCursoName($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->select(['id' => $id]);
       $row = $rowset->current();
       if (!$row) {
            return '';
       }

       return $row->nombre;
   }

   public function saveCurso (Curso $curso)
   {
    $data = [
        'nombre' => $curso->nombre,
    ];
 
    $id = (int) $curso->id;
 
    if ($id === 0 ) {
        $this->tableGateway->insert($data);
        return;
    }
 
    try {
        $this->getCurso($id);
    } catch (\Exception $e){
        throw new RuntimeException(sprintf(
            'Cannot update task with identifier %d; does not exist',
            $id
        ));
    }
 
    $this->tableGateway->update($data, ['id'=>$id]);
   }

   public function deleteCurso($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->delete(['id' => $id]);

       return ;
   }
}
