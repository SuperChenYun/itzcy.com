<?php


use app\service\CategoryService;
use app\service\LinkService;

class TestPageService extends TestCase
{
    
    /**
     * @var \app\service\PageService
     */
    private $pageService;
    
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        $this -> pageService = new \app\service\PageService(new \app\Request());
    }
    
    /**
     * @test
     */
    public function add ()
    {
        $categoryModel = \app\model\CategoryModel ::where(['delete_time' => 0]) -> find();
        $this -> assertIsObject(
            $page = $this -> pageService -> add(
                'pageTitle',
                'PageContent',
                $categoryModel,
                [
                    'featured_image' => 'featured_image',
                    'keywords'       => 'keywords',
                    'describes'      => 'describes',
                    'views'          => mt_rand(1, 9999),
                    'release_time'   => time(),
                ]
            )
        );
        $this -> assertTrue($page instanceof \app\model\PageModel);
    }
    
    /**
     * @test
     */
    public function edit ()
    {
        
        try {
            $pageModel     = \app\model\pageModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
            $categoryModel = \app\model\CategoryModel ::where([]) -> order('id', 'desc') -> find();
            
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        
        $this -> assertIsObject(
            $page = $this -> pageService -> edit(
                $pageModel,
                'pageTitlec',
                'PageContent',
                $categoryModel,
                [
                    'featured_image' => 'featured_image',
                    'keywords'       => 'keywords',
                    'describes'      => 'describes',
                    'views'          => mt_rand(1, 9999),
                    'release_time'   => time(),
                ]
            )
        );
        $this -> assertTrue($page instanceof \app\model\pageModel);
    }
    
    /**
     * @test
     * @depends add
     * @depends edit
     */
    public function read ()
    {
        try {
            $page = \app\model\PageModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        $this -> assertIsObject(
            $page = $this -> pageService -> read($page -> id)
        );
        
        $this -> assertTrue($page instanceof \app\model\PageModel);
        
    }
    
    /**
     * @test
     * @depends add
     * @depends edit
     * @depends read
     */
    public function removeCategory ()
    {
        try {
            $pageModel = \app\model\pageModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        $this -> assertTrue($this -> pageService -> remove($pageModel -> id));
    }
    
    
}