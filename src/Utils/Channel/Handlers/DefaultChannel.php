<?php
/**
 * @author workbunny/Chaz6chez
 * @email chaz6chez1993@outlook.com
 */
declare(strict_types=1);

namespace Workbunny\WebmanCoroutine\Utils\Channel\Handlers;

class DefaultChannel implements ChannelInterface
{

    /** @var \SplQueue|null  */
    protected ?\SplQueue $_queue;

    /** @var int  */
    protected int $_capacity;

    /** @inheritdoc  */
    public function __construct(int $capacity = -1)
    {
        $this->_queue = new \SplQueue();
        $this->_capacity = $capacity;
    }

    /** @inheritdoc  */
    public function __destruct()
    {
        $this->close();
    }

    public function pop(int $timeout = -1): mixed
    {
        if ($this->_queue) {
            return $this->_queue->dequeue();
        }
        return false;
    }

    /** @inheritdoc
     * @param mixed $data
     * @param int $timeout
     */
    public function push(mixed $data, int $timeout = -1): bool
    {
        if ($this->_queue) {
            $this->_queue->enqueue($data);
            return true;
        }
        return false;
    }

    /** @inheritdoc  */
    public function isEmpty(): bool
    {
        return $this->_queue?->isEmpty() ?: true;
    }

    /** @inheritdoc  */
    public function isFull(): bool
    {
        return !($this->_capacity < 0) && $this->_capacity <= intval($this->_queue?->count());
    }

    /** @inheritdoc  */
    public function close(): void
    {
        $this->_queue = null;
    }

    /** @inheritdoc  */
    public function capacity(): int
    {
        return $this->_capacity;
    }
}