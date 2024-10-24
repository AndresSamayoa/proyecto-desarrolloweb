<?php

namespace Cursos\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class AlumnoForm extends Form
{
    public function __construct($table)
    {
        
        parent::__construct('curso');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'foto',
            'type' => 'hidden',
            'attributes' => [
                'value' => 'Null',
            ]
        ]);
        $this->add([
            'name' => 'nombres',
            'type' => 'text',
            'options' => [
                'label' => 'Nombre'
            ]
        ]);
        $this->add([
            'name' => 'apellidos',
            'type' => 'text',
            'options' => [
                'label' => 'Apellidos'
            ]
        ]);
        $this->add([
            'name' => 'fecha_nacimiento',
            'type' => Element\Date::class,
            'options' => [
                'label' => 'Fecha nacimiento',
                    'format' => 'Y-m-d',
            ],
            'attributes' => [
                    'step' => '1'
                ]
        ]);
        $this->add([
            'name' => 'carrera_id',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Carrera',
                'value_options' => $table->fetchAllSelect()
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
