<?php
/**
 * Simple .env file loader
 * Loads environment variables from .env file in the project root
 */
function loadEnv($path = null) {
  if($path === null){
    $path = dirname(__DIR__) . '/.env';
  }
  if(!file_exists($path)){
    return;
  }
  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach($lines as $line){
    $line = trim($line);
    // Skip comments
    if(strpos($line, '#') === 0){
      continue;
    }
    if(strpos($line, '=') === false){
      continue;
    }
    list($key, $value) = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);
    // Remove surrounding quotes
    if((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
       (substr($value, 0, 1) === "'" && substr($value, -1) === "'")){
      $value = substr($value, 1, -1);
    }
    if(!getenv($key)){
      putenv("$key=$value");
    }
  }
}

loadEnv();
