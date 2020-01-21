<?php
namespace TaskForce\models\Task\Visitor\Concrete;

abstract class AbstractAction
{
    abstract public function __construct($ids);

    abstract public function checkAuth();
    abstract public function getName();
    abstract public function getUserActionName();
}
