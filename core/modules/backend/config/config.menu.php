<?php


return new \Phalcon\Config(
    [
        /**
         * In every menu (include sub-menu), we must have 3 element in array:
         * @param code : name of controller, action assigned in controller
         * @param name : name to show to user
         * @param sub  : sub menu. let empty array if this menu hasn't sub menu
         */
        'menuStruct'  => [
            [
                'code'  =>  'dashboard',
                'name'  =>  '仪表盘',
                'icon'  =>  'fa fa-dashboard',
                'sub'   =>  []
            ],
            [
                'code'  =>  'orders',
                'name'  =>  '订单',
                'icon'  =>  'fa fa-truck',
                'sub'   =>  [
                    [
                        "code"  =>  "index",
                        "name"  =>  "订单",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index1",
                        "name"  =>  "发票",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index2",
                        "name"  =>  "Avoirs",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index3",
                        "name"  =>  "交货单",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index4",
                        "name"  =>  "购物车",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                ]
            ],
            [
                'code'  =>  'categroies',
                'name'  =>  '分类',
                'icon'  =>  'fa fa-bars',
                'sub'   =>  [
                    [
                        "code"  =>  "index",
                        "name"  =>  "产品",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "分类",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "Attributes & Features",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "Brands & Suppliers",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "文件",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "折扣",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "库存",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ]
                ]
            ],
            [
                'code'  =>  'customers',
                'name'  =>  '客户',
                'icon'  =>  'fa fa-user',
                'sub'   =>  [
                    [
                        "code"  =>  "index",
                        "name"  =>  "客户",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "地址",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ]
                ]
            ],
            [
                'code'  =>  'customers',
                'name'  =>  '客户服务',
                'icon'  =>  'fa fa-newspaper-o',
                'sub'   =>  [
                    [
                        "code"  =>  "index",
                        "name"  =>  "客户服务",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "定义消息",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "Retours produit",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                ]
            ],
            [
                'code'  =>  'modules',
                'name'  =>  '模块',
                'icon'  =>  'fa fa-th-large',
                'sub'   =>  [
                    [
                        "code"  =>  "index",
                        "name"  =>  "模块&服务",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "模块分类",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                ]
            ],
            [
                'code'  =>  'themes',
                'name'  =>  '主题',
                'icon'  =>  'fa fa-diamond',
                'sub'   =>  [
                    [
                        "code"  =>  "index",
                        "name"  =>  "主题&logo",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "主题分类",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "网页",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "位置",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                    [
                        "code"  =>  "index",
                        "name"  =>  "图片设置",
                        "icon"  =>  "",
                        "sub"   =>  []
                    ],
                ]
            ],
            [
                'code'  =>  'stats',
                'name'  =>  '统计信息',
                'icon'  =>  'fa fa-bar-chart-o',
                'sub'   =>  []
            ],
        ]

    ]
);
