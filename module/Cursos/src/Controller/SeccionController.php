<?php
namespace Cursos\Controller;

use Laminas\View\Model\ViewModel;
use Cursos\Model\Seccion;
use Cursos\Form\SeccionForm;

class SeccionController extends \Laminas\Mvc\Controller\AbstractActionController
{
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

   public function indexAction(): ViewModel
   {
        $secciones = $this->table->fetchAll();
        return new ViewModel(['secciones' => $secciones]);
   }

    public function createAction()
    {
        $form = new SeccionForm();
        $form->get('submit')->setValue('Nuevo');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $seccion = new Seccion();
        $form->setInputFilter($seccion->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $seccion->exchangeArray($form->getData());
        $this->table->saveSeccion($seccion);
        return $this->redirect()->toRoute('secciones');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('secciones-create', ['action' => 'create']);
        }

        try {
            $seccion = $this->table->getSeccion($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('secciones', ['action' => 'index']);
        }

        $form = new SeccionForm();
        $form->bind($seccion);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($seccion->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveSeccion($seccion);
        } catch (Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('secciones', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $task = $this->table->getSeccion($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('secciones', ['action' => 'index']);
        }

        try {
            $this->table->deleteSeccion($task->id);
        } catch (\Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('secciones', ['action' => 'index']);
    }
}
