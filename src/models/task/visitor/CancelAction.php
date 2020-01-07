<?php
namespace TaskForce\models\task\visitor;
use TaskForce\models\task\visitor\concrete\AbstractAction;

class CancelAction extends AbstractAction
{
    const NAME = 'ACTION_CANCEL';
    private $ids = [];

    public function __construct($ids = [
        'USER_ID' => null,
        'CLIENT_ID' => null,
        'CONTRACTOR_ID' => null
    ])
    {
        $this->ids = $ids;
    }

    public function checkAuth()
    {
        return $this->ids['USER_ID'] ==
            $this->ids['CLIENT_ID'];
    }

    public function getName()
    {
        return self::NAME;
    }

    public function getUserActionName()
    {
        if (self::checkAuth()) {
            return self::NAME;
        }
        return '';
    }
}
