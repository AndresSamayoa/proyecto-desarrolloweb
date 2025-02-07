<?php

namespace Cursos\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class TablaSeccion
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

   public function getSeccion($id)
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

   public function saveSeccion (Seccion $seccion)
   {
    $data = [
        'nombre' => $seccion->nombre,
    ];
 
    $id = (int) $seccion->id;
 
    if ($id === 0 ) {
        $this->tableGateway->insert($data);
        return;
    }
 
    try {
        $this->getSeccion($id);
    } catch (\Exception $e){
        throw new RuntimeException(sprintf(
            'Cannot update task with identifier %d; does not exist',
            $id
        ));
    }
 
    $this->tableGateway->update($data, ['id'=>$id]);
   }

   public function deleteSeccion($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->delete(['id' => $id]);

       return ;
   }
}
