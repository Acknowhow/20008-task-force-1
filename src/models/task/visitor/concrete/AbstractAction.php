<?php
namespace TaskForce\models\task\visitor\concrete;

abstract class AbstractAction
{
    abstract public function __construct($ids);

    abstract public function checkAuth();
    abstract public function getName();
    abstract public function getUserActionName();
}
