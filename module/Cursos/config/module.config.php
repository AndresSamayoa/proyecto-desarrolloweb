<?php

namespace Cursos;

use Cursos\Controller\CursoController;
use Cursos\Controller\CarreraController;
use Cursos\Controller\SemestreController;
use Cursos\Controller\SeccionController;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
       'routes' => [
           'cursos' => [
               'type' => Segment::class,
               'options' => [
                   'route' => '/cursos[/:action[/:id]]',
                   'constraints' => [
                       'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                       'id' => '[1-9]\d*',
                   ],
                   'defaults' => [
                       'controller' => CursoController::class,
                       'action' => 'index'
                   ],
               ]
            ],
           'carreras' => [
               'type' => Segment::class,
               'options' => [
                   'route' => '/carreras[/:action[/:id]]',
                   'constraints' => [
                       'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                       'id' => '[1-9]\d*',
                   ],
                   'defaults' => [
                       'controller' => CarreraController::class,
                       'action' => 'index'
                   ],
               ]
            ],
           'semestres' => [
               'type' => Segment::class,
               'options' => [
                   'route' => '/semestres[/:action[/:id]]',
                   'constraints' => [
                       'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                       'id' => '[1-9]\d*',
                   ],
                   'defaults' => [
                       'controller' => SemestreController::class,
                       'action' => 'index'
                   ],
               ]
            ],
           'secciones' => [
               'type' => Segment::class,
               'options' => [
                   'route' => '/secciones[/:action[/:id]]',
                   'constraints' => [
                       'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                       'id' => '[1-9]\d*',
                   ],
                   'defaults' => [
                       'controller' => SeccionController::class,
                       'action' => 'index'
                   ],
               ]
            ],
       ]
   ],
   'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'template_path_stack' => [
        __DIR__ . '/../view',
        ],
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ],
   ]
];