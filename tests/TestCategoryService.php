<?php


use app\service\CategoryService;

class TestCategoryService extends TestAAACase
{
    /**
     * @var CategoryService
     */
    private $categoryService;
    
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        $this -> categoryService = new CategoryService(new \app\Request());
    }
    
    /**
     * @test
     */
    public function addCategory ()
    {
        $this -> assertIsObject(
            $category = $this -> categoryService -> add(
                'categoryName',
                'categorySign',
                '/img.xxx.jpg',
                'keywords',
                'describe'
            )
        );
        $this -> assertTrue($category instanceof \app\model\CategoryModel);
    }
    
    /**
     * @test
     */
    public function editCategory ()
    {
        
        try {
            $categoryModel = \app\model\CategoryModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        $this -> assertIsObject(
            $category = $this -> categoryService -> edit(
                $categoryModel,
                'categoryName',
                'categorySign2',
                '/img.xxx.jpg',
                'keywords',
                'describe'
            )
        );
        $this -> assertTrue($category instanceof \app\model\CategoryModel);
    }
    
    /**
     * @test
     */
    public function readCategory ()
    {
        try {
            $categoryModel = \app\model\CategoryModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        $this -> assertIsObject(
            $category = $this -> categoryService -> read($categoryModel -> id)
        );
        
        $this -> assertTrue($category instanceof \app\model\CategoryModel);
        
    }
    
    /**
     * @test
     * @depends addCategory
     * @depends editCategory
     * @depends readCategory
     * @depends listsCategory
     */
    public function removeCategory ()
    {
        try {
            $categoryModel = \app\model\CategoryModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        $this -> assertTrue($this -> categoryService -> remove($categoryModel -> id));
    }
    
    /**
     * @test
     */
    public function listsCategory ()
    {
        $this -> assertIsObject(
            $collection = $this -> categoryService -> lists()
        );
        $this -> assertTrue($collection instanceof \think\Collection);
    }
    
}