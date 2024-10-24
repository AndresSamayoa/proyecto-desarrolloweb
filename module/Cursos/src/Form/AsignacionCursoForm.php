<?php

namespace Cursos\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class AsignacionCursoForm extends Form
{
    public function __construct($tableEstudiante, $tableCurso, $tableSemestre)
    {
        
        parent::__construct('curso');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'alumno_id',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'alumno',
                'value_options' => $tableEstudiante->fetchAllSelect()
            ]
        ]);
        $this->add([
            'name' => 'curso_id',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Curso',
                'value_options' => $tableCurso->fetchAllSelect()
            ]
        ]);
        $this->add([
            'name' => 'semestre_id',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Semestre',
                'value_options' => $tableSemestre->fetchAllSelect()
            ]
        ]);
        $this->add([
            'name' => 'nota',
            'type' => 'number',
            'options' => [
                'label' => 'Nota'
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton'
            ]
        ]);
    }
}
