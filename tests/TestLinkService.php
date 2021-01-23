<?php


use app\service\CategoryService;
use app\service\LinkService;

class TestLinkService extends TestCase
{
    /**
     * @var LinkService
     */
    private $linkService;
    
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        $this -> linkService = new LinkService(new \app\Request());
    }
    
    /**
     * @test
     */
    public function addCategory ()
    {
        $this -> assertIsObject(
            $link = $this -> linkService -> add(
                '百度',
                'https://www.baidu.com',
                LinkService::LINK_TYPE_OVERLAPPING,
                [
                    'in_site_link' => '',
                    'audit_pass' => '0',
                    'contact_name' => '百度',
                    'contact_email' => 'mail@baidu.com',
                    'contact_qq' => '',
                    'contact_wechat' => '',
                    'remarks' => '测试数据',
                    'order_id' => '1',
                ]
            )
        );
        $this -> assertTrue($link instanceof \app\model\LinkModel);
    }
    
    /**
     * @test
     */
    public function editCategory ()
    {
        
        try {
            $linkModel = \app\model\LinkModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        $this -> assertIsObject(
            $link = $this -> linkService -> edit(
                $linkModel,
                '百度_C',
                'https://www.baidu.com/',
                LinkService::LINK_TYPE_OVERLAPPING,
                [
                    'in_site_link' => '',
                    'audit_pass' => '0',
                    'contact_name' => '百度',
                    'contact_email' => 'mail@baidu.com',
                    'contact_qq' => '',
                    'contact_wechat' => '',
                    'remarks' => '测试数据',
                    'order_id' => '1',
                ]
            )
        );
        $this -> assertTrue($link instanceof \app\model\LinkModel);
    }
    
    /**
     * @test
     */
    public function readCategory ()
    {
        try {
            $link = \app\model\LinkModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        $this -> assertIsObject(
            $category = $this -> linkService -> read($link -> id)
        );
        
        $this -> assertTrue($category instanceof \app\model\LinkModel);
        
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
            $linkModel = \app\model\linkModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        
        $this -> assertTrue($this -> linkService -> remove($linkModel -> id));
    }
    
    /**
     * @test
     */
    public function listsCategory ()
    {
        $this -> assertIsObject(
            $collection = $this -> linkService -> lists()
        );
        $this -> assertTrue($collection instanceof \think\Collection);
    }
    
}