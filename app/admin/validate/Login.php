<?php
/**
 * ============================================================================
 * 版权所有 2015-2018
 * 网站地址: https://www.xiaoxiang.ga
 * ----------------------------------------------------------------------------
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 本程序采用thinkphp v5.0开发
 * ============================================================================
 * Author: chiqing_85
 * Time: 2018/2/8 21:20
 */

namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        ['username','require','用户空不能为空'],
        ['password', 'require', '密码不能为空'],
        ['__token__', 'require|max:50|token']
    ];
}