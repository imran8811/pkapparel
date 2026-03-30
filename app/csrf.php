<?php
/**
 * CSRF Token Generation & Validation
 */

function csrf_token() {
  if(!isset($_SESSION)) session_start();
  if(empty($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function csrf_field() {
  return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '" />';
}

function csrf_verify() {
  if(!isset($_SESSION)) session_start();
  if(!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])){
    return false;
  }
  $valid = hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
  // Regenerate token after validation to prevent reuse
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  return $valid;
}
