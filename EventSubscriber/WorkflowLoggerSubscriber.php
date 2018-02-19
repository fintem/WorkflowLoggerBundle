<?php

namespace Fintem\WorkflowLoggerBundle\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;
use WorkflowLoggerBundle\Entity\WorkflowLogger;

/**
 * Class WorkflowLoggerSubscriber.
 */
class WorkflowLoggerSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $em;
    /**
     * @var array
     */
    private $loggerConfig;

    /**
     * WorkflowLoggerSubscriber constructor.
     *
     * @param EntityManagerInterface $em
     * @param array                  $loggerConfig
     */
    public function __construct(EntityManagerInterface $em, array $loggerConfig)
    {
        $this->em = $em;
        $this->loggerConfig = $loggerConfig;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.entered' => ['onEntered', 0],
        ];
    }

    /**
     * @param Event $event
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onEntered(Event $event)
    {
        $workflow = $event->getWorkflowName();
        if (!$this->isLogging() || !$this->isWorkflowLog($workflow)) {
            return;
        }

        $transition = $event->getTransition();
        $logger = (new WorkflowLogger())
            ->setEntityId($event->getSubject()->getId())
            ->setWorkflow($workflow)
            ->setTransition($transition->getName())
            ->setFroms(implode(', ', array_values($transition->getFroms())))
            ->setTos(implode(', ', array_values($transition->getTos())));

        $this->save($logger);
    }

    /**
     * @return bool
     */
    private function isLogging(): bool
    {
        return $this->loggerConfig['logging'];
    }

    /**
     * @param string $workflowName
     *
     * @return bool
     */
    private function isWorkflowLog(string $workflowName): bool
    {
        $workflows = $this->loggerConfig['workflows'];
        if (0 === \count($workflows)) {
            return true;
        }

        return \in_array($workflowName, $workflows, true);
    }

    /**
     * @param WorkflowLogger $logger
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    private function save(WorkflowLogger $logger)
    {
        $this->em->persist($logger);
        $this->em->flush();
    }
}
