<?php


namespace app\service;


use app\BaseService;
use app\model\SettingModel;
use think\Collection;
use think\db\exception\DbException;
use think\facade\Log;

/**
 * 设置管理类
 * Class SettingService
 * @package app\service
 */
class SettingService extends BaseService
{
    /**
     * @param String $key
     * @param mixed  $val
     * @param mixed  $filter
     * @param array  $extra
     * @param int    $order
     *
     * @return bool
     */
    public function set (string $key, $val, $filter = null, array $extra = [], int $order = 0)
    {
        if (!is_callable($filter)) {
            return false;
        }
        
        try {
            if ($val == null) {
                // 移除该设置
                $settingModel = SettingModel ::where(['key' => $key, 'delete_time' => 0]);
                if ($settingModel -> save(['delete_time' => 0])) {
                    return true;
                }
                return false;
            }
            
            // 设置或覆盖该 KEY
            $settingModel = SettingModel ::where(['key' => $key, 'delete_time' => 0]) -> find();
            if (empty($settingModel)) {
                $settingModel = new SettingModel();
            }
            $settingModel -> key    = $key;
            $settingModel -> value  = call_user_func($filter, $val);
            $settingModel -> extend = $extra;
            $settingModel -> order  = $order;
            if ($settingModel -> save()) {
                return true;
            }
            return false;
        } catch (DbException $e) {
            $this->handleException($e);
            return false;
        }
        
    }
    
    /**
     * @param String $key
     * @param mixed  $filter
     *
     * @return mixed
     */
    public function get (string $key, $filter)
    {
        if (!is_callable($filter)) {
            return false;
        }
        
        try {
            $settingModel = SettingModel ::where(['key' => $key, 'delete_time' => 0]) -> find();
            if (empty($settingModel)) {
                return false;
            }
            
            $settingModel -> value = call_user_func($filter, $settingModel -> value);;
            return $settingModel;
        } catch (DbException $e) {
            $this->handleException($e);
            return false;
        }
        
    }
    
    /**
     * 所有列表
     *
     * @param array $filterList
     *
     * @return Collection|array
     */
    public function lists (array $filterList = [])
    {
        // 检测过滤器是否是可调用的函数
        foreach ($filterList as $filter) {
            if (!is_callable($filter)) {
                return false;
            }
        }
        
        try {
            $settings = SettingModel ::where(['delete_time' => 0]) -> select();
            foreach ($settings as $k => $setting) {
                $upperKey = strtoupper($setting -> key);
                if (in_array($upperKey, array_keys($filterList))) {
                    $settings[$k] -> value = call_user_func($filterList[$upperKey], $setting -> value);
                }
            }
            return $settings;
        } catch (DbException $e) {
            $this->handleException($e);
            return [];
        }
    }
}
