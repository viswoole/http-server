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

/**
 * 系统异常响应
 */
class Exception extends UnifiedJson
{
  public function __construct(
    string $errMsg = '服务器内部异常',
    int    $errCode = 500,
    int    $statusCode = 500,
    mixed  $data = null,
  )
  {
    parent::__construct($errCode, $errMsg, $data, $statusCode);
  }
}
