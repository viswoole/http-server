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

namespace ViSwoole\HttpServer\Exception;

use Throwable;
use ViSwoole\Core\App;
use ViSwoole\Core\Exception\RouteNotFoundException;
use ViSwoole\Core\Exception\ValidateException;
use ViSwoole\HttpServer\Response;
use ViSwoole\HttpServer\Status;

/**
 * 异常处理类
 */
class Handle extends \ViSwoole\Core\Exception\Handle
{
  public function __construct(protected Response $response, protected App $app)
  {
    parent::__construct([HttpException::class]);
  }

  /**
   * 处理异常
   *
   * @param Throwable $e
   * @return void
   */
  public function render(Throwable $e): void
  {
    parent::render($e);
    $statusCode = 500;
    $message = $e->getMessage();
    $errTrace = null;
    if ($e instanceof HttpException) {
      $statusCode = $e->getHttpCode();
      $this->response->setHeader($e->getHeaders());
    } elseif ($e instanceof RouteNotFoundException) {
      $statusCode = Status::NOT_FOUND;
    } elseif ($e instanceof ValidateException) {
      $statusCode = Status::BAD_REQUEST;
    } elseif ($this->app->isDebug()) {
      $message = $e->getMessage();
      $errTrace = $e->getTrace();
    } else {
      $message = 'Internal Server Error';
    }
    $this->response->exception(
      $message,
      $e->getCode(),
      $statusCode,
      $errTrace
    )->send();
  }
}
