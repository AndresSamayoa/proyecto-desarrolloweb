<?php

namespace Cursos\Model;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Alumno implements InputFilterAwareInterface{
    public $id ;
    public $nombres ;
    public $apellidos ;
    public $fecha_nacimiento ;
    public $foto ;
    public $carrera_id ;
    public $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->nombres = !empty($data['nombres']) ? $data['nombres'] : null;
        $this->apellidos = !empty($data['apellidos']) ? $data['apellidos'] : null;
        $this->fecha_nacimiento = !empty($data['fecha_nacimiento']) ? $data['fecha_nacimiento'] : null;
        $this->foto = !empty($data['foto']) ? $data['foto'] : null;
        $this->carrera_id = !empty($data['carrera_id']) ? $data['carrera_id'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \DomainException(sprintf(
            '%s does not allow injection of an alternate input filter', __CLASS__
        ));
    }

    public function getArrayCopy(): array
    {
        return [
            'id'     => $this->id,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'foto' => $this->foto,
            'carrera_id' => $this->carrera_id,
        ];
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => false,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'nombres',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 150
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'apellidos',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 150
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'foto',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'fecha_nacimiento',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'carrera_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
