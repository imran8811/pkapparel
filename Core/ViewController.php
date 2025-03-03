<?php

declare(strict_types=1);

namespace Core;

class ViewerController {
  public function render(string $template, array $data = []): string {
    extract($data, EXTR_SKIP);
    ob_start();
    require dirname(__DIR__, 2) . "/views/$template" . ".php";
    return ob_get_clean();
  }
}
