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
                }
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
                        $container->get(Model\TablaCarrera::class)
                    );
                },
            ]
        ];
    }
}
