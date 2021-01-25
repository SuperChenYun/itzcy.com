<?php


use app\service\ArticleService;

class TestMenuService extends TestAAACase
{
    
    /**
     * @var \app\service\MenuService
     */
    private $menuService;
    
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        $request             = new \app\Request();
        $this -> menuService = new \app\service\MenuService($request);
    }
    
    
    /**
     * @test
     * @depends menuTypes
     */
    public function add ()
    {
        $menuTypes = $this -> menuService -> getMenuTypes();
        $menu      = $this -> menuService -> addMenu('TestMenu', 'http://10.10.1.11', $menuTypes -> shift(), 'TEST_MENU'.time());
        
        $this -> assertIsObject($menu);
        $this -> assertTrue($menu instanceof \app\model\MenuModel);
        
    }
    
    /**
     * @test
     * @depends  add
     */
    public function edit ()
    {
        $lastMenu = \app\model\MenuModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
        $menu     = $this -> menuService -> editMenu($lastMenu, 'TestMenuC', 'http://10.10.1.11', null, '', ['is_target_blank' => 1]);
        
        $this -> assertIsObject($menu);
        $this -> assertTrue($menu instanceof \app\model\MenuModel);
    }
    
    /**
     * @test
     * @depends add
     * @depends edit
     */
    public function read ()
    {
        $lastMenu = \app\model\MenuModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
        
        $menu = $this -> menuService -> readMenu($lastMenu -> id);
        
        $this -> assertIsObject($menu);
        $this -> assertTrue($menu instanceof \app\model\MenuModel);
    }
    
    /**
     * @test
     * @depends add
     * @depends edit
     * @depends read
     */
    public function remove ()
    {
        $lastMenu = \app\model\MenuModel ::where(['delete_time' => 0]) -> order('id', 'desc') -> find();
        
        $s = $this -> menuService -> removeMenu($lastMenu);
        
        $this -> assertTrue($s);
    }
    
    
    /**
     * @test
     */
    public function menuTypes ()
    {
        $menuTypes = $this -> menuService -> getMenuTypes();
        
        \think\facade\Log ::debug(json_encode($menuTypes, JSON_UNESCAPED_UNICODE));
        
        $this -> assertIsObject($menuTypes);
        
        $this -> assertTrue($menuTypes instanceof \think\Collection);
        
    }
    
    /**
     * @test
     * @depends read
     */
    public function menuTree ()
    {
        $menuTypes = $this -> menuService -> getMenuTypes();
        
        $menuTree = $this -> menuService -> menuTree($menuTypes -> shuffle() -> shift());
        
        $this -> assertIsObject($menuTree);
        
        $this -> assertTrue($menuTree instanceof \think\Collection);
    }
}