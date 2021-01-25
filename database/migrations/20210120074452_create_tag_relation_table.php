<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateTagRelationTable extends Migrator
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
        $table = $this -> table('tag_relation', array('engine' => 'InnoDB'));
        $table -> addColumn('tag_id', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '标签id'))
            -> addColumn('relation_type', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '关联类型'))
            -> addColumn('target_id', 'biginteger', array('limit' => 20, 'default' =>  0, 'comment' => '目标ID'))
            // 时间信息
            -> addColumn('create_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '添加时间'))
            -> addColumn('update_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '修改时间'))
            -> addColumn('delete_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '删除时间'))
            // 其他设置
            -> setPrimaryKey('id')
            -> setComment('标签关联表')
            -> create();
    }
}
