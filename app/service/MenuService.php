<?php


namespace app\service;


use app\BaseService;
use app\model\MenuModel;
use think\Collection;
use think\db\exception\DbException;
use think\Model;

class MenuService extends BaseService
{
    
    /**
     * 添加
     *
     * @param String         $menuText
     * @param String         $menuLink
     * @param MenuModel|null $menuModel
     * @param null|string    $menuSign
     * @param array          $extra
     *                     Int $extra [is_target_blank]
     *                     Int $extra [order_number]
     *                     Int $extra [status]
     *
     * @return MenuModel|false
     */
    public function addMenu (string $menuText, string $menuLink = '', MenuModel $menuModel = null, string $menuSign = null, array $extra = [])
    {
        // 查询 menu_sign 是否被占用
        if ($this -> hasMenuSign($menuSign)) {
            return false;
        }
        
        // 去掉必须拦截的参数
        if (isset($extra['menu_sign'])) unset($extra['menu_sign']);
        
        $menu = new MenuModel();
        
        $menu -> data($extra);
        
        $menu -> menu_text = $menuText;
        $menu -> menu_link = $menuLink;
        
        if ($menuSign !== null) {
            $menu -> menu_sign = $menuSign;
        }
        
        if ($menuModel !== null) {
            $menu -> pid = $menuModel -> id;
        }
        
        if ($menu -> save()) {
            return $menu;
        }
        return false;
        
        
    }
    
    /**
     * 修改
     *
     * @param MenuModel      $menu
     * @param String         $menuText
     * @param String         $menuLink
     * @param MenuModel|null $menuModel
     * @param null|string    $menuSign
     * @param array          $extra
     *                     Int $extra [is_target_blank]
     *                     String $extra [menu_sign]
     *                     Int $extra [order_number]
     *                     Int $extra [status]
     *
     * @return MenuModel|false
     */
    public function editMenu (MenuModel $menu, string $menuText, string $menuLink = '', MenuModel $menuModel = null, string $menuSign = null, array $extra = [])
    {
        
        // 查询 menu_sign 是否被占用
        if ($this -> hasMenuSign($menuSign, [['id', '<>', $menu -> id]])) {
            return false;
        }
        
        $menu -> data($extra);
        
        $menu -> menu_text = $menuText;
        $menu -> menu_link = $menuLink;
        
        
        if ($menuModel !== null) {
            $menu -> pid = $menuModel -> id;
        }
        
        if ($menuSign !== null && $menuModel === null) {
            $menu -> menu_sign = $menuSign;
        }
        
        
        if ($menu -> save()) {
            return $menu;
        }
        return false;
        
    }
    
    /**
     * 读取一条
     *
     * @param Int $id
     *
     * @return array|false|Model
     */
    public function readMenu (int $id)
    {
        $where = [
            ['delete_time', '=', 0]
        ];
        try {
            return MenuModel ::where($where) -> find($id);
        } catch (DbException $e) {
            $this -> handleException($e);
            return false;
        }
        
    }
    
    /**
     * 删除一条菜单信息
     *
     * @param MenuModel|Int $menu
     *
     * @return bool
     */
    public function removeMenu ($menu)
    {
        
        try {
            
            if (!($menu instanceof MenuModel)) {
                $menu = (new \app\model\MenuModel()) -> find((int)$menu);
            }
            
            if (empty($menu)) {
                return false;
            }
            
            // 检测是否有上下级关系
            $subMenu = MenuModel ::where([
                ['delete_time', '=', '0'],
                ['pid', '=', $menu -> id]
            ]) -> find();
            if ($subMenu) {
                return false;
            }
            
            $menu -> delete_time = time();
            if ($menu -> save()) {
                return true;
            }
            
            return false;
        } catch (DbException $e) {
            $this -> handleException($e);
            return false;
        }
    }
    
    /**
     * 获取Menu类型 （获取PID=0 的菜单分类 比如主菜单 页脚菜单 等）
     * @return Collection
     */
    public function getMenuTypes ()
    {
        try {
            $where = [
                ['delete_time', '=', 0],
                ['pid', '=', 0]
            ];
            return MenuModel ::where($where) -> select();
        } catch (DbException $e) {
            $this -> handleException($e);
            return new Collection([]);
        }
    }
    
    /**
     * 获取 指定的 MenuType
     * @return MenuModel|array|Model
     */
    public function getMenuTypeBySign (string $menuSign)
    {
        try {
            $where   = [
                ['delete_time', '=', 0],
                ['pid', '=', 0]
            ];
            $where[] = ['menu_sign', '=', $menuSign];
            
            return MenuModel ::where($where) -> find();
            
        } catch (DbException $e) {
            $this -> handleException($e);
            return new Collection([]);
        }
    }
    
    /**
     * menuTree 获取改Menu分类下的树形Menu结构
     *
     * @param MenuModel|null $menuModel
     *
     * @return Collection
     */
    public function menuTree (MenuModel $menuModel = null)
    {
        if ($menuModel === null) {
            return Collection ::make();
        }
        
        try {
            
            $menus = MenuModel ::where('delete_time', 0) -> select();
            
        } catch (DbException $e) {
            
            $this -> handleException($e);
            return new Collection();
            
        }
        
        return $this -> menuListToTree($menus, $menuModel -> id);
    }
    
    /***************************** Private Action *********************************/
    
    /**
     * 检测MenuSign 是否已经被占用
     *
     * @param null|String $menuSign
     * @param array       $exclude 排除条件
     *
     * @return bool
     */
    private function hasMenuSign ($menuSign = null, array $exclude = []): bool
    {
        try {
            if ($menuSign === null) {
                return false;
            }
            $oldMenu = MenuModel ::where($exclude) -> where('delete_time', 0) -> where('menu_sign', $menuSign) -> find();
            if (!empty($oldMenu)) {
                return true;
            }
            
            return false;
            
        } catch (DbException $e) {
            $this -> handleException($e);
            return false;
        }
    }
    
    /**
     * 无限级分类 解析树形结构
     *
     * @param Collection $menus
     * @param int        $pid
     *
     * @return Collection
     */
    private function menuListToTree (Collection $menus, $pid = 0): Collection
    {
        
        $tree = [];
        
        foreach ($menus as $menu) {
            if ($menu -> pid == $pid) {
                $tree[] = array_merge($menu -> toArray(), ['child_menu' => $this -> menuListToTree($menus, $menu -> id)]);
            }
        }
        
        array_multisort(
            array_column($tree, 'order_number'), // 去除要排序的字段的数据
            SORT_ASC,
            $tree
        );//根据某列的数据进行排序。很好用
        
        return Collection ::make($tree);
    }
    
}