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

/**
 * 响应形状
 */
abstract class Shape
{
  /**
   * @param Type $contentType 响应类型
   * @param mixed $content 响应内容
   * @param int $statusCode 响应状态码
   */
  public function __construct(
    protected Type  $contentType,
    protected mixed $content,
    protected int   $statusCode = 200
  )
  {
  }

  /**
   * 获取ContentType
   *
   * @return string 响应内容类型
   */
  public function getContentType(): string
  {
    return $this->contentType->value;
  }

  /**
   * 获取数据
   *
   * @access public
   * @return mixed
   */
  public function getContent(): mixed
  {
    return $this->content;
  }

  /**
   * 获取HTTP状态码
   *
   * @return int
   */
  public function getStatusCode(): int
  {
    return $this->statusCode;
  }
}
