<?php

namespace GregPriday\RobustOpenAI\Middleware;

use GregPriday\RobustOpenAI\Facades\RequestLogger;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class LoggerMiddleware
{
    private $nextHandler;
    private array $defaultOptions;
    private array $responses;

    public static function factory(array $defaultOptions = []): callable
    {
        return function (callable $handler) use ($defaultOptions) {
            return new static($handler, $defaultOptions);
        };
    }

    public function __construct(callable $nextHandler, array $defaultOptions = [])
    {
        $this->nextHandler = $nextHandler;
        $this->defaultOptions = $defaultOptions;
        $this->responses = [];
    }

    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        // Call the next handler
        $next = $this->nextHandler;
        return $next($request, $options)
            ->then($this->onFulfilled($request, $options), $this->onRejected($request, $options));
    }

    protected function onFulfilled(RequestInterface $request, array $options): callable
    {
        return function (ResponseInterface $response) use ($request, $options) {
            if (config('robust-openai.log_requests', false)) {
                // Read the contents of the body
                $body = $response->getBody();
                $contents = $body->getContents();

                // Rewind the body stream to allow further reads
                $body->rewind();

                // Decode the JSON response
                $r = json_decode($contents, true);

                RequestLogger::log($r, $response->getHeader('openai-processing-ms')[0]);
            }

            return $response;
        };
    }

    protected function onRejected(RequestInterface $request, array $options): callable
    {
        return function (Throwable $reason) use ($request, $options): PromiseInterface {
            return \GuzzleHttp\Promise\Create::rejectionFor($reason);
        };
    }
}
