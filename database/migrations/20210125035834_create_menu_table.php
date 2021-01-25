<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateMenuTable extends Migrator
{
    /**
     * Change Method.
     * Write your reversible migrations using this method.
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change ()
    {
        // create the table
        $table = $this -> table('menu', array('engine' => 'InnoDB'));
        $table -> addColumn('menu_text', 'string', array('limit' => 256, 'default' => '', 'comment' => '菜单名称'))
            -> addColumn('menu_link', 'string', array('limit' => 512, 'default' => '', 'comment' => '链接'))
            -> addColumn('pid', 'integer', array('limit' => 11, 'default' => 0, 'comment' => 'PID'))
            -> addColumn('is_target_blank', 'integer', array('limit' => 1, 'default' => 0, 'comment' => '打开方式: 1:新窗口; 0:默认'))
            -> addColumn('menu_sign', 'string', array('limit' => 256, 'default' => '', 'comment' => '菜单唯一标识, PID = 0 时有效'))
            -> addColumn('order_number', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '排序'))
            -> addColumn('status', 'integer', array('limit' => 1, 'default' => 1, 'comment' => '状态 1:显示; 0:隐藏'))
            // 时间信息
            -> addColumn('create_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '添加时间'))
            -> addColumn('update_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '修改时间'))
            -> addColumn('delete_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '删除时间'))
            // 其他设置
            -> setPrimaryKey('id')
            -> setComment('单页表')
            -> create();
        
    }
}
