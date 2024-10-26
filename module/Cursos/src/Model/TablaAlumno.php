<?php

namespace Cursos\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class TablaAlumno
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
            $list[$row->id] = $row->nombres . ' ' . $row->apellidos;
        }

       return $list;
   }
   
   public function getFromCarrera($id)
   {
        $result = $this->tableGateway->select(['carrera_id' => $id]);

       return $result;
   }

   public function getAlumno($id)
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

   public function getAlumnoNombre($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->select(['id' => $id]);
       $row = $rowset->current();
       if (!$row) {
            return '';
       }

       return $row->nombres . ' ' . $row->apellidos;
   }

   public function saveAlumno (Alumno $alumno)
   {
    $data = [
        'nombres' => $alumno->nombres,
        'apellidos' => $alumno->apellidos,
        'fecha_nacimiento' => $alumno->fecha_nacimiento,
        'foto' => $alumno->foto,
        'carrera_id' => $alumno->carrera_id,
    ];
 
    $id = (int) $alumno->id;
 
    if ($id === 0 ) {
        $this->tableGateway->insert($data);
        return;
    }
 
    try {
        $this->getAlumno($id);
    } catch (\Exception $e){
        throw new RuntimeException(sprintf(
            'Cannot update task with identifier %d; does not exist',
            $id
        ));
    }
 
    $this->tableGateway->update($data, ['id'=>$id]);
   }

   public function deleteAlumno($id)
   {
       $id = (int)$id;
       $rowset = $this->tableGateway->delete(['id' => $id]);

       return ;
   }
}
