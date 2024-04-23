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

use Swoole\Http\Request;
use Swoole\Http\Response;
use Throwable;
use ViSwoole\Core\Facades\App;
use ViSwoole\Core\Facades\Server;
use ViSwoole\HttpServer\Contract\ResponseInterface;
use ViSwoole\HttpServer\Router\RouteMiss;

class EventHandle
{
  public static function onRequest(
    Request  $request,
    Response $response
  ): bool
  {
    try {
      $psr7Request = \ViSwoole\HttpServer\Request::create($request);
      $psr7Response = \ViSwoole\HttpServer\Response::create($response);
      // 匹配路由
      $route = Router::collector()->matchRoute($psr7Request);
      if ($route instanceof RouteMiss) {
        $handle = $route->handler;
        $middleware = [];
      } else {
        $handle = $route['handler'];
        $middleware = $route['middleware'];
      }
      $result = Middleware::process($handle, $middleware);
      if ($result instanceof ResponseInterface) {
        return $result->send();
      } elseif (is_array($result) | is_object($result)) {
        // 返回的不是response对象 则对返回的参数进行json格式化。
        return $psr7Response->json($result)->send();
      } else {
        return $psr7Response->send((string)$result);
      }
    } catch (Throwable $e) {
      $exceptionHandle = Server::getConfig()['exception_handle'];
      return App::invokeMethod([$exceptionHandle, 'render'], [$e]);
    }
  }
}
