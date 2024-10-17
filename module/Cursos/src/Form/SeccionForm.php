<?php

namespace Cursos\Form;

use Laminas\Form\Form;

class SeccionForm extends Form
{
   public function __construct()
   {
       parent::__construct('curso');

       $this->add([
           'name' => 'id',
           'type' => 'hidden'
       ]);
       $this->add([
           'name' => 'nombre',
           'type' => 'text',
           'options' => [
               'label' => 'Nombre'
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
