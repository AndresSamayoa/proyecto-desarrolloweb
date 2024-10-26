<?php
namespace Cursos;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Cursos\Model\Carrera;
use Cursos\Model\TablaCarrera;
use Cursos\Model\Curso;
use Cursos\Model\TablaCurso;
use Cursos\Model\Semestre;
use Cursos\Model\TablaSemestre;
use Cursos\Model\Seccion;
use Cursos\Model\TablaSeccion;
use Cursos\Model\Alumno;
use Cursos\Model\TablaAlumno;
use Cursos\Model\AsignacionCursos;
use Cursos\Model\TablaAsignacionCursos;


class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                'CursoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Curso());
                    return new TableGateway('cursos', $dbAdapter, null, $resultSetPrototype);
                },
                'Cursos\Model\TablaCurso' => function ($sm) {
                    $tableGateWay = $sm->get('CursoTableGateway');
                    return new TablaCurso($tableGateWay);
                },
                'CarreraTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Carrera());
                    return new TableGateway('carreras', $dbAdapter, null, $resultSetPrototype);
                },
                'Cursos\Model\TablaCarrera' => function ($sm) {
                    $tableGateWay = $sm->get('CarreraTableGateway');
                    return new TablaCarrera($tableGateWay);
                },
                'SemestreTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Semestre());
                    return new TableGateway('semestres', $dbAdapter, null, $resultSetPrototype);
                },
                'Cursos\Model\TablaSemestre' => function ($sm) {
                    $tableGateWay = $sm->get('SemestreTableGateway');
                    return new TablaSemestre($tableGateWay);
                },
                'SeccionTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Seccion());
                    return new TableGateway('secciones', $dbAdapter, null, $resultSetPrototype);
                },
                'Cursos\Model\TablaSeccion' => function ($sm) {
                    $tableGateWay = $sm->get('SeccionTableGateway');
                    return new TablaSeccion($tableGateWay);
                },
                'AlumnoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Alumno());
                    return new TableGateway('alumnos', $dbAdapter, null, $resultSetPrototype);
                },
                'Cursos\Model\TablaAlumno' => function ($sm) {
                    $tableGateWay = $sm->get('AlumnoTableGateway');
                    return new TablaAlumno($tableGateWay);
                },
                'AsignacionCursoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new AsignacionCursos());
                    return new TableGateway('cursos_asignados', $dbAdapter, null, $resultSetPrototype);
                },
                'Cursos\Model\TablaAsignacionCursos' => function ($sm) {
                    $tableGateWay = $sm->get('AsignacionCursoTableGateway');
                    return new TablaAsignacionCursos($tableGateWay);
                },
            ]
        ];
    }

    public function getControllerConfig() :array
    {
        return [
            'factories' => [
                Controller\CursoController::class => function ($container) {
                    return new Controller\CursoController(
                        $container->get(Model\TablaCurso::class)
                    );
                },
                Controller\CarreraController::class => function ($container) {
                    return new Controller\CarreraController(
                        $container->get(Model\TablaCarrera::class),
                        $container->get(Model\TablaAlumno::class)
                    );
                },
                Controller\SemestreController::class => function ($container) {
                    return new Controller\SemestreController(
                        $container->get(Model\TablaSemestre::class)
                    );
                },
                Controller\SeccionController::class => function ($container) {
                    return new Controller\SeccionController(
                        $container->get(Model\TablaSeccion::class)
                    );
                },
                Controller\AlumnoController::class => function ($container) {
                    return new Controller\AlumnoController(
                        $container->get(Model\TablaAlumno::class),
                        $container->get(Model\TablaCarrera::class),
                        $container->get(Model\TablaAsignacionCursos::class),
                        $container->get(Model\TablaSemestre::class),
                        $container->get(Model\TablaCurso::class)
                    );
                },
                Controller\AsignacionCursosController::class => function ($container) {
                    return new Controller\AsignacionCursosController(
                        $container->get(Model\TablaAsignacionCursos::class),
                        $container->get(Model\TablaAlumno::class),
                        $container->get(Model\TablaSemestre::class),
                        $container->get(Model\TablaCurso::class)
                    );
                },
            ]
        ];
    }
}
