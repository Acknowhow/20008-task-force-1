<?php
namespace TaskForce\models\task;
use TaskForce\models\task\visitor\concrete\AbstractAction;
use TaskForce\exceptions\TaskArgumentException;
use TaskForce\exceptions\TaskActionException;

class Task
{
    const AVAILABLE_ACTIONS = [
        'ACTION_ACCEPT' => 'STATUS_PROGRESS',
        'ACTION_COMPLETE' => 'STATUS_ACCOMPLISH',
        'ACTION_CANCEL' => 'STATUS_CANCEL',
        'ACTION_APPLY' => 'STATUS_NEW',
        'ACTION_DECLINE' => 'STATUS_FAIL'
    ];

    const AVAILABLE_STATUSES = [
        'STATUS_NEW' => 'IS_NEW',
        'STATUS_PROGRESS' => 'IN_PROGRESS',
        'STATUS_CANCEL' => 'IS_CANCELLED',
        'STATUS_ACCOMPLISH' => 'IS_FINISHED',
        'STATUS_FAIL' => 'IS_FAILED'
    ];

    const USER_ACTIONS = [
        'IS_NEW' => [
            'ACTION_APPLY', 'ACTION_ACCEPT', 'ACTION_CANCEL'
        ],
        'IN_PROGRESS' => [
            'ACTION_COMPLETE', 'ACTION_DECLINE'
        ]
    ];

    private array $ids = [];
    private string $activeStatus = '';

    /**
     * @var AbstractAction[] $actions
     */
    private array $actionValidators = [];

    public function __construct(string $activeStatus, array $ids = [
        'USER_ID' => null, 'CLIENT_ID' => null,
        'CONTRACTOR_ID' => null
    ])
    {
        if (empty($activeStatus) || !is_string($activeStatus)) {
            throw new TaskArgumentException('
            Значение статуса в задаче должно быть непустой строкой');
        }

        if (empty($ids) || !is_array($ids)) {
            throw new TaskArgumentException('
            Значение ids должно быть непустым массивом');
        }

        $this->activeStatus = self::AVAILABLE_STATUSES[$activeStatus];
        $this->ids = $ids;
    }

    public function addActionValidator(AbstractAction $action): void
    {
        $this->actionValidators[] = $action;
    }

    //** SetNextState with available action classes */
    public function setNextStatus($status): string
    {
        $this->activeStatus = self::AVAILABLE_STATUSES[$status];
        return $this->activeStatus;
    }

    public function getNextState($action): ?string
    {
        return self::AVAILABLE_ACTIONS[$action] ?? null;
    }

    public function getAvailableActions(): array
    {
        $availableActions = self::USER_ACTIONS[$this->activeStatus] ?? null;

        if (!isset($availableActions)) {

            throw new TaskActionException('
            Для текущей задачи нет доступных действий');

        } else {
            $filteredArray = [];
            foreach ($availableActions as $availableAction) {
                foreach ($this->actionValidators as $actionValidator) {

                    if ($actionValidator->getUserActionName() ==
                        $availableAction) {

                        $filteredArray[] = $availableAction;
                    }

                }
            }
            return $filteredArray;
        }
    }

    public function getActiveState(): string
    {
        return $this->activeStatus;
    }
}
