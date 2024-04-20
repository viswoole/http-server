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

namespace ViSwoole\HttpServer\DocAttribute;

use Attribute;
use ViSwoole\HttpServer\Response\Shape;

/**
 * 接口返回参数结构声明
 */
#[Attribute(Attribute::TARGET_FUNCTION | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Response
{
  /**
   * @param Shape $shape 响应结构
   * @param string $illustrate 响应说明
   */
  public function __construct(public Shape $shape, public string $illustrate)
  {
  }

  /**
   * 获取响应文档数据
   *
   * @return array
   */
  public function getResponseDocData(): array
  {
    return [
      'illustrate' => $this->illustrate,
      'statusCode' => $this->shape->getStatusCode(),
      'contentType' => $this->shape->getContentType(),
      'example' => $this->shape->getData(),
    ];
  }
}
