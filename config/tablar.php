<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    | Here you can change the default title of your admin panel.
    |
    */

    'title' => '',
    'title_prefix' => '',
    'title_postfix' => ' | Mantenimiento Vehicular',
    'bottom_title' => 'Tablar',
    'current_version' => 'v4.8',


    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    */

    'logo' => '<b>Mante</b>Vehic',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can set up an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'assets/tablar-logo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
     *
     * Default path is 'resources/views/vendor/tablar' as null. Set your custom path here If you need.
     */

    'views_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look at the layout section here:
    |
    */

    'layout' => 'combo',
    //boxed, combo, condensed, fluid, fluid-vertical, horizontal, navbar-overlap, navbar-sticky, rtl, vertical, vertical-right, vertical-transparent

    'layout_light_sidebar' => false,
    'layout_light_topbar' => true,
    'layout_enable_top_header' => false,

    /*
    |--------------------------------------------------------------------------
    | Sticky Navbar for Top Nav
    |--------------------------------------------------------------------------
    |
    | Here you can enable/disable the sticky functionality of Top Navigation Bar.
    |
    | For detailed instructions, you can look at the Top Navigation Bar classes here:
    |
    */

    'sticky_top_nav_bar' => false,

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions, you can look at the admin panel classes here:
    |
    */

    'classes_body' => '',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions, you can look at the urls section here:
    |
    */

    'use_route_url' => true,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password.request',
    'password_email_url' => 'password.email',
    'profile_url' => false,
    'setting_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Display Alert
    |--------------------------------------------------------------------------
    |
    | Display Alert Visibility.
    |
    */
    'display_alert' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    |
    */

    'menu' => [
        // Navbar items:
        [
            'text' => 'Home',
            'icon' => 'ti ti-home',
            'url' => 'home'
        ],

        [
            'text' => 'Aministración',
            'url' => '#',
            'icon' => 'ti ti-user-circle',
            'active' => ['support1'],
            'submenu' => [
                [
                    'text' => 'Rol',
                    'url' => '#',
                    'icon' => 'ti ti-circle-plus',
                    'submenu' => [
                        [
                            'text' => 'Roles',
                            'route' => 'roles.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Permisos',
                            'route' => 'permissions.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Usuarios',
                            'route' => 'asignar.index',
                            'icon' => 'ti ti-plus',
                        ],
                    ],
                ],
                [
                    'text' => 'Datos Geograficos',
                    'url' => 'support1',
                    'icon' => 'ti ti-planet',
                    'submenu' => [
                        [
                            'text' => 'Provincias',
                            'route' => 'provincias.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Cantones',
                            'route' => 'cantons.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Parroquias',
                            'route' => 'parroquias.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Distrito',
                            'route' => 'distritos.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Circuito',
                            'route' => 'circuitos.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Subcircuito',
                            'route' => 'subcircuitos.index',
                            'icon' => 'ti ti-plus',
                        ],
                    ],
                ],
                [
                    'text' => 'Personal',
                    'url' => '#',
                    'icon' => 'ti ti-circle-plus',
                    'submenu' => [
                        [
                            'text' => 'Tipo Sangre',
                            'route' => 'sangres.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Grado',
                            'route' => 'grados.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Rango',
                            'route' => 'rangos.index',
                            'icon' => 'ti ti-plus',
                        ],
                    ],
                ],
                [
                    'text' => 'Vehículo',
                    'url' => '#',
                    'icon' => 'ti ti-circle-plus',
                    'submenu' => [
                        [
                            'text' => 'Tipo Vehículo',
                            'route' => 'tvehiculos.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Marca',
                            'route' => 'marcas.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Modelo',
                            'route' => 'modelos.index',
                            'icon' => 'ti ti-plus',
                        ],                       
                        [
                            'text' => 'Capacidad Carga',
                            'route' => 'vcargas.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Capacidad Pasajero',
                            'route' => 'vpasajeros.index',
                            'icon' => 'ti ti-plus',
                        ],
                    ],
                ],
                [
                    'text' => 'Mantenimiento',
                    'url' => '#',
                    'icon' => 'ti ti-circle-plus',
                    'submenu' => [
                        [
                            'text' => 'Tipo Mantenimiento',
                            'route' => 'tmantenimientos.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Novedad Mantenimiento',
                            'route' => 'nmantenimientos.index',
                            'icon' => 'ti ti-plus',
                        ],
                    ],
                ],
                [
                    'text' => 'Estados',
                    'url' => '#',
                    'icon' => 'ti ti-circle-plus',
                    'submenu' => [
                        [
                            'text' => 'General',
                            'route' => 'estados.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Subcircuito',
                            'route' => 'asignacions.index',
                            'icon' => 'ti ti-plus',
                        ],
                        [
                            'text' => 'Mantenimiento',
                            'route' => 'emantenimientos.index',
                            'icon' => 'ti ti-plus',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Dependencia',
            'icon' => 'ti ti-home-star',
            'active' => ['dependencias'],
            'route' => 'dependencias.index',
        ],
        [
            'text' => 'Personal',
            'icon' => 'ti ti-user',
            'active' => ['persona'],
            'route' => 'users.index',
        ],
        [
            'text' => 'Flota Vehicular',
            'icon' => 'ti ti-car',
            'active' => ['flota_vehicular'],
            'route' => 'vehiculos.index',
        ],
        [
            'text' => 'Asignación Subcircuito',
            'icon' => 'ti ti-home-check',
            'active' => ['asignacion'],
            'submenu' => [
                [
                    'text' => 'Personal',
                    'route' => 'usubcircuitos.index',
                    'icon' => 'ti ti-user',
                ],
                [
                    'text' => 'Vehículo',
                    'route' => 'vsubcircuitos.index',
                    'icon' => 'ti ti-car',
                ],
            ],
        ],
        [
            'text' => 'Mantenimiento',
            'icon' => 'ti ti-car-garage',
            'active' => ['mantenimiento'],
            'submenu' => [
                [
                    'text' => 'Registrar',
                    'route' => 'rmantenimientos.create',
                    'icon' => 'ti ti-plus',
                ],
                [
                    'text' => 'Ver Solicitud',
                    'route' => 'rmantenimientos.index',
                    'icon' => 'ti ti-eye-search',
                ],
                [
                    'text' => 'Recepción',
                    'route' => 'rvehiculos.index',
                    'icon' => 'ti ti-receipt',
                ],
                [
                    'text' => 'Entrega',
                    'route' => 'evehiculos.index',
                    'icon' => 'ti ti-checklist',
                ],
            ],
        ],
        [
            'text' => 'Reporte',
            'icon' => 'ti ti-report',
            'active' => ['reporte'],
            'submenu' => [
                [
                    'text' => 'General',
                    'url' => 'reportes',
                    'icon' => 'ti ti-report-analytics',
                ],
                [
                    'text' => 'Modulos',
                    'url' => '#',
                    'icon' => 'ti ti-file-description',
                ],
            ],
        ],
        [
            'text' => 'Examen',
            'icon' => 'ti ti-home-check',
            'active' => ['asignacion'],
            'submenu' => [
                [
                    'text' => 'Reclamos',
                    'route' => 'reclamos.index',
                    'icon' => 'ti ti-file-description',
                ],
                [
                    'text' => 'Tipo Reclamos',
                    'route' => 'treclamos.index',
                    'icon' => 'ti ti-file-description',
                ],
                [
                    'text' => 'Reporte Reclamos',
                    'url' => 'reclamos',
                    'icon' => 'ti ti-file-description',
                ],
                
            ],
        ], 
        

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    |
    */

    'filters' => [
        TakiElias\Tablar\Menu\Filters\GateFilter::class,
        TakiElias\Tablar\Menu\Filters\HrefFilter::class,
        TakiElias\Tablar\Menu\Filters\SearchFilter::class,
        TakiElias\Tablar\Menu\Filters\ActiveFilter::class,
        TakiElias\Tablar\Menu\Filters\ClassesFilter::class,
        TakiElias\Tablar\Menu\Filters\LangFilter::class,
        TakiElias\Tablar\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Vite
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Vite support.
    |
    | For detailed instructions you can look the Vite here:
    | https://laravel-vite.dev
    |
    */

    'vite' => true,
];
