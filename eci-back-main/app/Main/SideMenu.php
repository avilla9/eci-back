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
            'dashboard' => [
                'icon' => 'home',
                'title' => 'Dashboard',
                'sub_menu' => [
                    'dashboard-overview-1' => [
                        'icon' => '',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Overview 1'
                    ],
                    'dashboard-overview-2' => [
                        'icon' => '',
                        'route_name' => 'dashboard-overview-2',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Overview 2'
                    ],
                    'dashboard-overview-3' => [
                        'icon' => '',
                        'route_name' => 'dashboard-overview-3',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Overview 3'
                    ]
                ]
            ],
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
                        'route_name' => 'homes-list',
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
            'devider',
            'menu-layout' => [
                'icon' => 'box',
                'title' => 'Menu Layout',
                'sub_menu' => [
                    'side-menu' => [
                        'icon' => '',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Side Menu'
                    ],
                    'simple-menu' => [
                        'icon' => '',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'simple-menu'
                        ],
                        'title' => 'Simple Menu'
                    ],
                    'top-menu' => [
                        'icon' => '',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'top-menu'
                        ],
                        'title' => 'Top Menu'
                    ]
                ]
            ],
            'inbox' => [
                'icon' => 'inbox',
                'route_name' => 'inbox',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Inbox'
            ],
            'file-manager' => [
                'icon' => 'hard-drive',
                'route_name' => 'file-manager',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'File Manager'
            ],
            'point-of-sale' => [
                'icon' => 'credit-card',
                'route_name' => 'point-of-sale',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Point of Sale'
            ],
            'chat' => [
                'icon' => 'message-square',
                'route_name' => 'chat',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Chat'
            ],
            'post' => [
                'icon' => 'file-text',
                'route_name' => 'post',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Post'
            ],
            'calendar' => [
                'icon' => 'calendar',
                'route_name' => 'calendar',
                'params' => [
                    'layout' => 'side-menu'
                ],
                'title' => 'Calendar'
            ],
            'devider',
            'crud' => [
                'icon' => 'edit',
                'title' => 'Crud',
                'sub_menu' => [
                    'crud-data-list' => [
                        'icon' => '',
                        'route_name' => 'crud-data-list',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Data List'
                    ],
                    'crud-form' => [
                        'icon' => '',
                        'route_name' => 'crud-form',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Form'
                    ]
                ]
            ],
            'users' => [
                'icon' => 'users',
                'title' => 'Users',
                'sub_menu' => [
                    'users-layout-1' => [
                        'icon' => '',
                        'route_name' => 'users-layout-1',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Layout 1'
                    ],
                    'users-layout-2' => [
                        'icon' => '',
                        'route_name' => 'users-layout-2',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Layout 2'
                    ],
                    'users-layout-3' => [
                        'icon' => '',
                        'route_name' => 'users-layout-3',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Layout 3'
                    ]
                ]
            ],
            'profile' => [
                'icon' => 'trello',
                'title' => 'Profile',
                'sub_menu' => [
                    'profile-overview-1' => [
                        'icon' => '',
                        'route_name' => 'profile-overview-1',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Overview 1'
                    ],
                    'profile-overview-2' => [
                        'icon' => '',
                        'route_name' => 'profile-overview-2',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Overview 2'
                    ],
                    'profile-overview-3' => [
                        'icon' => '',
                        'route_name' => 'profile-overview-3',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Overview 3'
                    ]
                ]
            ],
            'pages' => [
                'icon' => 'layout',
                'title' => 'Pages',
                'sub_menu' => [
                    'wizards' => [
                        'icon' => '',
                        'title' => 'Wizards',
                        'sub_menu' => [
                            'wizard-layout-1' => [
                                'icon' => '',
                                'route_name' => 'wizard-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'wizard-layout-2' => [
                                'icon' => '',
                                'route_name' => 'wizard-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ],
                            'wizard-layout-3' => [
                                'icon' => '',
                                'route_name' => 'wizard-layout-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'blog' => [
                        'icon' => '',
                        'title' => 'Blog',
                        'sub_menu' => [
                            'blog-layout-1' => [
                                'icon' => '',
                                'route_name' => 'blog-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'blog-layout-2' => [
                                'icon' => '',
                                'route_name' => 'blog-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ],
                            'blog-layout-3' => [
                                'icon' => '',
                                'route_name' => 'blog-layout-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'pricing' => [
                        'icon' => '',
                        'title' => 'Pricing',
                        'sub_menu' => [
                            'pricing-layout-1' => [
                                'icon' => '',
                                'route_name' => 'pricing-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'pricing-layout-2' => [
                                'icon' => '',
                                'route_name' => 'pricing-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'invoice' => [
                        'icon' => '',
                        'title' => 'Invoice',
                        'sub_menu' => [
                            'invoice-layout-1' => [
                                'icon' => '',
                                'route_name' => 'invoice-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'invoice-layout-2' => [
                                'icon' => '',
                                'route_name' => 'invoice-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'faq' => [
                        'icon' => '',
                        'title' => 'FAQ',
                        'sub_menu' => [
                            'faq-layout-1' => [
                                'icon' => '',
                                'route_name' => 'faq-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'faq-layout-2' => [
                                'icon' => '',
                                'route_name' => 'faq-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ],
                            'faq-layout-3' => [
                                'icon' => '',
                                'route_name' => 'faq-layout-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'login' => [
                        'icon' => '',
                        'route_name' => 'login',
                        'params' => [
                            'layout' => 'login'
                        ],
                        'title' => 'Login'
                    ],
                    'register' => [
                        'icon' => '',
                        'route_name' => 'register',
                        'params' => [
                            'layout' => 'login'
                        ],
                        'title' => 'Register'
                    ],
                    'error-page' => [
                        'icon' => '',
                        'route_name' => 'error-page',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Error Page'
                    ],
                    'update-profile' => [
                        'icon' => '',
                        'route_name' => 'update-profile',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Update profile'
                    ],
                    'change-password' => [
                        'icon' => '',
                        'route_name' => 'change-password',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Change Password'
                    ]
                ]
            ],
            'devider',
            'components' => [
                'icon' => 'inbox',
                'title' => 'Components',
                'sub_menu' => [
                    'grid' => [
                        'icon' => '',
                        'title' => 'Grid',
                        'sub_menu' => [
                            'regular-table' => [
                                'icon' => '',
                                'route_name' => 'regular-table',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Regular Table'
                            ],
                            'tabulator' => [
                                'icon' => '',
                                'route_name' => 'tabulator',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Tabulator'
                            ]
                        ]
                    ],
                    'overlay' => [
                        'icon' => '',
                        'title' => 'Overlay',
                        'sub_menu' => [
                            'modal' => [
                                'icon' => '',
                                'route_name' => 'modal',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Modal'
                            ],
                            'slide-over' => [
                                'icon' => '',
                                'route_name' => 'slide-over',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Slide Over'
                            ],
                            'notification' => [
                                'icon' => '',
                                'route_name' => 'notification',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Notification'
                            ],
                        ]
                    ],
                    'accordion' => [
                        'icon' => '',
                        'route_name' => 'accordion',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Accordion'
                    ],
                    'button' => [
                        'icon' => '',
                        'route_name' => 'button',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Button'
                    ],
                    'alert' => [
                        'icon' => '',
                        'route_name' => 'alert',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Alert'
                    ],
                    'progress-bar' => [
                        'icon' => '',
                        'route_name' => 'progress-bar',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Progress Bar'
                    ],
                    'tooltip' => [
                        'icon' => '',
                        'route_name' => 'tooltip',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Tooltip'
                    ],
                    'dropdown' => [
                        'icon' => '',
                        'route_name' => 'dropdown',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Dropdown'
                    ],
                    'typography' => [
                        'icon' => '',
                        'route_name' => 'typography',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Typography'
                    ],
                    'icon' => [
                        'icon' => '',
                        'route_name' => 'icon',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Icon'
                    ],
                    'loading-icon' => [
                        'icon' => '',
                        'route_name' => 'loading-icon',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Loading Icon'
                    ]
                ]
            ],
            'forms' => [
                'icon' => 'sidebar',
                'title' => 'Forms',
                'sub_menu' => [
                    'regular-form' => [
                        'icon' => '',
                        'route_name' => 'regular-form',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Regular Form'
                    ],
                    'datepicker' => [
                        'icon' => '',
                        'route_name' => 'datepicker',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Datepicker'
                    ],
                    'tom-select' => [
                        'icon' => '',
                        'route_name' => 'tom-select',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Tom Select'
                    ],
                    'file-upload' => [
                        'icon' => '',
                        'route_name' => 'file-upload',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'File Upload'
                    ],
                    'wysiwyg-editor' => [
                        'icon' => '',
                        'title' => 'Wysiwyg Editor',
                        'sub_menu' => [
                            'wysiwyg-editor-classic' => [
                                'icon' => '',
                                'route_name' => 'wysiwyg-editor-classic',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Classic'
                            ],
                            'wysiwyg-editor-inline' => [
                                'icon' => '',
                                'route_name' => 'wysiwyg-editor-inline',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Inline'
                            ],
                            'wysiwyg-editor-balloon' => [
                                'icon' => '',
                                'route_name' => 'wysiwyg-editor-balloon',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Balloon'
                            ],
                            'wysiwyg-editor-balloon-block' => [
                                'icon' => '',
                                'route_name' => 'wysiwyg-editor-balloon-block',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Balloon Block'
                            ],
                            'wysiwyg-editor-document' => [
                                'icon' => '',
                                'route_name' => 'wysiwyg-editor-document',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Document'
                            ],
                        ]
                    ],
                    'validation' => [
                        'icon' => '',
                        'route_name' => 'validation',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Validation'
                    ]
                ]
            ],
            'widgets' => [
                'icon' => 'hard-drive',
                'title' => 'Widgets',
                'sub_menu' => [
                    'chart' => [
                        'icon' => '',
                        'route_name' => 'chart',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Chart'
                    ],
                    'slider' => [
                        'icon' => '',
                        'route_name' => 'slider',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Slider'
                    ],
                    'image-zoom' => [
                        'icon' => '',
                        'route_name' => 'image-zoom',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Image Zoom'
                    ]
                ]
            ]
        ];
    }
}