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

use ViSwoole\HttpServer\Response\Json;

/**
 * 统一格式的json响应
 */
class UnifiedJson extends Json
{
  /**
   * @var int 响应的业务错误码
   */
  public readonly int $errCode;
  /**
   * @var string 响应的业务错误信息
   */
  public readonly string $errMsg;
  /**
   * @var mixed 额外的响应数据
   */
  public readonly mixed $data;

  /**
   * @param int $errCode 响应的业务错误码
   * @param string $errMsg 响应的业务错误信息
   * @param array $data 响应的额外数据
   */
  public function __construct(
    int    $errCode,
    string $errMsg,
    mixed  $data,
    int    $statusCode
  )
  {
    $this->errCode = $errCode;
    $this->errMsg = $errMsg;
    $this->data = $data;
    parent::__construct(compact('errCode', 'errMsg', 'data'), $statusCode);
  }
}
