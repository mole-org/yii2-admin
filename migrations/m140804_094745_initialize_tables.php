<?php

use yii\db\Schema;
use yii\db\Migration;

class m140804_094745_initialize_tables extends Migration
{
    public function safeUp()
    {
        $table = '{{%admin}}';
//         $this->createTable($table, [
//             'id' => 'pk',
//             'admin_role_id' => "integer NOT NULL DEFAULT '0' COMMENT '角色ID'",
//             'parent_id' => "integer NOT NULL DEFAULT '0' COMMENT '创建者ID'",
//             'parent_path' => "string NOT NULL DEFAULT '' COMMENT '父路径'",
//             'username' => "string(25) NOT NULL DEFAULT '' COMMENT '用户名'",
//             'password' => "string(33) NOT NULL DEFAULT '' COMMENT '密码'",
//             'realname' => "string(25) NOT NULL DEFAULT '' COMMENT '真实姓名'",
//             'status' => "boolean NOT NULL DEFAULT '1' COMMENT '> 0均为正常状态类型；<= 0 均为非正常状态，其值为操作者ID负数。'",
//             'last_ip' => "string(128) NOT NULL DEFAULT '' COMMENT '最后登录IP'",
//             'create_time' => "integer NOT NULL DEFAULT '0' COMMENT '创建时间'",
//             'update_time' => "integer NOT NULL DEFAULT '0' COMMENT '修改时间'",
//             'last_time' => "integer NOT NULL DEFAULT '0' COMMENT '最后登录时间'",
//         ]);
        $this->createTable($table, [
            'id' => 'pk',
            'admin_role_id' => "integer NOT NULL DEFAULT '0'",
            'parent_id' => "integer NOT NULL DEFAULT '0'",
            'parent_path' => "string NOT NULL DEFAULT ''",
            'username' => "string(25) NOT NULL DEFAULT ''",
            'password' => "string(33) NOT NULL DEFAULT ''",
            'realname' => "string(25) NOT NULL DEFAULT ''",
            'status' => "boolean NOT NULL DEFAULT '1'",
            'last_ip' => "string(128) NOT NULL DEFAULT ''",
            'create_time' => "integer NOT NULL DEFAULT '0'",
            'update_time' => "integer NOT NULL DEFAULT '0'",
            'last_time' => "integer NOT NULL DEFAULT '0'",
        ]);
        
        $columns = [
            'id', 'admin_role_id', 'parent_id', 'parent_path',
            'username', 'password', 'realname', 'status',
            'last_ip', 'create_time', 'update_time', 'last_time'
        ];
        $rows = [
            [1,1,0,',0,','admin','21232f297a57a5a743894a0e4a801fc3','Admin',1,'127.0.0.1',1453341067,1453341067,1453341067]
        ];
        $this->batchInsert($table, $columns, $rows);
        $this->createIndex('username_UNIQUE', $table, 'username', true);

        $table = '{{%admin_role}}';
//         $this->createTable($table, [
//             'id' => 'pk',
//             'admin_id' => "integer NOT NULL DEFAULT '0' COMMENT '创建者ID'",
//             'admin_path' => "string NOT NULL DEFAULT '' COMMENT '父路径'",
//             'honor' => "string(15) NOT NULL DEFAULT '' COMMENT '头衔'",
//             'acls' => "text NOT NULL COMMENT '权限，JSON字符串存储'",
//             'create_time' => "integer(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
//             'update_time' => "integer(11) NOT NULL DEFAULT '0' COMMENT '修改时间'",
//         ]);
        $this->createTable($table, [
            'id' => 'pk',
            'admin_id' => "integer NOT NULL DEFAULT '0'",
            'admin_path' => "string NOT NULL DEFAULT ''",
            'honor' => "string(15) NOT NULL DEFAULT ''",
            'acls' => "text NOT NULL",
            'create_time' => "integer(11) NOT NULL DEFAULT '0'",
            'update_time' => "integer(11) NOT NULL DEFAULT '0'",
        ]);
        $columns = ['id', 'admin_id', 'admin_path', 'honor', 'acls', 'create_time', 'update_time'];
        $rows = [
            [1,1,',0,1,','超级管理员','{}',1453341067,1453341067]
        ];
        $this->batchInsert($table, $columns, $rows);
    }

    public function safeDown()
    {
        $this->dropTable('{{%admin}}');
        $this->dropTable('{{%admin_role}}');
    }
}
