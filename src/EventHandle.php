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
use ViSwoole\Core\Router;
use ViSwoole\HttpServer\Contract\ResponseInterface;

class EventHandle
{
  public static function onRequest(
    Request  $request,
    Response $response
  ): void
  {
    try {
      $psr7Request = \ViSwoole\HttpServer\Request::proxySwooleRequest($request);
      $psr7Response = \ViSwoole\HttpServer\Response::proxySwooleResponse($response);
      // 交由路由分发
      $result = Router::collector()->dispatch(
        $psr7Request->getPath(),
        $psr7Request->getParams(),
        $psr7Request->getMethod(),
        $psr7Request->getUri()->getHost()
      );
      if ($result instanceof ResponseInterface) {
        $result->send();
      } elseif (is_array($result) || is_object($result)) {
        // 返回的不是response对象 则对返回的参数进行json格式化。
        $psr7Response->json($result)->send();
      } else {
        $psr7Response->send((string)$result);
      }
    } catch (Throwable $e) {
      $exceptionHandle = Server::getConfig()['exception_handle'];
      App::invokeMethod([$exceptionHandle, 'render'], [$e]);
    }
  }
}
