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
 * 响应类型
 */
enum Type: string
{
  case JSON = 'application/json';
  case HTML = 'text/html';
  case TEXT = 'text/plain';
  case FILE = 'mime/file';
  case STREAM = 'application/octet-stream';
}
