<?php

namespace Cursos\Model;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Filter\ToFloat;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class AsignacionCursos implements InputFilterAwareInterface{
    public $id ;
    public $alumno_id ;
    public $semestre_id ;
    public $curso_id ;
    public $nota ;
    public $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->alumno_id = !empty($data['alumno_id']) ? $data['alumno_id'] : null;
        $this->semestre_id = !empty($data['semestre_id']) ? $data['semestre_id'] : null;
        $this->curso_id = !empty($data['curso_id']) ? $data['curso_id'] : null;
        $this->nota = !empty($data['nota']) ? $data['nota'] : null;
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
            'alumno_id' => $this->alumno_id,
            'semestre_id' => $this->semestre_id,
            'curso_id' => $this->curso_id,
            'nota' => $this->nota,
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
            'name' => 'alumno_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'semestre_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'curso_id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'nota',
            'required' => true,
            'filters' => [
                ['name' => ToFloat::class]
            ]
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
