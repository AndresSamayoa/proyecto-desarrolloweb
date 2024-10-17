<?php

namespace Cursos\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class SemestreForm extends Form
{
   public function __construct()
   {
       parent::__construct('curso');

       $this->add([
           'name' => 'id',
           'type' => 'hidden'
       ]);
       $this->add([
           'name' => 'fecha_inicio',
           'type' => Element\Date::class,
           'options' => [
               'label' => 'Fecha inicio',
                'format' => 'Y-m-d',
           ],
           'attributes' => [
                'step' => '1'
            ]
       ]);
       $this->add([
           'name' => 'fecha_fin',
           'type' => Element\Date::class,
           'options' => [
               'label' => 'Fecha fin',
                'format' => 'Y-m-d',
           ],
           'attributes' => [
                'step' => '1'
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
