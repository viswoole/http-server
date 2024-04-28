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

namespace ViSwoole\HttpServer\Type;

use ReflectionException;
use TypeError;
use ViSwoole\Core\Common\Arr;
use ViSwoole\HttpServer\Type\Extend\ArrayShape;

function is_true(mixed $value): bool
{
  return $value === true;
}

function is_false(mixed $value): bool
{
  return $value === false;
}

/**
 * 原子类型验证
 *
 * @method static bool bool(mixed $value): bool
 * @method static bool null(mixed $value): bool
 * @method static bool int(mixed $value): bool
 * @method static bool float(mixed $value): bool
 * @method static bool string(mixed $value): bool
 * @method static bool boolean(mixed $value): bool
 * @method static bool integer(mixed $value): bool
 * @method static bool double(mixed $value): bool
 * @method static bool true(mixed $value): bool
 * @method static bool false(mixed $value): bool
 * @method static bool iterable(mixed $value): bool // 验证是否可低代，例如array|Traversable
 */
class TypeValidate
{
  // 映射方法
  public const array TYPES = [
    'bool' => 'is_bool',
    'null' => 'is_null',
    'NULL' => 'is_null',
    'int' => 'is_int',
    'float' => 'is_float',
    'string' => 'is_string',
    'array' => 'is_array',
    'object' => 'is_object',
    'true' => '\ViSwoole\Core\Validate\is_true',
    'false' => '\ViSwoole\Core\Validate\is_false',
    'boolean' => 'is_bool',
    'integer' => 'is_int',
    'double' => 'is_double',
    'iterable' => 'is_iterable',
  ];

  /**
   * 验证数组
   *
   * @param mixed $value
   * @return bool
   */
  public static function array(mixed $value): bool
  {
    return Arr::isIndexArray($value);
  }

  /**
   * 验证是否为对象，如果为关联数组则会转换为StdClass对象
   *
   * @param mixed $value
   * @return bool
   */
  public static function object(mixed &$value): bool
  {
    if (is_object($value)) {
      return true;
    } else {
      $result = Arr::isAssociativeArray($value);
      if ($result) $value = (object)$value;
      return $result;
    }
  }

  public static function checkEnum(string $class, mixed $key)
  {

  }

  /**
   * 判断是否内置原子类型
   *
   * @param string $type
   * @return bool
   */
  public static function isAtomicType(string $type): bool
  {
    return isset(self::TYPES[$type]);
  }

  public static function __callStatic(string $name, array $arguments)
  {
    if (isset(self::TYPES[$name])) {
      if (class_exists($name)) {
        // 类
        self::toClass($name, $arguments);
      } elseif (enum_exists($name)) {
        // 枚举类型
      } elseif (str_contains($name, '&')) {
        // 交集类型
      }
    } else {
      return call_user_func_array(self::TYPES[$name], $arguments);
    }
  }

  /**
   * 验证数据，并实例为类
   *
   * @param string $class
   * @param array $args
   * @return array
   * @throws ReflectionException
   */
  private static function toClass(string $class, array $args): array
  {
    // 获取类型
    $shapes = ShapeTool::getParamTypeShape($class);
    // 如果是拓展的数组类型
    if (in_array(ArrayShape::class, class_parents($class))) {
      $type = $shapes[0]['type'];
      if ($type !== 'mixed') {
        $types = explode('|', $type);
        $args = self::batchCheckTypes($args, $types);
      }
      return new $class(...$args);
    }
    $params = [];
    // 遍历类构造方法参数
    foreach ($shapes as $shape) {
      // 参数名称
      $name = $shape['name'];
      // 当前传递的参数值或默认值
      $value = Arr::arrayPopValue($args, $name, $shape['default']);
      // 值类型
      $valueType = gettype($value);
      // 当前参数的类型声明，字符串
      $type = $shape['type'];
      // 参数类型声明转为数组
      $types = explode('|', $type);
      // 如果为可变数量参数，则把剩余的参数都用于校验可变数量参数的类型
      if ($shape['variadic']) {
        $value = self::batchCheckTypes($args, $types);
        $params = array_merge($params, $value);
        break;
      }
      // 是否不能为空
      $required = $shape['required'];
      // 如果是任意类型则直接跳过当前参数校验
      if ($type === 'mixed') {
        $params[$name] = $value;
        continue;
      }
      // 如果不能为空，且给定的值为null则抛出异常
      if ($required && is_null($value)) throw new TypeError("{$name}类型必须为{$type}，给定NULL");
    }
    return $params;
  }

  /**
   * 批量检测类型，也可用于检测数组item类型
   *
   * 注意：不会对空数组进行检测
   *
   * @access public
   * @param mixed $array 数组
   * @param array $types 数组元素支持的类型,支持类，枚举类型自动校验以及转换
   * @return array 验证成功返回传入的数组
   * @throws TypeError 验证失败会抛出类型异常
   */
  private static function batchCheckTypes(mixed $array, array $types, string $field): array
  {
    if (!is_array($array)) {
      $t = gettype($array);
      throw new TypeError("必须为array，给定{$t}。");
    }
    if (empty($types) || in_array('mixed', $types)) return $array;
    // 遍历数组元素判断是否符合规则
    foreach ($array as $index => $item) {
      $field = is_string($index) ? "$field.$index" : "$field($index)";
      try {
        $array[$index] = self::checkTypes($item, $types, $field);
      } catch (TypeError $e) {
        throw new TypeError($field . $e->getMessage());
      }
    }
    return $array;
  }

  /**
   * 检测一个值是否符合指定的类型
   *
   * @param mixed $value
   * @param array $types
   * @param string $field
   * @return mixed
   */
  private static function checkTypes(mixed $value, array $types, string $field): mixed
  {
    if (empty($types) || in_array('mixed', $types)) return $value;
    foreach ($types as $type) {
      $res = TypeValidate::$type($value);
      if ($res) {
        if (!is_bool($res)) {
          return $res;
        } else {
          return $value;
        }
      }
    }
    $type = gettype($value);
    $types = implode('|', $types);
    throw new TypeError("{$field}类型必须为{$types}，给定{$type}。");
  }
}
