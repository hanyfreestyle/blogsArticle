<?php


use Diglactic\Breadcrumbs\Breadcrumbs;


use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('<i class="fa-solid fa-house"></i>' , route('page_index'));
});

Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('web/menu.main_category'), route('categories_list'));
});

Breadcrumbs::for('PagePrivacy', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('web/menu.privacy'), route('PagePrivacy'));
});

Breadcrumbs::for('PageAbout', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('web/menu.main_about'), route('PageAbout'));
});

Breadcrumbs::for('PageReview', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(__('web/menu.main_review'), route('PageReview'));
});















