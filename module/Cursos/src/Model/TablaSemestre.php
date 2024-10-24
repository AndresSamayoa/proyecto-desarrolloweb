<?php

namespace Cursos\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class TablaSemestre
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
            $list[$row->id] = 'Desde ' . $row->fecha_inicio . ' hasta ' . $row->fecha_fin;
        }

       return $list;
   }

   public function getSemestre($id)
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

   public function getSemestreNombre($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->select(['id' => $id]);
       $row = $rowset->current();
       if (!$row) {
           return '';
       }

       return 'Desde ' . $row->fecha_inicio . ' hasta ' . $row->fecha_fin;
   }

   public function saveSemestre (Semestre $semestre)
   {
    $data = [
        'fecha_inicio' => $semestre->fecha_inicio,
        'fecha_fin' => $semestre->fecha_fin,
    ];
 
    $id = (int) $semestre->id;
 
    if ($id === 0 ) {
        $this->tableGateway->insert($data);
        return;
    }
 
    try {
        $this->getSemestre($id);
    } catch (\Exception $e){
        throw new RuntimeException(sprintf(
            'Cannot update task with identifier %d; does not exist',
            $id
        ));
    }
 
    $this->tableGateway->update($data, ['id'=>$id]);
   }

   public function deleteSemestre($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->delete(['id' => $id]);

       return ;
   }
}
