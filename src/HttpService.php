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
    $this->app->bind(RequestInterface::class, Request::class);
    $this->app->bind(ResponseInterface::class, Response::class);
    $this->app->addExclude(Request::class);
    $this->app->addExclude(Response::class);
  }
}
