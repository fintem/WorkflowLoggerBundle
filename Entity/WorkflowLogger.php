<?php

namespace WorkflowLoggerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class WorkflowLogger.
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class WorkflowLogger
{
    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Column(type="bigint", options={"unsigned": true})
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $entityId;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $froms;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $tos;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $transition;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $workflow;

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     *
     * @return $this
     */
    public function setEntityId(string $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->froms;
    }

    /**
     * @return string
     */
    public function getTos(): string
    {
        return $this->tos;
    }

    /**
     * @param string $tos
     *
     * @return $this
     */
    public function setTos(string $tos): self
    {
        $this->tos = $tos;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransition(): string
    {
        return $this->transition;
    }

    /**
     * @param string $transition
     *
     * @return $this
     */
    public function setTransition(string $transition): self
    {
        $this->transition = $transition;

        return $this;
    }

    /**
     * @return string
     */
    public function getWorkflow(): string
    {
        return $this->workflow;
    }

    /**
     * @param string $workflow
     *
     * @return $this
     */
    public function setWorkflow(string $workflow): self
    {
        $this->workflow = $workflow;

        return $this;
    }

    /**
     * @param string $froms
     *
     * @return $this
     */
    public function setFroms(string $froms): self
    {
        $this->froms = $froms;

        return $this;
    }
}
