<?php
namespace Cursos\Controller;

use Laminas\View\Model\ViewModel;
use Cursos\Model\Curso;
use Cursos\Form\CursoForm;

class CursoController extends \Laminas\Mvc\Controller\AbstractActionController
{
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

   public function indexAction(): ViewModel
   {
        $cursos = $this->table->fetchAll();
        return new ViewModel(['cursos' => $cursos]);
   }

    public function createAction()
    {
        $form = new CursoForm();
        $form->get('submit')->setValue('Nuevo');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $curso = new Curso();
        $form->setInputFilter($curso->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $curso->exchangeArray($form->getData());
        $this->table->saveCurso($curso);
        return $this->redirect()->toRoute('cursos');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('cursos-create', ['action' => 'create']);
        }

        try {
            $curso = $this->table->getCurso($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('cursos', ['action' => 'index']);
        }

        $form = new CursoForm();
        $form->bind($curso);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($curso->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveCurso($curso);
        } catch (Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('cursos', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $task = $this->table->getCurso($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('cursos', ['action' => 'index']);
        }

        try {
            $this->table->deleteCurso($task->id);
        } catch (\Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('cursos', ['action' => 'index']);
    }
}