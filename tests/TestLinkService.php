<?php


use app\service\LinkService;

class TestLinkService extends TestAAACase
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
    public function add ()
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
    public function edit ()
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
    public function read ()
    {
        try {
            $link = \app\model\LinkModel ::where([]) -> order('id', 'desc') -> find();
        } catch (\think\db\exception\DbException $e) {
            return false;
        }
        $this -> assertIsObject(
            $link = $this -> linkService -> read($link -> id)
        );
        
        $this -> assertTrue($link instanceof \app\model\LinkModel);
        
    }
    
    /**
     * @test
     * @depends add
     * @depends edit
     * @depends read
     * @depends lists
     */
    public function remove ()
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
    public function lists ()
    {
        $this -> assertIsObject(
            $collection = $this -> linkService -> lists()
        );
        $this -> assertTrue($collection instanceof \think\Collection);
    }
    
}