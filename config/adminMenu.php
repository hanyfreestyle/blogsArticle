<?php

$MenuView = [
//    'Permissions'=>false,
    'Update' => false,
    'AppPuzzle' => false,
//    'Data'=>false,
//    'AdminLang'=>false,
//    'WebLang'=>false,
//    'Setting'=>false,
//    'LeadsFrom'=>false,
//    'AppSetting'=>false,
//    'AppPuzzle'=>false,
//    'Product'=>false,
//    'FAQ'=>false,
//    'BlogPost'=>false,
];

return [
    'menu' => [
        [
            'view' => IsMenuView($MenuView, "BlogPost",'blogPost.php'),
            'sel_routs' => 'Blog',
            'type' => 'many',
            'text' => 'admin/blogPost.app_menu',
            'icon' => 'fab fa-blogger',
            'roleView' => 'Blog_view',
            'submenu' => [
                [
                    'sel_routs' => 'BlogCategory',
                    'url' => 'Blog.BlogCategory.index',
                    'roleView' => 'Blog_view',
                    'text' => 'admin/blogPost.app_menu_category',
                    'icon' => 'fas fa-sitemap',
                    'view' => true
                ],
                [
                    'sel_routs' => 'BlogPost',
                    'url' => 'Blog.BlogPost.index',
                    'roleView' => 'Blog_view',
                    'text' => 'admin/blogPost.app_menu_blog',
                    'icon' => 'fas fa-rss',
                    'view' => true
                ],
                [
                    'sel_routs' => 'BlogTags',
                    'url' => 'Blog.BlogTags.index',
                    'roleView' => 'Blog_view',
                    'text' => 'admin/blogPost.app_menu_tags',
                    'icon' => 'fas fa-hashtag',
                    'view' => true
                ],
            ],

        ], #BlogPost
        [
            'view' => IsMenuView($MenuView, "Permissions"),
            'sel_routs' => 'users',
            'type' => 'many',
            'text' => 'admin/config/roles.menu_roles',
            'icon' => 'fas fa-unlock-alt',
            'roleView' => 'users_view',
            'submenu' => [
                ['roleView' => 'users_view', 'text' => 'admin/config/roles.menu_roles_users', 'url' => 'users.users.index', 'sel_routs' => 'users', 'icon' => 'fas fa-users', 'view' => true],
                ['roleView' => 'roles_view', 'text' => 'admin/config/roles.menu_roles_role', 'url' => 'users.roles.index', 'sel_routs' => 'roles', 'icon' => 'fas fa-traffic-light', 'view' => true],
                ['roleView' => 'roles_view', 'text' => 'admin/config/roles.menu_roles_permissions', 'url' => 'users.permissions.index', 'sel_routs' => 'permissions', 'icon' => 'fas fa-user-shield', 'view' => true],
            ],

        ], #Permissions
        [
            'view' => IsMenuView($MenuView, "AdminLang"),
            'sel_routs' => 'adminlang',
            'type' => 'one',
            'text' => 'admin.app_menu_lang_admin',
            'url' => 'adminlang.index',
            'icon' => 'fas fa-language',
            'roleView' => 'adminlang_view',
        ], #Admin Lang
        [
            'view' => IsMenuView($MenuView, "WebLang"),
            'sel_routs' => 'weblang',
            'type' => 'one',
            'text' => 'admin.app_menu_lang_web',
            'url' => 'weblang.index',
            'icon' => 'fas fa-language',
            'roleView' => 'weblang_view',
        ], #Web Lang
        [
            'view' => IsMenuView($MenuView, "Data"),
            'sel_routs' => 'data',
            'type' => 'many',
            'text' => 'admin.app_menu_data',
            'icon' => 'fas fa-server',
            'roleView' => 'data_view',
            'submenu' => [
                ['roleView' => 'country_view', 'text' => 'admin/dataCountry.app_menu', 'url' => 'data.Country.index', 'sel_routs' => 'Country', 'icon' => 'fas fa-globe-americas', 'view' => IsMenuView($MenuView, "Data",'data/country.php') ],
            ],
        ], #Data
        [
            'view' => IsMenuView($MenuView, "Setting"),
            'sel_routs' => 'config',
            'type' => 'many',
            'text' => 'admin.app_menu_setting',
            'icon' => 'fas fa-cogs',
            'roleView' => 'config_view',
            'submenu' => [
                ['roleView' => 'config_website', 'text' => 'admin/config/webConfig.app_menu', 'url' => 'config.web.index', 'sel_routs' => 'web', 'icon' => 'fas fa-cog', 'view' => true],
                ['roleView' => 'config_meta_view', 'text' => 'admin/configMeta.app_menu', 'url' => 'config.Meta.index', 'sel_routs' => 'Meta', 'icon' => 'fab fa-html5', 'view' => IsMenuView($MenuView, "Setting",'config/configMeta.php')],
                ['roleView' => 'config_defPhoto_view', 'text' => 'admin/config/upFilter.app_menu_def_photo', 'url' => 'config.defPhoto.index', 'sel_routs' => 'defPhoto', 'icon' => 'fas fa-image', 'view' => true],
                ['roleView' => 'config_upFilter_view', 'text' => 'admin/config/upFilter.app_menu', 'url' => 'config.upFilter.index', 'sel_routs' => 'upFilter', 'icon' => 'fas fa-filter', 'view' => true],
                ['roleView' => 'config_web_privacy', 'text' => 'admin/configPrivacy.app_menu', 'url' => 'config.WebPrivacy.index', 'sel_routs' => 'WebPrivacy', 'icon' => 'fas fa-file-alt', 'view' => IsMenuView($MenuView, "Setting",'config/webPrivacy.php')],
                ['roleView' => 'config_newsletter', 'text' => 'admin/leadsNewsLetter.app_menu', 'url' => 'config.NewsLetter.index', 'sel_routs' => 'NewsLetter', 'icon' => 'fas fa-mail-bulk', 'view' => IsMenuView($MenuView, "Setting",'leads/newsLetter.php'),],
                ['roleView' => 'sitemap_view', 'text' => 'admin/configSitemap.app_menu', 'url' => 'config.SiteMap.index', 'sel_routs' => 'SiteMap', 'icon' => 'fas fa-sitemap', 'view' => true],
                ['roleView' => 'config_branch', 'text' => 'admin/configBranch.app_menu', 'url' => 'config.Branch.index', 'sel_routs' => 'Branch', 'icon' => 'fas fa-map-signs', 'view' => IsMenuView($MenuView, "Setting",'config/Branch.php')],

            ],
        ], #Setting
        [
            'view' => IsMenuView($MenuView, "AppPuzzle"),
            'sel_routs' => 'AppPuzzle',
            'type' => 'one',
            'text' => 'AppPuzzle',
            'url' => 'AppPuzzle.IndexModel',
            'icon' => 'fas fa-puzzle-piece',
            'roleView' => 'adminlang_view',
        ], #AppPuzzle
    ],

];

