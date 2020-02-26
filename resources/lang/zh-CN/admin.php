<?php

return [
    'online'                => '在线',
    'login'                 => '登录',
    'logout'                => '登出',
    'setting'               => '设置',
    'name'                  => '名称',
    'username'              => '用户名',
    'password'              => '密码',
    'password_confirmation' => '确认密码',
    'remember_me'           => '记住我',
    'user_setting'          => '用户设置',
    'avatar'                => '头像',
    'list'                  => '列表',
    'new'                   => '新增',
    'create'                => '创建',
    'delete'                => '删除',
    'remove'                => '移除',
    'edit'                  => '编辑',
    'continue_editing'      => '继续编辑',
    'continue_creating'     => '继续创建',
    'view'                  => '查看',
    'detail'                => '详细',
    'browse'                => '浏览',
    'reset'                 => '重置',
    'export'                => '导出',
    'batch_delete'          => '批量删除',
    'save'                  => '保存',
    'refresh'               => '刷新',
    'order'                 => '排序',
    'expand'                => '展开',
    'collapse'              => '收起',
    'filter'                => '筛选',
    'search'                => '搜索',
    'close'                 => '关闭',
    'show'                  => '显示',
    'entries'               => '条',
    'captcha'               => '验证码',
    'action'                => '操作',
    'title'                 => '标题',
    'description'           => '简介',
    'back'                  => '返回',
    'back_to_list'          => '返回列表',
    'submit'                => '提交',
    'menu'                  => '菜单',
    'input'                 => '输入',
    'succeeded'             => '成功',
    'failed'                => '失败',
    'delete_confirm'        => '确认删除?',
    'delete_succeeded'      => '删除成功 !',
    'delete_failed'         => '删除失败 !',
    'update_succeeded'      => '更新成功 !',
    'save_succeeded'        => '保存成功 !',
    'refresh_succeeded'     => '刷新成功 !',
    'login_successful'      => '登录成功 !',
    'choose'                => '选择',
    'choose_file'           => '选择文件',
    'choose_image'          => '选择图片',
    'more'                  => '更多',
    'deny'                  => '无权访问',
    'administrator'         => '管理员',
    'roles'                 => '角色',
    'permissions'           => '权限',
    'slug'                  => '标识',
    'created_at'            => '创建时间',
    'updated_at'            => '更新时间',
    'alert'                 => '注意',
    'parent_id'             => '父级菜单',
    'icon'                  => '图标',
    'uri'                   => '路径',
    'operation_log'         => '操作日志',
    'parent_select_error'   => '父级选择错误',
    'pagination'            => [
        'range' => '从 :first 到 :last ，总共 :total 条',
    ],
    'role'                  => '角色',
    'permission'            => '权限',
    'route'                 => '路由',
    'confirm'               => '确认',
    'cancel'                => '取消',
    'http'                  => [
        'method' => 'HTTP方法',
        'path'   => 'HTTP路径',
    ],
    'all_methods_if_empty'  => '为空默认为所有方法',
    'all'                   => '全部',
    'current_page'          => '当前页',
    'selected_rows'         => '选择的行',
    'upload'                => '上传',
    'new_folder'            => '新建文件夹',
    'time'                  => '时间',
    'size'                  => '大小',
    'listbox'               => [
        'text_total'         => '总共 {0} 项',
        'text_empty'         => '空列表',
        'filtered'           => '{0} / {1}',
        'filter_clear'       => '显示全部',
        'filter_placeholder' => '过滤',
    ],
    'grid_items_selected'    => '已选择 {n} 项',
    'menu_titles'            => [],
    'prev'                   => '上一步',
    'next'                   => '下一步',
    'quick_create'           => '快速创建',
    'help'                  => [
        'product'           => [
            'order'         => '优先级越大排得越靠前',
            'free_domain'   => '前面不用加. ，用逗号或回车结束输入',
            'require_domain'=> '用户订购时，要求用户输入有效域名',
            'ena_stock'     => '启用后，将限制该产品的购买数量，每次下单后库存-1'
        ],
        'config'            => [
            'tos'           => '启用后，用户注册/购买产品需要先同意服务条款',
            'sug'           => '若选择“随机用户名”，则会生成sxxxxxxx样子的用户名（s加7个数字）;
        若选择“从域名生成”，则会取域名中所有字母，若有重复则后加1',
            'site_suu'      => '启用后，整个服务表不允许出现相同用户名的服务（启用之前不算）',
            'site_sdu'      => '启用后，整个服务表不允许出现相同域名的服务（启用之前不算）',
            'admin_email'   => '用于接收系统邮件(如工单提醒)',
            'cron'          => '注意：暂停和停止时间是同时计时的，若时间一致，则优先停止服务',
            'template'      => '点击叉号将其置空则使用默认模板',
            'tpl_settings'  => '下面是模板设置（保存后刷新）',
            'tpl_hp'        => '选中的产品将在首页展示，最多4个'
        ]
    ],
    'config'                    => [
        'register'              => '允许注册',
        'tos'                   => '服务条款(TOS)',
        'tos_url'               => '服务条款URL',
        'sug'                   => '服务用户名生成方式',
        'sug_domain'            => '随机用户名',
        'sug_random'            => '从域名生成',
        'site_suu'              => '全站服务用户名惟一',
        'site_sdu'              => '全站服务域名惟一',
        'admin_email'           => '管理员邮箱',
        'cron'                  => '启用计划任务',
        'suspend_expire'        => '暂停过期服务',
        'suspend_after_days'    => '过期n天后暂停',
        'terminate_expire'      => '停止过期服务',
        'terminate_after_days'  => '过期n天后停止',
        'template'              => '使用模板',
        'tpl_home_product'      => '首页显示推荐产品',
        'enable_udg'            => '启用升/降级',
    ],
    'product'                   => [
        'tab'                   => [
            'base'              => '基础',
            'price'             => '定价',
            'api'               => '接口设置',
        ],
        'ena_stock'             => '启用库存',
        'price'                 => [
            'addItem'           => '添加一条记录（名称留空自动删除）',
            'name'              => '周期名称',
            'period'            => '周期时间',
            'price'             => '周期价格',
            'remark'            => '备注',
            'enable'            => '启用周期',
            'auto_activate'     => '自动开通',
            'allow_renew'       => '允许用本周期续费',
            'day'               => '天',
            'month'             => '月',
            'year'              => '年'
        ],
        'domain'                => [
            'free'              => '免费域名',
            'require'           => '要求提供域名'
        ],
        'server'                => [
            'plugin'            => '服务器类型'
        ]
    ]
];
