<?php

declare(strict_types=1);

namespace Core;

abstract class Controller {
  protected $request;
  protected $response;
  protected $viewer;

  public function __construct(){}

}
