<?php

use yii\widgets\Menu;

?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        try {
            echo Menu::widget([
                'items' => [
                    ['label' => '', 'options' => ['class' => 'header']],

                    ['label' => sprintf('<i class="fa fa-newspaper-o" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Bootcamps'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['bootcamp/create']],
                            ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['bootcamp/index']],
                            ['label' => sprintf('<i class="fa fa-list-alt" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Gallery'),
                                'url' => ['#'],
                                'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                                'items' => [
                                    ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['gallery/create']],
                                    ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['gallery/index']],
                                ],
                                'options' => ['class' => 'treeview'],
                            ],
                            ['label' => sprintf('<i class="fa fa-list-alt" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Logo'),
                                'url' => ['#'],
                                'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                                'items' => [
                                    ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['logo/create']],
                                    ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['logo/index']],
                                ],
                                'options' => ['class' => 'treeview'],
                            ],
                        ],
                        'options' => ['class' => 'treeview'],
                    ],
                    ['label' => sprintf('<i class="fa fa-users" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Persons(Mentors,Speakers)'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['person/create']],
                            ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['person/index']],
                        ],
                        'options' => ['class' => 'treeview'],
                    ],
                    ['label' => sprintf('<i class="fa fa-calendar" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Agenda'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['agenda/create']],
                            ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['agenda/index']],
                        ],
                        'options' => ['class' => 'treeview'],
                    ],
                    ['label' => sprintf('<i class="fa fa-book" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Program'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => sprintf('<i class="fa fa-list-alt" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Category'),
                                'url' => ['#'],
                                'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                                'items' => [
                                    ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['learning-category/create']],
                                    ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['learning-category/index']],
                                ],
                                'options' => ['class' => 'treeview'],
                            ],
                            ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['learning/create']],
                            ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['learning/index']],
                        ],
                        'options' => ['class' => 'treeview'],
                    ],
                    ['label' => sprintf('<i class="fa fa-user-circle-o" aria-hidden="true"></i> <span> %s </span> <i class="fa fa-angle-left pull-right"></i>', 'Participants'),
                        'url' => ['#'],
                        'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                        'items' => [
                            ['label' => sprintf('<i class="fa fa-plus-circle"></i> %s', 'Create'), 'url' => ['profile/create']],
                            ['label' => sprintf('<i class="fa fa-table"></i> %s', 'List'), 'url' => ['profile/index']],
                        ],
                        'options' => ['class' => 'treeview'],
                    ],
                    ['label' => sprintf('<i class="fa fa-cog"></i> %s', 'Setting'), 'url' => ['/settings']],
                ],
                'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
                'submenuTemplate' => "<ul class='treeview-menu'>{items}</ul>",
                'encodeLabels' => false,
                'activateParents' => true,
            ]);
        } catch (Exception $e) {
            Yii::error($e->getMessage(), 'app');
        }
        ?>
    </section>
</aside>
