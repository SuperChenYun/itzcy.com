<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateLinkTableV1 extends Migrator
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
        // create the table
        $table = $this -> table('link', array('engine' => 'InnoDB'));
        $table -> addColumn('site_name', 'string', array('limit' => 256, 'default' => '', 'comment' => '站点名称'))
            -> addColumn('site_link', 'string', array('limit' => 512, 'default' => '', 'comment' => '站点链接'))
            -> addColumn('link_type', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '交换类型：1对等交换，2交叉交换'))
            -> addColumn('in_site_link', 'string', array('limit' => 512, 'default' => '', 'comment' => '在对方的链接位置'))
            -> addColumn('audit_pass', 'boolean', array('limit' => 1, 'default' => 0, 'comment' => '是否审核通过'))
            // 联系方式
            -> addColumn('contact_name', 'string', array('limit' => 128, 'default' => '', 'comment' => '联系人姓名'))
            -> addColumn('contact_email', 'string', array('limit' => 64, 'default' => '', 'comment' => '联系邮箱'))
            -> addColumn('contact_qq', 'string', array('limit' => 32, 'default' => '', 'comment' => '联系QQ'))
            -> addColumn('contact_wechat', 'string', array('limit' => 32, 'default' => '', 'comment' => '联系微信'))
            -> addColumn('remarks', 'string', array('limit' => 512, 'default' => '', 'comment' => '备注'))
            -> addColumn('order_id', 'integer', array('limit' => 11, 'default' =>  0, 'comment' => '排序'))
            // 时间信息
            -> addColumn('create_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '添加时间'))
            -> addColumn('update_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '修改时间'))
            -> addColumn('delete_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '删除时间'))
            // 其他设置
            -> setPrimaryKey('id')
            -> setComment('外链表')
            -> create();
    }
}
