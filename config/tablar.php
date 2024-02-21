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
            'path' => 'assets/escudo.png',
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
            'icon' => 'ti ti-user-circle',
            'can' => 'roles.index',
            'active' => ['support1'],
            'submenu' => [
                [
                    'text' => 'Rol',
                    'icon' => 'ti ti-user-circle',
                    'active' => ['support2'],
                    'can' => 'roles.index',
                    'submenu' => [
                        [
                            'text' => 'Roles',
                            'route' => 'roles.index',
                            'icon' => 'ti ti-user-check',
                            'can' => 'roles.index',
                        ],
                        [
                            'text' => 'Permisos',
                            'route' => 'permissions.index',
                            'icon' => 'ti ti-user-minus',
                            'can' => 'permissions.index',
                        ],
                        [
                            'text' => 'Usuarios',
                            'route' => 'asignar.index',
                            'icon' => 'ti ti-user-plus',
                            'can' => 'asignar.index',
                        ],
                    ],

                ],
                [
                    'text' => 'Datos Geograficos',
                    'icon' => 'ti ti-map-pin-filled',
                    'can' => 'provincias.index',
                    'submenu' => [
                        [
                            'text' => 'Provincias',
                            'route' => 'provincias.index',
                            'icon' => 'ti ti-map-pin-star',
                            'can' => 'provincias.index',
                        ],
                        [
                            'text' => 'Cantones',
                            'route' => 'cantons.index',
                            'icon' => 'ti ti-map-pin-plus',
                            'can' => 'cantons.index',
                        ],
                        [
                            'text' => 'Parroquias',
                            'route' => 'parroquias.index',
                            'icon' => 'ti ti-map-pin-minus',
                            'can' => 'parroquias.index',
                        ],
                    ],
                ],
                [
                    'text' => 'Personal',
                    'icon' => 'ti ti-users',
                    'can' => 'sangres.index',
                    'submenu' => [
                        [
                            'text' => 'Tipo Sangre',
                            'route' => 'sangres.index',
                            'icon' => 'ti ti-users-plus',
                            'can' => 'sangres.index',
                        ],
                        [
                            'text' => 'Grado',
                            'route' => 'grados.index',
                            'icon' => 'ti ti-stars-filled',
                            'can' => 'grados.index',
                        ],
                        [
                            'text' => 'Rango',
                            'route' => 'rangos.index',
                            'icon' => 'ti ti-star',
                            'can' => 'rangos.index',
                        ],
                    ],
                ],
                [
                    'text' => 'Vehículo',
                    'icon' => 'ti ti-car',
                    'can' => 'tvehiculos.index',
                    'submenu' => [
                        [
                            'text' => 'Tipo Vehículo',
                            'route' => 'tvehiculos.index',
                            'icon' => 'ti ti-circle-plus',
                            'can' => 'tvehiculos.index',
                        ],
                        [
                            'text' => 'Marca',
                            'route' => 'marcas.index',
                            'icon' => 'ti ti-library-plus',
                            'can' => 'marcas.index',
                        ],
                        [
                            'text' => 'Modelo',
                            'route' => 'modelos.index',
                            'icon' => 'ti ti-square-rounded-plus',
                            'can' => 'modelos.index',
                        ],                       
                        [
                            'text' => 'Capacidad Carga',
                            'route' => 'vcargas.index',
                            'icon' => 'ti ti-truck-loading',
                            'can' => 'vcargas.index',
                        ],
                        [
                            'text' => 'Capacidad Pasajero',
                            'route' => 'vpasajeros.index',
                            'icon' => 'ti ti-users-group',
                            'can' => 'vpasajeros.index',
                        ],
                        [
                            'text' => 'Vehículo Eliminado',
                            'route' => 'vehieliminacions.index',
                            'icon' => 'ti ti-car-crash',
                            'can' => 'vehieliminacions.index',
                        ],
                    ],
                ],
                [
                    'text' => 'Mantenimiento',
                    'icon' => 'ti ti-car-garage',
                    'can' => 'mantetipos.index',
                    'submenu' => [
                        [
                            'text' => 'Tipo Mantenimiento',
                            'route' => 'mantetipos.index',
                            'icon' => 'ti ti-settings',
                            'can' => 'mantetipos.index',
                        ],
                        [
                            'text' => 'Tipo Novedades',
                            'route' => 'tnovedades.index',
                            'icon' => 'ti ti-settings-2',
                            'can' => 'tnovedades.index',
                        ],
                    ],
                ],
                [
                    'text' => 'Estados',
                    'icon' => 'ti ti-category',
                    'can' => 'estados.index',
                    'submenu' => [
                        [
                            'text' => 'General',
                            'route' => 'estados.index',
                            'icon' => 'ti ti-category-2',
                            'can' => 'estados.index',
                        ],
                        [
                            'text' => 'Asignación',
                            'route' => 'asignacions.index',
                            'icon' => 'ti ti-category-plus',
                            'can' => 'asignacions.index',
                        ],
                        [
                            'text' => 'Mantenimiento',
                            'route' => 'mantestados.index',
                            'icon' => 'ti ti-category-minus',
                            'can' => 'mantestados.index',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Dependencia',
            'icon' => 'ti ti-home-star',
            'active' => ['dependencias'],
            'can' => 'dependencias.index',
            'submenu' => [
                [
                    'text' => 'Distrito',
                    'route' => 'distritos.index',
                    'icon' => 'ti ti-map-star',
                    'can' => 'distritos.index',
                ],
                [
                    'text' => 'Circuito',
                    'route' => 'circuitos.index',
                    'icon' => 'ti ti-map-plus',
                    'can' => 'circuitos.index',
                ],
                [
                    'text' => 'Subcircuito',
                    'route' => 'subcircuitos.index',
                    'icon' => 'ti ti-map-minus',
                    'can' => 'subcircuitos.index',
                ],
                [
                    'text' => 'Lista Dependencias',
                    'route' => 'dependencias.index',
                    'icon' => 'ti ti-map',
                    'can' => 'dependencias.index',
                ],
            ],
        ],
        [
            'text' => 'Personal',
            'icon' => 'ti ti-user',
            'active' => ['user'],
            'route' => 'users.index',
            'can' => 'users.index',
        ],
        [
            'text' => 'Flota Vehicular',
            'icon' => 'ti ti-car',
            'active' => ['flota_vehicular'],
            'route' => 'vehiculos.index',
            'can' => 'vehiculos.index',
        ],
        [
            'text' => 'Asignación Subcircuito',
            'icon' => 'ti ti-home-check',
            'can' => 'usersubcircuitos.index',
            'active' => ['asignacion'],
            'submenu' => [
                [
                    'text' => 'Usuario',
                    'route' => 'usersubcircuitos.index',
                    'icon' => 'ti ti-user',
                    'can' => 'usersubcircuitos.index',
                ],
                [
                    'text' => 'Vehículo',
                    'route' => 'vehisubcircuitos.index',
                    'icon' => 'ti ti-car',
                    'can' => 'vehisubcircuitos.index',
                ],
                [
                    'text' => 'Vehículo - Usuario',
                    'route' => 'asignarvehiculos.index',
                    'icon' => 'ti ti-car-suv',
                    'can' => 'asignarvehiculos.index',
                ], 
                
            ],
        ],
        [
            'text' => 'Mantenimiento',
            'icon' => 'ti ti-car-garage',
            'active' => ['mantenimiento'],
            'submenu' => [
                [
                    'text' => 'Registro Mantenimiento',
                    'route' => 'mantenimientos.create',
                    'icon' => 'ti ti-registered',
                    'can' => 'mantenimientos.create',
                ],
                [
                    'text' => 'Novedades',
                    'route' => 'novedades.index',
                    'icon' => 'ti ti-inbox',
                    'can' => 'novedades.index',
                ],
                [
                    'text' => 'Recepción Vehículo',
                    'route' => 'vehirecepciones.index',
                    'icon' => 'ti ti-receipt',
                    'can' => 'vehirecepciones.index',
                ],
                [
                    'text' => 'Entrega Vehículo',
                    'route' => 'vehientregas.index',
                    'icon' => 'ti ti-checklist',
                    'can' => 'vehientregas.index',
                ],
            ],
        ],
        [
            'text' => 'Reporte',
            'icon' => 'ti ti-report',
            'active' => ['reporte'],
            'can' => 'reportes.index',
            'submenu' => [
                [
                    'text' => 'General',
                    'url' => 'general',
                    'icon' => 'ti ti-report-analytics',
                    'can' => 'general.index',
                ],
                [
                    'text' => 'Categorias',
                    'route' => 'reportes.index',
                    'icon' => 'ti ti-file-description',
                    'can' => 'reportes.index',
                ],
            ],
        ],
        [
            'text' => 'Reclamos',
            'icon' => 'ti ti-home-check',
            'active' => ['reclamos'],
            'submenu' => [
                [
                    'text' => 'Reclamos',
                    'route' => 'reclamos.index',
                    'icon' => 'ti ti-file-description',
                    //'can' => 'reclamos.index',
                ],
                [
                    'text' => 'Tipo Reclamos',
                    'route' => 'treclamos.index',
                    'icon' => 'ti ti-file-description',
                    //'can' => 'treclamos.index',
                ],
                [
                    'text' => 'Reporte Reclamos',
                    'route' => 'reclamo.reporteReclamo',
                    'icon' => 'ti ti-file-description',
                    //'can' => 'reclamo.reporteReclamo',
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
