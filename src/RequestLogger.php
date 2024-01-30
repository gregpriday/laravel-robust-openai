<?php

namespace GregPriday\RobustOpenAI;

class RequestLogger
{
    private array $events = [];
    private bool $shouldLog;

    public function __construct(bool $shouldLog = false)
    {
        $this->shouldLog = $shouldLog;
    }

    public function log(array $response, int $processingTime)
    {
        if (!$this->shouldLog || empty($response['model']) || empty($response['usage'])) {
            return;
        }

        $this->events[] = [
            'id' => $response['id'] ?? null,
            'model' => $response['model'],
            'usage' => $response['usage'],
            'processing_time' => $processingTime,
        ];
    }

    public function cost(): float
    {
        $costs = config('robust-openai.costs');
        $total = 0;
        foreach($this->events as $event) {
            $cost = $costs[$event['model']] ?? null;

            // This might be a fine-tuned model
            if (empty($cost) && str_starts_with($event['model'], 'ft:')) {
                foreach($costs['fine-tuned'] as $prefix => $cost) {
                    if (str_starts_with($event['model'], $prefix)) {
                        break;
                    }
                }
            }

            if(empty($cost)) {
                continue;
            }

            foreach($event['usage'] as $k => $v) {
                $total += ($cost[$k] ?? 0) * $v / 1000;
            }
        }

        return $total;
    }

    public function toArray()
    {
        return [
            'events' => $this->events,
            'cost' => $this->cost(),
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
