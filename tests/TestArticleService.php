<?php


use app\service\ArticleService;

class TestArticleService extends TestAAACase
{
    /**
     * @var ArticleService
     */
    private $articleService;
    
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        $request = new \app\Request();
        $this -> articleService = new ArticleService($request, new \app\service\TagService($request));
    }
    
    private function randTagList ()
    {
        return \app\model\TagModel ::where([]) -> limit(rand(1, 5)) -> select();
    }
    
    /**
     * @test
     */
    public function add ()
    {
        $categoryModel = \app\model\CategoryModel ::where(['delete_time' => 0]) -> find();
    
        $article = $this -> articleService -> add(
            'articleTitle',
            '## PageContent',
            '<h2>PageContent</h2>',
            $categoryModel,
            $this -> randTagList(),
            [
                'featured_image' => 'featured_image',
                'keywords'       => 'keywords',
                'describes'      => 'describes',
                'views'          => mt_rand(1, 9999),
                'release_time'   => time(),
            ]
        );
        
        $this -> assertIsObject(
           $article
        );
        
        $this -> assertTrue($article instanceof \app\model\ArticleModel);
    }
    
    /**
     * @test
     */
    public function edit ()
    {
        
        try {
            $articleModel    = \app\model\ArticleModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
            $categoryModel = \app\model\CategoryModel ::where([]) -> order('id', 'desc') -> find();
            
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        $article =  $this -> articleService -> edit(
            $articleModel,
            'articleTitlec',
            '## CPageContent'. time(),
            '<h2>CPageContent</h2>',
            $categoryModel,
            $this -> randTagList(),
            [
                'featured_image' => 'featured_image',
                'keywords'       => 'keywords',
                'describes'      => 'describes',
            ]
        );
        
        $this -> assertIsObject(
            $article
        );
        $this -> assertTrue($article instanceof \app\model\ArticleModel);
    }
    
    /**
     * @test
     * @depends add
     * @depends edit
     */
    public function read ()
    {
        try {
            $article = \app\model\ArticleModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        $this -> assertIsObject(
            $article = $this -> articleService -> read($article -> id)
        );
        
        $this -> assertTrue($article instanceof \app\model\ArticleModel);
        
    }
    
    /**
     * @test
     * @depends add
     * @depends edit
     * @depends read
     * @depends views
     */
    public function remove ()
    {
        try {
            $article = \app\model\ArticleModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        $this -> assertTrue($this -> articleService -> remove($article -> id));
    }
    
    public function lists()
    {
        $count = \app\model\ArticleModel::where(['delete_time' => 0]) -> count();
    
        $list = $this ->articleService->lists();
    
        $this -> assertTrue($count == count($list));
    }
    /**
     * @test
     * @depends read
     */
    public function views ()
    {
        $articleModel = \app\model\ArticleModel ::where([]) -> order('id', 'desc') -> find();
        $articleModel = $this -> articleService -> views($articleModel);
        $this -> assertIsObject($articleModel);
        $this -> assertTrue($articleModel instanceof \app\model\ArticleModel);
        
    }
}