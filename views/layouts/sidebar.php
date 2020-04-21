<?php
use hoaaah\sbadmin2\widgets\Menu;

    $items = [
        [
            'label' => 'Dashboard',
            'url' => ['/'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-tachometer-alt', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'site/index'
        ],
        [
            'label' => 'Mata Pelajaran',
            'url' => ['site/mapel'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-window-restore', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'category/index'
        ],
        [
            'label' => 'Jadwal',
            'url' => ['site/jadwal'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-clock', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'jadwal/index'
        ],
        [
            'label' => 'Gallery',
            'url' => ['site/gallery'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-photo-video', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'site/gallery'
        ],
        [
            'label' => 'Pengaturan',
            'url' => ['site/setting'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-cog', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'site/setting'
        ],
    ];

echo Menu::widget([
    'options' => [
        'ulClass' => "navbar-nav bg-gradient-primary sidebar sidebar-dark accordion",
        'ulId' => "accordionSidebar"
    ], //  optional
    'brand' => [
        'url' => ['/'],
        'content' => '
            <!--<div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
            </div>-->
            <div class="sidebar-brand-text">LMS Z-Techno</div>        
        '
    ],
    'items' => $items
]);