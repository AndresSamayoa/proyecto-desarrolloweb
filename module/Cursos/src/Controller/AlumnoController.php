<?php
namespace Cursos\Controller;

use Laminas\View\Model\ViewModel;
use Cursos\Model\Alumno;
use Cursos\Form\AlumnoForm;

class AlumnoController extends \Laminas\Mvc\Controller\AbstractActionController
{
    private $table;
    private $tableCarrera;

    public function __construct($table, $tableCarrera)
    {
        $this->table = $table;
        $this->tableCarrera = $tableCarrera;
    }

   public function indexAction(): ViewModel
   {
        $alumnos = $this->table->fetchAll();
        return new ViewModel(['alumnos' => $alumnos, 'tablaCarrera' => $this->tableCarrera]);
   }

    public function createAction()
    {
        $form = new AlumnoForm($this->tableCarrera);
        $form->get('submit')->setValue('Nuevo');

        $request = $this->getRequest();

        echo($request->isPost());

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $alumno = new Alumno();
        $form->setInputFilter($alumno->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $alumno->exchangeArray($form->getData());
        $this->table->saveAlumno($alumno);
        return $this->redirect()->toRoute('alumnos');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('alumnos-create', ['action' => 'create']);
        }

        try {
            $alumno = $this->table->getAlumno($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('alumnos', ['action' => 'index']);
        }

        $form = new AlumnoForm($this->tableCarrera);
        $form->bind($alumno);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($alumno->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveAlumno($alumno);
        } catch (Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('alumnos', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $task = $this->table->getAlumno($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('alumnos', ['action' => 'index']);
        }

        try {
            $this->table->deleteAlumno($task->id);
        } catch (\Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('alumnos', ['action' => 'index']);
    }
}
