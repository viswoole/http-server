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

use Override;

class File extends Shape
{
  public function __construct(
    string  $filePath,
    int     $offset = 0,
    int     $length = 0,
    ?string $fileMimeType = null
  )
  {
    if (empty($fileMimeType)) {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $fileMimeType = finfo_file($finfo, $filePath);
      finfo_close($finfo);
    }
    parent::__construct(
      Type::FILE,
      compact('filePath', 'offset', 'length', 'fileMimeType')
    );
  }

  /**
   * @inheritDoc
   */
  #[Override] public function getContentType(): string
  {
    return $this->data['fileMimeType'];
  }
}
