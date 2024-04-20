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

use JsonSerializable;
use Override;

/**
 * 输出Json响应
 */
class Json extends Shape implements JsonSerializable
{

  public function __construct(mixed $data, int $statusCode = 200)
  {
    parent::__construct(Type::JSON, $data, $statusCode);
  }

  /**
   * @inheritDoc
   */
  #[Override] public function jsonSerialize(): mixed
  {
    return $this->data;
  }
}
