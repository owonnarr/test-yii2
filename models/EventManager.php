<?php
/**
 * Created by PhpStorm.
 * User: owonnarr
 * Date: 07.05.19
 * Time: 9:39
 */

namespace app\models;

class EventManager implements IEventManager
{
    private $types = [];

    /**
     * @param $type
     * @param callable $callback
     * @return mixed
     */
    public function addEventListener($type, callable $callback)
    {
        $this->types[$type] = $callback;
        return call_user_func($callback, $this->types[$type]);
    }

    public function fireEvent($type)
    {
        return call_user_func($this->types[$type], $type);
    }
}