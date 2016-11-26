<?php namespace Bschmitt\Amqp;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;

/**
 * @author Björn Schmitt <code@bjoern.io>
 */
abstract class Context
{

    const REPOSITORY_KEY = 'amqp';

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Context constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->extractProperties($config);
    }

    /**
     * @param Repository $config
     */
    protected function extractProperties(Repository $config)
    {
        if ($config->has(self::REPOSITORY_KEY)) {
            $data = $config->get(self::REPOSITORY_KEY);
            $this->properties = $data['properties'][$data['use']];
        }
    }

    /**
     * @param array $properties
     * @return $this
     */
    public function mergeProperties(array $properties)
    {
        $this->properties = array_merge($this->properties, $properties);
        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getProperty($key,$default = null)
    {
        return Arr::get($this->properties, $key, $default);
    }

    /**
     * @return mixed
     */
    abstract function setup();

}
