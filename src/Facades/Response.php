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

namespace ViSwoole\HttpServer\Facades;

use JsonSerializable;
use Override;
use Psr\Http\Message\StreamInterface;
use ViSwoole\Core\Facade;
use ViSwoole\HttpServer\Contract\ResponseInterface;

/**
 * HTTP响应类
 *
 * @method static ResponseInterface setHeader(array|string $name, array|string|null $value = null) 设置响应头(可批量设置)
 * @method static bool hasHeader(string $name) 检查是否存在给定不区分大小写名称的标头。
 * @method static string getHeaderLine(string $name) 通过给定不区分大小写的名称检索标头的值，这些值以逗号分隔的字符串形式返回。
 * @method static array getHeader(string $name) 通过给定不区分大小写的名称检索消息标头值。
 * @method static string getProtocolVersion() 检索 HTTP 协议版本号作为字符串。
 * @method static ResponseInterface withProtocolVersion(string $version) 返回具有指定的 HTTP 协议版本的实例。
 * @method static array getHeaderLines() 检索所有消息头的值。
 * @method static array getHeaders() 检索所有消息头的值。
 * @method static ResponseInterface withAddedHeader(string $name, mixed $value) 将保留指定标头的现有值。
 * @method static ResponseInterface withoutHeader(string $name) 返回一个没有指定标头的实例。
 * @method static ResponseInterface withBody(StreamInterface $body) 返回具有指定消息主体的实例。
 * @method static int getStatusCode() 获取响应状态代码。
 * @method static bool redirect(string $uri, int $http_code = 302) 重定向
 * @method static \Swoole\Http\Response getSwooleResponse() 获取swoole的Response对象
 * @method static bool send(?string $content = null) 发送响应(当request进程结束时会自动调用该方法)
 * @method static StreamInterface getBody() 获取消息的主体。
 * @method static ResponseInterface withHeader(string $name, mixed $value) 返回一个具有指定值，替换指定标头的实例。
 * @method static ResponseInterface error(string $errMsg = 'error', int $errCode = -1, JsonSerializable|array|null $data = null) 错误响应格式
 * @method static ResponseInterface unifiedJson(string $errMsg, int $errCode, JsonSerializable|array|null $data, int $statusCode) 设置统一的JSON响应格式
 * @method static ResponseInterface json(JsonSerializable|array $data, int $statusCode = 200) 设置JSON格式的响应内容
 * @method static ResponseInterface setContent(string $content) 设置响应内容
 * @method static ResponseInterface setContentType(string $contentType = 'application/json', string $charset = 'utf-8') 设置Content-Type响应头
 * @method static ResponseInterface setMessage(string $content) 设置响应内容
 * @method static ResponseInterface echoConsole(bool $echo = true) 是否将响应回显到控制台
 * @method static ResponseInterface exception(string $errMsg = '系统内部异常', int $errCode = 500, int $statusCode = 500, JsonSerializable|array|null $errTrace = null) 设置异常响应
 * @method static ResponseInterface success(string $errMsg = 'success', JsonSerializable|array|null $data = null) 设置成功响应
 * @method static bool sendfile(string $filePath, int $offset = 0, int $length = 0, ?string $fileMimeType = null) 发送文件
 * @method static ResponseInterface setCode(int $statusCode, string $reasonPhrase = '') 应用状态码
 * @method static ResponseInterface withStatus(int $code, string $reasonPhrase = '') 应用状态码
 * @method static string getReasonPhrase() 获取状态码描述短语
 * @method static bool setCookie(string $key, string $value = '', int $expire = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = '') 设置Cookie信息
 * @method static bool rawCookie(string $key, string $value = '', int $expire = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = '') 参数和上文的 setCookie() 一致，只不过不进行编码处理
 *
 * 优化命令：php viswoole optimize:facade \\ViSwoole\\HttpServer\\Facades\\Response
 */
class Response extends Facade
{

  /**
   * 获取当前Facade对应类名
   *
   * @access protected
   * @return string
   */
  #[Override] protected static function getFacadeClass(): string
  {
    return \ViSwoole\HttpServer\Response::class;
  }
}
