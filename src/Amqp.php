<?php namespace Bschmitt\Amqp;

use Closure;

/**
 * @author Björn Schmitt <code@bjoern.io>
 */
class Amqp
{

    /**
     * @param string $routing
     * @param mixed $message
     * @param array $properties
     */
    public function publish($routing, $message, array $properties = [])
    {
        $properties['routing'] = $routing;

        /* @var Publisher $publisher */
        $publisher = \App::make('Bschmitt\Amqp\Publisher');
        $publisher
            ->mergeProperties($properties)
            ->setup();

        $messageProperties = ['content_type' => 'text/plain', 'delivery_mode' => 2];
        $messageProperties = array_merge($messageProperties, $publisher->getProperty('message_properties'));

        if (is_string($message)) {
            $message = new Message($message, $messageProperties);
        }

        $publisher->publish($routing, $message);
        Request::shutdown($publisher->getChannel(), $publisher->getConnection());
    }

    /**
     * @param string $queue
     * @param Closure $callback
     * @param array $properties
     * @throws Exception\Configuration
     */
    public function consume($queue, Closure $callback, $properties = [])
    {
        $properties['queue'] = $queue;

        /* @var Consumer $consumer */
        $consumer = \App::make('Bschmitt\Amqp\Consumer');
        $consumer
            ->mergeProperties($properties)
            ->setup();

        $consumer->consume($queue, $callback);
        Request::shutdown($consumer->getChannel(), $consumer->getConnection());
    }

    public function declareExchange($exchange, $exchangeType)
    {

        $properties['exchange'] = $exchange;
        $properties['exchange_type'] = $exchangeType;

        $request = \App::make('Bschmitt\Amqp\Request');
        $request->mergeProperties($properties);
        $request->exchangeDeclare($exchange, $exchangeType);
        return $exchange;
    }

    public function declareQueue($queue, $exchange, $routingKey)
    {
        $properties['queue'] = $queue;
        $properties['routing_key'] = $routingKey;

        $request = \App::make('Bschmitt\Amqp\Request');
        $request->mergeProperties($properties);

        $request->queueDeclare($queue, $exchange, $routingKey);
    }

    /**
     * @param string $body
     * @param array $properties
     * @return \Bschmitt\Amqp\Message
     */
    public function message($body, $properties = [])
    {
        return new Message($body, $properties);
    }

}