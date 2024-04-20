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

namespace ViSwoole\HttpServer\Response\Json;

use JsonSerializable;
use ViSwoole\HttpServer\Response\Json;

/**
 * 统一格式的json响应
 */
class UnifiedJson extends Json
{
  /**
   * @param int $errCode 响应的业务错误码
   * @param string $errMsg 响应的业务错误信息
   * @param array|JsonSerializable $data 响应的额外数据
   */
  public function __construct(
    int    $errCode,
    string $errMsg,
    mixed  $data,
    int    $statusCode
  )
  {
    parent::__construct(compact('errCode', 'errMsg', 'data'), $statusCode);
  }
}
