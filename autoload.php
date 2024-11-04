<?php

spl_autoload_register(static function ($class) {
  include 'classes/' . $class . '.php';
});
