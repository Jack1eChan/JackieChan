<?php

/**
 * Contains all of the translation strings for different activity log
 * events. These should be keyed by the value in front of the colon (:)
 * in the event name. If there is no colon present, they should live at
 * the top level.
 */
return [
    'auth' => [
        'fail' => '登录失败',
        'success' => '登录成功',
        'password-reset' => '重置了密码',
        'reset-password' => '请求重置密码',
        'checkpoint' => '请求双因素身份验证',
        'recovery-token' => '使用了双因素身份验证恢复令牌',
        'token' => '解决了双因素身份验证挑战',
        'ip-blocked' => '阻止了来自未列出的IP地址的请求 :identifier',
        'sftp' => [
            'fail' => 'SFTP 登录失败',
        ],
    ],
    'user' => [
        'account' => [
            'email-changed' => '将电子邮件从 :old 更改为 :new',
            'password-changed' => '修改了密码',
            'username-changed' => '修改用户名从 :old 更改为 :new',
        ],
        'api-key' => [
            'create' => '创建了新的API密钥 :identifier',
            'delete' => '删除了API密钥 :identifier',
        ],
        'ssh-key' => [
            'create' => '将SSH密钥 :fingerprint 添加到账户',
            'delete' => '从账户删除了SSH密钥 :fingerprint',
        ],
        'two-factor' => [
            'create' => '开启了双因素身份验证',
            'delete' => '关闭了双因素身份验证',
        ],
        'store' => [
            'resource-purchase' => '购买了一个资源',
        ],
    ],

    'server' => [
        'reinstall' => '重新安装了服务器',
        'console' => [
            'command' => '在服务器上执行了 ":command"',
        ],
        'power' => [
            'start' => '开启了服务器',
            'stop' => '关闭了服务器',
            'restart' => '重启了服务器',
            'kill' => '强制关闭了服务器',
        ],
        'backup' => [
            'download' => '下载了 :name 备份',
            'delete' => '删除了 :name 备份',
            'restore' => '恢复了 :name 备份 (删除了文件: :truncate)',
            'restore-complete' => '完成 :name 备份的恢复',
            'restore-failed' => '无法完成 :name 备份的恢复',
            'start' => '开始了新的备份 :name',
            'complete' => '将 :name 备份标记为已完成',
            'fail' => '将 :name 备份标记为失败',
            'lock' => '锁定了 :name 备份',
            'unlock' => '解锁了 :name 备份',
        ],
        'database' => [
            'create' => '创建了新的数据库 :name',
            'rotate-password' => '数据库 :name 密码已更改',
            'delete' => '删除了数据库 :name',
        ],
        'file' => [
            'compress_one' => '压缩了 :directory:file',
            'compress_other' => '压缩了 :count 个文件 在 :directory',
            'read' => '查看了 :file',
            'copy' => '复制了 :file',
            'create-directory' => '创建了目录 :directory:name',
            'decompress' => '解压了 :directory 中的 :files',
            'delete_one' => '删除了 :directory:files.0',
            'delete_other' => '删除了 :directory 中的 :count 个文件',
            'download' => '下载了 :file',
            'pull' => '从 :url 下载了远程文件到 :directory',
            'rename_one' => '将 :directory:files.0.from 重命名为 :directory:files.0.to',
            'rename_other' => '在 :directory 中重命名了 :count 个文件',
            'write' => '向 :file 写入了新内容',
            'upload' => '开始文件上传',
            'uploaded' => '上传了 :directory:file',
        ],
        'sftp' => [
            'denied' => '由于权限问题，阻止了 SFTP 访问',
            'create_one' => '创建了 :files.0',
            'create_other' => '创建了 :count 个新文件',
            'write_one' => '修改了 :files.0 的内容',
            'write_other' => '修改了 :count 个文件的内容',
            'delete_one' => '删除了 :files.0',
            'delete_other' => '删除了 :count 个文件',
            'create-directory_one' => '创建了目录 :files.0',
            'create-directory_other' => '创建了 :count 个目录',
            'rename_one' => '将 :files.0.from 重命名为 :files.0.to',
            'rename_other' => '重命名或移动了 :count 个文件',
        ],
        'allocation' => [
            'create' => '添加了 :allocation 到服务器',
            'notes' => '将 :allocation 的备注从 ":old" 修改成 ":new"',
            'primary' => '将 :allocation 设置为首选',
            'delete' => '删除了 :allocation',
        ],
        'schedule' => [
            'create' => '创建了计划 :name',
            'update' => '修改了计划 :name',
            'execute' => '手动执行了计划 :name',
            'delete' => '删除了计划 :name',
        ],
        'task' => [
            'create' => '为计划 :name 创建了新的 ":action" 任务',
            'update' => '更新了计划 :name 的 ":action" 任务',
            'delete' => '删除了计划 :name 的任务',
        ],
        'settings' => [
            'rename' => '将服务器名称从 :old 修改成 :new',
            'description' => '将服务器描述从 :old 修改成 :new',
        ],
        'startup' => [
            'edit' => '将变量 :variable 从 ":old" 修改成 ":new"',
            'image' => '将服务器的Docker镜像从 :old 修改成 :new',
        ],
        'subuser' => [
            'create' => '添加了 :email 为子用户',
            'update' => '为 :email 修改了子用户权限',
            'delete' => '删除了子用户 :email',
        ],
    ],
];
