<?php

namespace Cursos\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class TablaCarrera
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

   public function getCarrera($id)
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

   public function saveCarrera (Carrera $carrera)
   {
    $data = [
        'nombre' => $carrera->nombre,
    ];
 
    $id = (int) $carrera->id;
 
    if ($id === 0 ) {
        $this->tableGateway->insert($data);
        return;
    }
 
    try {
        $this->getCarrera($id);
    } catch (\Exception $e){
        throw new RuntimeException(sprintf(
            'Cannot update task with identifier %d; does not exist',
            $id
        ));
    }
 
    $this->tableGateway->update($data, ['id'=>$id]);
   }

   public function deleteCarrera($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->delete(['id' => $id]);

       return ;
   }
}
