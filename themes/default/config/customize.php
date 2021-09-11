<?php

/**
 * @var \Juzaweb\Support\Theme\Customize $customize
 */

use Juzaweb\Support\Theme\CustomizeControl;

$customize->addPanel('header', [
    'title' => __("juzaweb::app.header"),
    'priority' => 1,
]);

$customize->addSection('menu', [
    'title' => __("juzaweb::app.menu"),
    'priority' => 10,
    'panel' => 'header',
]);

$customize->addSection('menu2', [
    'title' => __('juzaweb::app.menu2'),
    'priority' => 10,
]);

$customize->addSetting('main_menu', [
    'default' => null,
]);

$customize->addSetting('title', [
    'default' => null,
]);

$customize->addControl(new CustomizeControl($customize, 'title', [
    'label' => __('juzaweb::app.title'),
    'section' => 'menu',
    'settings' => 'title',
    'type' => 'text',
]));

$customize->addControl(new CustomizeControl($customize, 'main_menu', [
    'label' => __('juzaweb::app.main_menu'),
    'section' => 'menu2',
    'settings' => 'main_menu',
    'type' => 'textarea',
]));
