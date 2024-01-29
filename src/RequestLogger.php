<?php

namespace GregPriday\RobustOpenAI;

class RequestLogger
{
    private array $events = [];
    private array $processingTimes = [];
    private bool $shouldLog;

    public function __construct(bool $shouldLog = false)
    {
        $this->shouldLog = $shouldLog;
    }

    public function log(array $response, int $processingTime)
    {
        if (!$this->shouldLog) {
            return;
        }

        $id = $response['id'];

        $this->events[$id] = $response;
        $this->processingTimes[$id] = $processingTime;
    }

    public function cost(): float
    {
        $costs = config('robust-openai.costs');
        $total = 0;
        foreach($this->events as $event) {
            foreach($event['usage'] as $k => $v) {
                $total += ($costs[$event['model']][$k] ?? 0) * $v / 1000;
            }
        }

        return $total;
    }

    /**
     * Get the processing times for the events
     */
    public function processingTimes(): array
    {
        return $this->processingTimes;
    }

    public function toArray()
    {
        return [
            'events' => $this->events,
            'processing_times' => $this->processingTimes,
            'cost' => $this->cost(),
        ];
    }
}
