<?php
namespace Cursos\Controller;

use Laminas\View\Model\ViewModel;
use Cursos\Model\Semestre;
use Cursos\Form\SemestreForm;

class SemestreController extends \Laminas\Mvc\Controller\AbstractActionController
{
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

   public function indexAction(): ViewModel
   {
        $semestres = $this->table->fetchAll();
        return new ViewModel(['semestres' => $semestres]);
   }

    public function createAction()
    {
        $form = new SemestreForm();
        $form->get('submit')->setValue('Nuevo');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $semestre = new Semestre();
        $form->setInputFilter($semestre->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $semestre->exchangeArray($form->getData());
        $this->table->saveSemestre($semestre);
        return $this->redirect()->toRoute('semestres');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('semestres-create', ['action' => 'create']);
        }

        try {
            $semestre = $this->table->getSemestre($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('semestres', ['action' => 'index']);
        }

        $form = new SemestreForm();
        $form->bind($semestre);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($semestre->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveSemestre($semestre);
        } catch (Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('semestres', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $task = $this->table->getSemestre($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('semestres', ['action' => 'index']);
        }

        try {
            $this->table->deleteSemestre($task->id);
        } catch (\Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('semestres', ['action' => 'index']);
    }
}
