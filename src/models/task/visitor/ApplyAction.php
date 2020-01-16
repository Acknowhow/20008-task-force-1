<?php
namespace TaskForce\Models\Task\Visitor;
use TaskForce\Models\Task\Visitor\Concrete\AbstractAction;

class ApplyAction extends AbstractAction
{
    const NAME = 'ACTION_APPLY';
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
            $this->ids['CONTRACTOR_ID'];
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
