<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateSettingTable extends Migrator
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
        $table = $this -> table('setting', array('engine' => 'InnoDB'));
        $table -> addColumn('key', 'string', array('limit' => 128, 'default' => '', 'comment' => '键'))
            -> addColumn('value', 'string', array('limit' => 512, 'default' => '', 'comment' => '值'))
            -> addColumn('order', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '排序'))
            -> addColumn('extend', 'string', array('limit' => 512, 'default' => '{}', 'comment' => '扩展'))
            // 时间信息
            -> addColumn('create_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '添加时间'))
            -> addColumn('update_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '修改时间'))
            -> addColumn('delete_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '删除时间'))
            // 其他设置
            -> setPrimaryKey('id')
            -> addIndex('key', ['type' => 'unique', 'name' => 'i_u_key'])
            -> setComment('系统设置表')
            -> create();
    }
}
