<?php

namespace Fintem\WorkflowLoggerBundle\Tests\Unit;

use Skycop\Libraries\Testing\PHPUnit\UnitTestCase;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;
use WorkflowLoggerBundle\EventSubscriber\WorkflowLoggerSubscriber;
use WorkflowLoggerBundle\Model\WorkflowLoggerModel;

/**
 * Class WorkflowLoggerSubscriberTest.
 */
class WorkflowLoggerSubscriberTest extends UnitTestCase
{
    public function SaveLogProvider()
    {
        return [
            'Search in workflows list' => [['workflowOne', 'workflowTwo', 'workflowName']],
            'Log any workflow' => [[]],
        ];
    }

    /**
     * @return array
     */
    public function ShouldNotLogProvider(): array
    {
        return [
            'Logging false' => [[], false],
            'Not in workflows list' => [['workflowOne', 'workflowTwo'], true],
        ];
    }

    /**
     * @test
     * @dataProvider ShouldNotLogProvider
     *
     * @param array $workflows
     * @param bool  $logging
     *
     * @throws \Exception
     */
    public function workflowLoggerSubscriberShouldNotLog(array $workflows, bool $logging)
    {
        $loggerConfig = [
            'workflows' => $workflows,
            'logging' => $logging,
        ];

        $model = $this->getBasicMock(WorkflowLoggerModel::class, null, ['save']);
        $model->expects($this->never())->method('save');

        /** @var Event|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getBasicMock(Event::class, null, ['getWorkflowName']);
        $event->expects($this->once())->method('getWorkflowName')->willReturn('workflowName');

        /** @var WorkflowLoggerSubscriber|\PHPUnit_Framework_MockObject_MockObject $subscriber */
        $subscriber = $this->getBasicMock(WorkflowLoggerSubscriber::class, [
            'model' => $model, 'loggerConfig' => $loggerConfig,
        ]);

        $subscriber->onEntered($event);
    }

    /**
     * @test
     * @dataProvider SaveLogProvider
     *
     * @param array $workflows
     *
     * @throws \Exception
     */
    public function workflowLoggerSubscriberShouldSaveLog(array $workflows)
    {
        $loggerConfig = [
            'workflows' => $workflows,
            'logging' => true,
        ];

        $model = $this->getBasicMock(WorkflowLoggerModel::class, null, ['save']);
        $model->expects($this->once())->method('save');

        $subject = $this->getBasicMock(Workflow::class, null, ['getId']);
        $subject->expects($this->once())->method('getId')->willReturn('df-45f');

        $transition = $this->getBasicMock(Transition::class, null, ['getName', 'getFroms', 'getTos']);
        $transition->expects($this->once())->method('getName')->willReturn('transitionName');
        $transition->expects($this->once())->method('getFroms')->willReturn([]);
        $transition->expects($this->once())->method('getTos')->willReturn([]);

        /** @var Event|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getBasicMock(Event::class, null, ['getWorkflowName', 'getSubject', 'getTransition']);
        $event->expects($this->once())->method('getWorkflowName')->willReturn('workflowName');
        $event->expects($this->once())->method('getSubject')->willReturn($subject);
        $event->expects($this->once())->method('getTransition')->willReturn($transition);

        /** @var WorkflowLoggerSubscriber|\PHPUnit_Framework_MockObject_MockObject $subscriber */
        $subscriber = $this->getBasicMock(WorkflowLoggerSubscriber::class, [
            'model' => $model, 'loggerConfig' => $loggerConfig,
        ]);

        $subscriber->onEntered($event);
    }
}
