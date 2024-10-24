<?php
namespace Cursos\Controller;

use Laminas\View\Model\ViewModel;
use Cursos\Model\AsignacionCursos;
use Cursos\Form\AsignacionCursoForm;

class AsignacionCursosController extends \Laminas\Mvc\Controller\AbstractActionController
{
    private $table;
    private $tableAlumno;
    private $tableSemestre;
    private $tableCurso;

    public function __construct($table, $tableAlumno, $tableSemestre, $tableCurso)
    {
        $this->table = $table;
        $this->tableAlumno = $tableAlumno;
        $this->tableSemestre = $tableSemestre;
        $this->tableCurso = $tableCurso;
    }

   public function indexAction(): ViewModel
   {
        $asignacionCursos = $this->table->fetchAll();
        return new ViewModel([
            'asignacionCursos' => $asignacionCursos,
            'tableAlumno' => $this->tableAlumno,
            'tableSemestre' => $this->tableSemestre,
            'tableCurso' => $this->tableCurso,
        ]);
   }

    public function createAction()
    {
        $form = new AsignacionCursoForm($this->tableAlumno, $this->tableCurso, $this->tableSemestre);
        $form->get('submit')->setValue('Nuevo');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $alumno = new AsignacionCursos();
        $form->setInputFilter($alumno->getInputFilter());
        $form->setData($request->getPost());

        echo($request->getPost()->alumno_id);
        echo($request->getPost()->semestre_id);
        echo($request->getPost()->curso_id);
        echo($request->getPost()->nota);

        // return;

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $alumno->exchangeArray($form->getData());
        $this->table->saveAsignacionCurso($alumno);
        return $this->redirect()->toRoute('asignacionCursos');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('asignacionCursos-create', ['action' => 'create']);
        }

        try {
            $alumno = $this->table->getAsignacionCurso($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('asignacionCursos', ['action' => 'index']);
        }

        $form = new AsignacionCursoForm($this->tableAlumno, $this->tableCurso, $this->tableSemestre);
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
            $this->table->saveAsignacionCurso($alumno);
        } catch (Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('asignacionCursos', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        try {
            $task = $this->table->getAsignacionCurso($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('asignacionCursos', ['action' => 'index']);
        }

        try {
            $this->table->deleteAsignacionCurso($task->id);
        } catch (\Exception $e){
            \error_log("error updating", $e->getMessage());
        }

        return $this->redirect()->toRoute('asignacionCursos', ['action' => 'index']);
    }
}
