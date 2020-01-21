<?php
namespace TaskForce\models\Task\Visitor;
use TaskForce\models\Task\Visitor\Concrete\AbstractAction;

class CompleteAction extends AbstractAction
{
    const NAME = 'ACTION_COMPLETE';
    private array $ids = [];

    public function __construct($ids = [
        'USER_ID' => null,
        'CLIENT_ID' => null,
        'CONTRACTOR_ID' => null
    ])
    {
        $this->ids = $ids;
    }

    public function checkAuth(): bool
    {
        return $this->ids['USER_ID'] ==
            $this->ids['CLIENT_ID'];
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getUserActionName(): string
    {
        if (self::checkAuth()) {
            return self::NAME;
        }
        return '';
    }
}
