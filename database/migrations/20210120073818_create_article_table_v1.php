<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateArticleTableV1 extends Migrator
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
        $table = $this -> table('article', array('engine' => 'InnoDB'));
        $table -> addColumn('title', 'string', array('limit' => 64, 'default' => '', 'comment' => '文章名'))
            -> addColumn('featured_image', 'string', array('limit' => 256, 'default' => '', 'comment' => '特色图像'))
            -> addColumn('release_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '发布时间'))
            // SEO
            -> addColumn('describes', 'string', array('limit' => 512, 'default' => '', 'comment' => '文章简介用于SEO'))
            -> addColumn('keywords', 'string', array('limit' => 512, 'default' => '', 'comment' => '关键字用于SEO'))
            // 内容
            -> addColumn('content_markdown', 'text', array('comment' => 'Markdown 格式的文章'))
            -> addColumn('content', 'text', array('comment' => 'Html 格式的文章'))
            // 原创 转载
            -> addColumn('is_original', 'boolean', array('limit' => 1, 'default' => 1, 'comment' => '是否原创文章'))
            -> addColumn('source_url', 'string', array('limit' => 256, 'default' => '', 'comment' => '原文链接'))
            -> addColumn('source_name', 'string', array('limit' => 256, 'default' => '', 'comment' => '文章来源名称'))
            // 分类数据
            -> addColumn('category_id', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '分类ID'))
            -> addColumn('category_name', 'string', array('limit' => 64, 'default' => '', 'comment' => '分类名称'))
            // 数据统计
            -> addColumn('views', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '浏览数'))
            // 时间信息
            -> addColumn('create_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '添加时间'))
            -> addColumn('update_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '修改时间'))
            -> addColumn('delete_time', 'biginteger', array('limit' => 20, 'default' => 0, 'comment' => '删除时间'))
            // 其他设置
            -> setPrimaryKey('id')
            -> setComment('文章表')
            -> create();
    }
}
