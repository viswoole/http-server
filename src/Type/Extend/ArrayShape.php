<?php
/*
 *  +----------------------------------------------------------------------
 *  | ViSwoole [基于swoole开发的高性能快速开发框架]
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2024
 *  +----------------------------------------------------------------------
 *  | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 *  +----------------------------------------------------------------------
 *  | Author: ZhuChongLin <8210856@qq.com>
 *  +----------------------------------------------------------------------
 */

declare (strict_types=1);

namespace ViSwoole\HttpServer\Type\Extend;

use ViSwoole\Core\Common\ArrayObject;

/**
 * 数组元素验证
 *
 * 定义构造函数$items参数类型来校验元素的值
 */
abstract class ArrayShape extends ArrayObject
{
  /**
   * @param mixed ...$items 数组元素
   */
  public function __construct(mixed ...$items)
  {
    parent::__construct(array_values($items));
  }
}
