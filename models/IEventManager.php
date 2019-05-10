<?php
/**
 * Created by PhpStorm.
 * User: owonnarr
 * Date: 07.05.19
 * Time: 9:39
 */

namespace app\models;


interface IEventManager
{
    public function addEventListener($type, callable $callback);
    public function fireEvent($type);
}