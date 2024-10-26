<?php
namespace Cursos\Controller;

use Laminas\View\Model\ViewModel;
use Cursos\Model\Carrera;
use Cursos\Form\CarreraForm;

class CarreraController extends \Laminas\Mvc\Controller\AbstractActionController
{
    private $table;
    private $tableAlumno;

    public function __construct($table, $tableAlumno)
    {
        $this->table = $table;
        $this->tableAlumno = $tableAlumno;
    }

   public function indexAction(): ViewModel
   {
        $carreras = $this->table->fetchAll();
        return new ViewModel(['carreras' => $carreras]);
   }

   public function reporteAction(): ViewModel
   {
        $id = (int) $this->params()->fromRoute('id', 0);

        $carrera = $this->table->getCarrera($id);

        $alumnos = $this->tableAlumno->getFromCarrera($id);

        return new ViewModel(['carrera' => $carrera, 'alumnos' => $alumnos]);
   }

    public function createAction()
    {
        $form = new CarreraForm();
        $form->get('submit')->setValue('Nuevo');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $carrera = new Carrera();
        $form->setInputFilter($carrera->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $carrera->exchangeArray($form->getData());
        $this->table->saveCarrera($carrera);
        return $this->redirect()->toRoute('carreras');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('carreras-create', ['action' => 'create']);
        }

        try {
            $carrera = $this->table->getCarrera($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('carreras', ['action' => 'index']);
        }

        $form = new CarreraForm();
        $form->bind($carrera);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($carrera->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveCarrera($carrera);
        } catch (Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('carreras', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $task = $this->table->getCarrera($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('carreras', ['action' => 'index']);
        }

        try {
            $this->table->deleteCarrera($task->id);
        } catch (\Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('carreras', ['action' => 'index']);
    }
}
