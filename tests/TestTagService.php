<?php
declare(strict_types=1);


use app\service\TagService;
use think\App;

class TestTagService extends TestAAACase
{
    /**
     * @var TagService
     */
    private $tagService;
    /**
     * @var mixed
     */
    private $article;
    
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        $this -> tagService = new TagService(new \app\Request());
    }
    
    /**
     * @test
     */
    public function addTag ()
    {
        $tagModel = $this -> tagService -> tagAdd('PHPUnit', 'phpunit', 'phpunit describe', 'phpunit,单元测试');
        $this -> assertIsObject(
            $tagModel
        );
        $tag = $tagModel -> toArray();
        $this -> assertArrayHasKey('tag_name', $tag);
        
    }
    
    /**
     * @test
     */
    public function editTag ()
    {
        
        $tagModel = \app\model\TagModel ::where([]) -> order('id', 'desc') -> find();
        $tagModel = $this -> tagService -> tagEdit($tagModel, 'PHPUnitC', 'phpunitC', 'phpunit describe', 'phpunit,单元测试');
        $this -> assertIsObject(
            $tagModel
        );
        $tag = $tagModel -> toArray();
        $this -> assertArrayHasKey('tag_name', $tag);
        
    }
    
    /**
     * @test
     */
    public function readTag ()
    {
        $tagModel = \app\model\TagModel ::where([]) -> order('id', 'desc') -> find();
        
        $this -> assertIsObject(
            $tagModel = $this -> tagService -> tagRead($tagModel -> id)
        );
        
        $tag = $tagModel -> toArray();
        $this -> assertArrayHasKey('tag_name', $tag);
        
        $this -> assertTrue(
            empty($tagModel = $this -> tagService -> tagRead(-3))
        );
        
    }
    
    /**
     * @test
     */
    public function listTag ()
    {
        $count = \app\model\TagModel ::where(['delete_time' => 0]) -> count();
        
        $list = $this -> tagService -> tagList();
        
        $this -> assertTrue($count == count($list));
    }
    
    /**
     * @test
     */
    public function removeTag ()
    {
        
        $tagModel = \app\model\TagModel ::where([]) -> order('id', 'desc') -> find();
        
        $this -> assertTrue(
            $s = $this -> tagService -> tagRemove($tagModel)
        );
        
    }
    
    protected function getArticle ()
    {
        if (!$this->article) {
            $articles        = \app\model\ArticleModel ::select();
            $max             = count($articles);
            $s               = rand(0, $max - 1);
            $this -> article = $articles[$s];
        }
    
        return $this -> article;
    }
    
    /**
     * @test
     */
    public function addTagRelation ()
    {
        $article = $this->getArticle();
        
        $tagModelList = \app\model\TagModel ::where([]) -> limit(rand(1, 5)) -> select();
        
        $this -> assertIsInt(
            $this -> tagService -> relationAdd($article, 1, $tagModelList -> toArray())
        );
    }
    
    /**
     * @test
     * @depends addTagRelation
     */
    public function editTagRelation ()
    {
        $article = $this->getArticle();
        
        $tagModelList = \app\model\TagModel ::where([]) -> order('id', 'desc') -> limit(rand(1, 5)) -> select();
        
        $this -> assertIsInt(
            $this -> tagService -> relationEdit($article, 1, $tagModelList -> toArray())
        );
    }
    
    /**
     * @test
     * @depends  addTagRelation
     */
    public function readTagRelation ()
    {
        $article = $this->getArticle();
        
        $this -> assertIsObject(
            $tagRelations = $this -> tagService -> relationRead($article, 1)
        );
        
        $this -> assertTrue($tagRelations instanceof \think\Collection);
        
        
    }
    
    /**
     * @test
     * @depends addTagRelation
     // * @depends editTagRelation
     * @depends readTagRelation
     */
    public function removeTagRelation ()
    {
        $article = $this->getArticle();
        $this -> assertIsBool($this -> tagService -> relationRemove($article, 1));
    }
}