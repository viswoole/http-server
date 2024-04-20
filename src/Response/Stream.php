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

namespace ViSwoole\HttpServer\Response;

use ViSwoole\HttpServer\Message\FileStream;

/**
 * 二进制流响应
 */
class Stream extends Shape
{
  public function __construct(string|FileStream $stream, int $statusCode = 200)
  {
    if ($stream instanceof FileStream) {
      $stream = $stream->getContents();
    }
    parent::__construct(Type::STREAM, $stream, $statusCode);
  }
}
