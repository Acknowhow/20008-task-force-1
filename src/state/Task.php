<?php
namespace TaskForce\state;


class Task
{
    public static $AvailableActions = [
        'ACTION_CANCEL' => 'STATE_CANCELLED',
        'ACTION_APPLY' => 'STATE_PROGRESS',
        'ACTION_ACCEPT' => 'STATE_FINISHED',
        'ACTION_DECLINE' => 'STATE_FAILED'
    ];

    public static $AvailableState = [
        'STATE_NEW' => 'isNew',
        'STATE_PROGRESS' => 'inProgress',
        'STATE_FINISHED' => 'isFinished',
        'STATE_CANCELLED' => 'isCancelled',
        'STATE_FAILED' => 'isFailed'
    ];

    public static $UserRole = [
        'USER_CONTRACTOR' => 'CONTRACTOR',
        'USER_CLIENT' => 'CLIENT'
    ];

    private $contractorId = null;
    private $clientId = null;
    private $completionDate = null;
    private $activeState = '';


    public function __construct($activeState, $userRole, $userId)
    {
        $this->activeState = self::$AvailableState[$activeState];

        if ($userRole == self::$UserRole['USER_CONTRACTOR'])
        {
            $this->clientId = $userId;
        }

        else if ($userRole == self::$UserRole['USER_CLIENT'])
        {
            $this->contractorId = $userId;
        }
    }

    public function getAvailableActions()
    {
    }

    public function getAvailableState()
    {
    }

    public function getNextState($action)
    {
    }

    public function getActiveState()
    {
        return $this->activeState;
    }
}
