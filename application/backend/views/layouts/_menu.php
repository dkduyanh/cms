<?php
use backend\components\widgets\Nav;
use yii\helpers\ArrayHelper;
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if(Yii::$app->user->identity->imageUrl): ?><img src="<?php echo Yii::$app->user->identity->imageUrl; ?>" class="user-image" alt="User Image"><?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst(Yii::$app->user->identity->username); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php echo Nav::widget([
            'activateParents' => true,
            'activeCssClass' => 'active',
            'encodeLabels' => false,
            'linkTemplate' => '<a href="{url}">{label}</a>',
            'labelTemplate' => '{label}',
            'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
            'dropDownCaret' => 'fa fa-angle-left pull-right',
            'itemOptions' => [
                //'class' => 'treeview'
            ],
            'options' => [
                'class' => 'sidebar-menu'
            ],
            'items' => [
                [
                    'label' => 'MAIN NAVIGATION',
                    'options' => ['class'=> 'header'],
                ],
                [
                    'label' => 'Dashboard',
                    'url' => ['site/index'],
                    'icon' => 'fa fa-dashboard'
                ],
                [
                    'label' => 'Manage content',
                    'url' => '#',
                    'options' => ['class' => 'treeview'],
                    'icon' => 'fa fa-edit',
                    'items' => [
                        [
                            'label' => 'Contents',
                            'url' => ['posts/index'],
                            'options' => ['class' => 'treeview'],
                            'icon' => 'fa fa-edit',
                            'items' => Nav::createMenu(ArrayHelper::toArray(\backend\models\cms\Type::listAll(['is_visible' => \backend\models\cms\Type::IS_VISIBLE])), 'name', 'posts/index', ['type' => 'id']),
                            'active' => Yii::$app->controller->id == 'posts',
                        ],
                        [
                            'label' => 'Categories',
                            'url' => ['categories/index'],
                            'icon' => 'fa fa-folder-open',
                            'active' => Yii::$app->controller->id == 'categories',
                        ],
                        [
                            'label' => 'Media',
                            'url' => ['elfinder/index'],
                            'icon' => 'fa fa-camera',
                            'active' => Yii::$app->controller->id == 'elfinder',
                        ],
                        [
                            'label' => 'Tags',
                            'url' => ['tags/index'],
                            'icon' => 'fa fa-tags',
                            'active' => Yii::$app->controller->id == 'tags',
                        ],
                        [
                            'label' => 'Comments',
                            'url' => ['comments/index'],
                            'icon' => 'fa fa-comments',
                            'active' => Yii::$app->controller->id == 'comments',
                        ],
                        [
                            'label' => 'Fields',
                            'url' => ['fields/index'],
                            'icon' => 'fa fa-keyboard-o',
                            'active' => Yii::$app->controller->id == 'fields',
                        ],
                        [
                            'label' => 'Types',
                            'url' => ['types/index'],
                            'icon' => 'fa fa-list',
                            'active' => Yii::$app->controller->id == 'types',
                        ],
                    ]
                ],
                [
                    'label' => 'Manage accounts',
                    'url' => '#',
                    'options' => ['class' => 'treeview'],
                    'icon' => 'fa fa-user',
                    'items' => [
                        [
                            'label' => 'Users',
                            'url' => ['users/index'],
                            'icon' => 'fa fa-user',
                            'active' => Yii::$app->controller->id == 'users',
                        ],
                        [
                            'label' => 'Roles',
                            'url' => ['roles/index'],
                            'icon' => 'fa fa-group',
                            'active' => Yii::$app->controller->id == 'roles',
                        ],
                        [
                            'label' => 'Permissions',
                            'url' => ['permissions/index'],
                            'icon' => 'fa fa-key'
                        ]
                    ]
                ],
                /*[
                    'label' => 'Components',
                    'url' => '#',
                    'options' => ['class' => 'treeview'],
                    'icon' => 'fa fa-table',
                    'items' => [
                        [
                            'label' => 'Menu',
                            'url' => ['menu/index'],
                            'icon' => 'fa fa-caret-right',
                            'active' => Yii::$app->controller->id == 'menu',
                        ],
                        [
                            'label' => 'Email templates',
                            'url' => ['email-templates/index'],
                            'icon' => 'fa fa-caret-right',
                            'active' => Yii::$app->controller->id == 'email-templates',
                        ],
                        [
                            'label' => 'Languages',
                            'url' => ['languages/index'],
                            'icon' => 'fa fa-caret-right',
                            'active' => Yii::$app->controller->id == 'languages'
                        ]
                    ]
                ],*/
                /*[
                    'label' => 'Statistics',
                    'url' => ['statistics/list'],
                    'icon' => 'fa fa-bar-chart',
                    'active' => Yii::$app->controller->id == 'statistics',
                ],*/
                [
                    'label' => 'Settings',
                    'url' => ['configuration/index'], //'#',
                    //'options' => ['class' => 'treeview'],
                    'icon' => 'fa fa-cogs',
                    'active' => Yii::$app->controller->id == 'configuration',
                    /*'items' => [
                        [
                            'label' => 'General',
                            'url' => ['configuration/general'],
                            'icon' => 'fa fa-caret-right',
                        ],
                        [
                            'label' => 'Contact Info',
                            'url' => ['configuration/contact-info'],
                            'icon' => 'fa fa-caret-right',
                        ],
                        [
                            'label' => 'Account settings',
                            'url' => ['configuration/user'],
                            'icon' => 'fa fa-caret-right',
                        ],
                        [
                            'label' => 'All Settings (Advanced)',
                            'url' => ['configuration/index'],
                            'icon' => 'fa fa-caret-right',
                        ]
                    ],*/
                ],
                /*[
                    'label' => 'System',
                    'url' => '#',
                    'options' => ['class' => 'treeview'],
                    'icon' => 'fa fa-server',
                    'items' => [
                        [
                            'label' => 'Logs',
                            'url' => '',
                            'icon' => 'fa fa-file',
                            'items' => [
                                [
                                    'label' => 'Activity Log',
                                    'url' => ['activity-log/list'],
                                    'icon' => 'fa fa-user',
                                ],
                                [
                                    'label' => 'Sytem Log',
                                    'url' => ['sytem-log/list'],
                                    'icon' => 'fa fa-bug',
                                ]
                            ]
                        ],
                        [
                            'label' => 'Cache',
                            'url' => ['site/clear-cache'],
                            'icon' => 'fa fa-trash',
                        ],
                        ['label' => Yii::t('common', 'Send test email'), 'url' => ['site/send-test-email'], 'icon' => 'fa fa-envelope-o'],
                        [
                            'label' => 'Change password',
                            'url' => ['site/change-password'],
                            'icon' => 'fa fa-key',

                        ],
                        [
                            'label' => 'System Information',
                            'url' => ['site/info'],
                            'icon' => 'fa fa-info'
                        ]
                    ]
                ],*/
                [
                    'label' => Yii::t('site', 'Log Out'),
                    'url' => ['site/logout'],
                    'icon' => 'fa fa-sign-out',
                    'template' => '<a href="{url}" data-method="post">{label}</a>'
                ],
            ]
        ]);
        ?>
    </section>
    <!-- /.sidebar -->
</aside>