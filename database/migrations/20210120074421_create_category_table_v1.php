<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateCategoryTableV1 extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this -> table('category', array('engine' => 'InnoDB'));
        $table -> addColumn('category_name', 'string', array('limit' => 64, 'default' => '', 'comment' => '分类名'))
            -> addColumn('category_sign', 'string', array('limit' => 64, 'default' => '', 'comment' => '分类唯一标识'))
            -> addColumn('featured_image', 'string', array('limit' => 256, 'default' => '', 'comment' => '文章图'))
            // SEO
            -> addColumn('describes', 'string', array('limit' => 512, 'default' => '', 'comment' => '简介用于SEO'))
            -> addColumn('keywords', 'string', array('limit' => 512, 'default' => '', 'comment' => '关键字用于SEO'))
            // 时间信息
            -> addColumn('create_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '添加时间'))
            -> addColumn('update_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '修改时间'))
            -> addColumn('delete_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '删除时间'))
            // 其他设置
            -> setPrimaryKey('id')
            -> addIndex('category_sign', ['type' => 'unique', 'name' => 'i_u_category_sign'])
            -> setComment('分类表')
            -> create();

    }
}
