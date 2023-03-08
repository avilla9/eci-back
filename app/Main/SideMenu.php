<?php

namespace App\Main;

class SideMenu {
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu() {
        return [
            // 'dashboard' => [
            //     'icon' => 'home',
            //     'title' => 'Dashboard',
            //     'sub_menu' => [
            //         'dashboard-overview-1' => [
            //             'icon' => '',
            //             'route_name' => 'dashboard-overview-1',
            //             'params' => [
            //                 'layout' => 'side-menu',
            //             ],
            //             'title' => 'Overview 1'
            //         ],
            //         'dashboard-overview-2' => [
            //             'icon' => '',
            //             'route_name' => 'dashboard-overview-2',
            //             'params' => [
            //                 'layout' => 'side-menu',
            //             ],
            //             'title' => 'Overview 2'
            //         ],
            //         'dashboard-overview-3' => [
            //             'icon' => '',
            //             'route_name' => 'dashboard-overview-3',
            //             'params' => [
            //                 'layout' => 'side-menu',
            //             ],
            //             'title' => 'Overview 3'
            //         ]
            //     ]
            // ],
            'usuarios' => [
                'icon' => 'users',
                'title' => 'Usuarios',
                'sub_menu' => [
                    'create-user' => [
                        'icon' => '',
                        'route_name' => 'crear-usuarios',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Crear usuarios'
                    ],
                    'delete-user' => [
                        'icon' => '',
                        'route_name' => 'eliminar-usuarios',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Eliminar usuarios'
                    ],
                    'list-user' => [
                        'icon' => '',
                        'route_name' => 'lista-de-usuarios',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Lista de usuarios'
                    ],
                    'upload-user' => [
                        'icon' => '',
                        'route_name' => 'subir-usuarios',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Subir usuarios'
                    ],
                ]
            ],
            'roles' => [
                'icon' => 'settings',
                'title' => 'Roles',
                'sub_menu' => [
                    'create-role' => [
                        'icon' => '',
                        'route_name' => 'create-role',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Crear rol'
                    ],
                    'list-role' => [
                        'icon' => '',
                        'route_name' => 'role-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Lista de roles'
                    ],
                ]
            ],
            'filemanager' => [
                'icon' => 'hard-drive',
                'title' => 'Archivos',
                'sub_menu' => [
                    'upload' => [
                        'title' => 'Subir archivo',
                        'icon' => '',
                        'route_name' => 'file.up',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'list' => [
                        'title' => 'Ver archivos',
                        'icon' => '',
                        'route_name' => 'file.list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ],
            ],
            'campaign' => [
                'icon' => 'flag',
                'title' => 'Campañas',
                'sub_menu' => [
                    'create-campaign' => [
                        'icon' => '',
                        'route_name' => 'campaign-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Crear campaña'
                    ],
                    'list-campaigns' => [
                        'icon' => '',
                        'route_name' => 'campaign-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Lista de campañas'
                    ],
                ]
            ],
            'production' => [
                'icon' => 'settings',
                'title' => 'Datos de producción',
                'sub_menu' => [
                    'list-production' => [
                        'icon' => '',
                        'route_name' => 'production-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Gestión de datos'
                    ],
                ]
            ],
            'devider',
            'stories' => [
                'icon' => 'clock',
                'title' => 'Stories',
                'sub_menu' => [
                    'create-storie' => [
                        'icon' => '',
                        'route_name' => 'create-storie',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Crear Storie'
                    ],
                    'list-stories' => [
                        'icon' => '',
                        'route_name' => 'stories-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Lista de Stories'
                    ],
                ]
            ],
            'home' => [
                'icon' => 'home',
                'title' => 'Home',
                'sub_menu' => [
                    'home-create' => [
                        'title' => 'Crear contenido',
                        'icon' => '',
                        'route_name' => 'home-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'homes-list' => [
                        'title' => 'Ver contenido',
                        'icon' => '',
                        'route_name' => 'home.get.list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            'campaign-content' => [
                'icon' => 'plus-square',
                'title' => 'Campañas',
                'sub_menu' => [
                    'content-campaign-create' => [
                        'title' => 'Crear contenido',
                        'icon' => '',
                        'route_name' => 'content-campaign-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'content-campaigns-list' => [
                        'title' => 'Ver contenido',
                        'icon' => '',
                        'route_name' => 'content-campaign-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            'adoption-content' => [
                'icon' => 'globe',
                'title' => 'Adopción',
                'sub_menu' => [
                    'content-adoption-create' => [
                        'title' => 'Crear contenido',
                        'icon' => '',
                        'route_name' => 'content-adoption-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'content-adoptions-list' => [
                        'title' => 'Ver contenido',
                        'icon' => '',
                        'route_name' => 'content-adoption-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            'knowledge-content' => [
                'icon' => 'settings',
                'title' => 'Conocimiento',
                'sub_menu' => [
                    'content-knowledge-create' => [
                        'title' => 'Crear contenido',
                        'icon' => '',
                        'route_name' => 'content-knowledge-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'content-knowledge-list' => [
                        'title' => 'Ver contenido',
                        'icon' => '',
                        'route_name' => 'content-knowledge-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            'reward-content' => [
                'icon' => 'thumbs-up',
                'title' => 'Recompensas',
                'sub_menu' => [
                    'content-reward-create' => [
                        'title' => 'Crear contenido',
                        'icon' => '',
                        'route_name' => 'content-reward-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'content-reward-list' => [
                        'title' => 'Ver contenido',
                        'icon' => '',
                        'route_name' => 'content-reward-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            'room-content' => [
                'icon' => 'star',
                'title' => 'Salas',
                'sub_menu' => [
                    'content-room-create' => [
                        'title' => 'Crear contenido',
                        'icon' => '',
                        'route_name' => 'content-room-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'section-room-create' => [
                        'title' => 'Gestionar secciones',
                        'icon' => '',
                        'route_name' => 'section-room-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'content-room-list' => [
                        'title' => 'Ver contenido',
                        'icon' => '',
                        'route_name' => 'content-room-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            'access-content' => [
                'icon' => 'log-in',
                'title' => 'Accesos',
                'sub_menu' => [
                    'content-access-create' => [
                        'title' => 'Crear contenido',
                        'icon' => '',
                        'route_name' => 'content-access-create',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                    'content-access-list' => [
                        'title' => 'Ver contenido',
                        'icon' => '',
                        'route_name' => 'content-access-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                    ],
                ]
            ],
            'firebase-notification' => [
                'icon' => 'bell',
                'title' => 'Notificaciones',
                'route_name' => 'firebase-notification',
                'params' => [
                    'layout' => 'side-menu'
                ],
            ],
        ];
    }
}
