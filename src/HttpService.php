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

namespace ViSwoole\HttpServer;

use Override;
use ViSwoole\Core\ServiceProvider;
use ViSwoole\HttpServer\Contract\RequestInterface;
use ViSwoole\HttpServer\Contract\ResponseInterface;

/**
 * Http服务提供者
 */
class HttpService extends ServiceProvider
{
  /**
   * @inheritDoc
   */
  #[Override] public function boot(): void
  {
  }

  /**
   * @inheritDoc
   */
  #[Override] public function register(): void
  {
    if (class_exists('\App\Request')) {
      $requestClass = \App\Request::class;
    } else {
      $requestClass = Request::class;
    }
    if (class_exists('\App\Response')) {
      $responseClass = \App\Response::class;
    } else {
      $responseClass = Response::class;
    }
    $this->app->bind(RequestInterface::class, $requestClass);
    $this->app->bind(ResponseInterface::class, $responseClass);
    $this->app->bind(Request::class, $requestClass);
    $this->app->bind(Response::class, $responseClass);
    // 不缓存单实例
    $this->app->addExclude($requestClass);
    $this->app->addExclude($responseClass);
  }
}
