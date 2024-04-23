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
use ViSwoole\Core\Facades\Event;
use ViSwoole\Core\ServiceProvider;

class RouterService extends ServiceProvider
{

  /**
   * @inheritDoc
   */
  #[Override] public function boot(): void
  {
    // 服务启动，创建路由 加载中间件
    Event::on('ServerStart', function () {
      Middleware::init();
      Router::factory();
    });
  }

  /**
   * @inheritDoc
   */
  #[Override] public function register(): void
  {
    $this->app->bind('router', Router::class);
  }
}
