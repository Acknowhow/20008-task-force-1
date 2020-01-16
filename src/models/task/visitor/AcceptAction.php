<?php
namespace TaskForce\Models\Task\Visitor;
use TaskForce\Models\Task\Visitor\Concrete\AbstractAction;

class AcceptAction extends AbstractAction
{
    const NAME = 'ACTION_ACCEPT';
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
