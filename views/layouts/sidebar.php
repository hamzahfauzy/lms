<?php
use hoaaah\sbadmin2\widgets\Menu;

$items = [];
$user_role = Yii::$app->user->identity->level;
if($user_role == 'Super Admin')
{
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
            'url' => ['category/index'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-window-restore', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'category/index'
        ],
        [
            'label' => 'Bank Soal',
            'url' => ['post/index','PostSearch[post_as]'=>'Soal'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-archive', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'category/index'
        ],
        [
            'label' => 'Siswa (Coming Soon)',
            'url' => ['#'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-users', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'users/index'
        ],
        [
            'label' => 'Guru',
            'url' => ['user/index','UserSearch[level]' => 'Guru'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-users', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'users/index'
        ],
        [
            'label' => 'Semua Pengguna',
            'url' => ['user/index'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-users', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'user/index'
        ],
        [
            'label' => 'Pengaturan',
            'url' => ['site/setting'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-cog', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'site/setting'
        ],
    ];
}
else if(in_array($user_role, ['Guru','Guru Admin']))
{
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
            'url' => ['category/index'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-window-restore', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'category/index'
        ],
        [
            'label' => 'Bank Soal',
            'url' => ['post/index','PostSearch[post_as]'=>'Soal'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-archive', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'category/index'
        ],
        [
            'label' => 'Pengaturan',
            'url' => ['site/setting'], //  Array format of Url to, will be not used if have an items
            'icon' => 'fas fa-fw fa-cog', // optional, default to "fa fa-circle-o
            'visible' => true, // optional, default to true
            'active' => $this->context->route == 'site/setting'
        ],
    ];
}

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