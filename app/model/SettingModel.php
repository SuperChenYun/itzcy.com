<?php
declare (strict_types = 1);

namespace app\model;

use app\BaseModel;

/**
 * @mixin BaseModel
 */
class SettingModel extends BaseModel
{
    protected $name = 'setting';
    protected $json = ['extend'];
}
