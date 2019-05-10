<?php
/**
 * Created by PhpStorm.
 * User: owonnarr
 * Date: 09.05.19
 * Time: 16:35
 */

namespace app\helpers;

use Yii;

class AuthHelper
{
    const AUTH_KEY = 'login';
    const COUNT_ATTEMPT = 3;

    /**
     * check user authorize or guest
     * @return bool
     */
    public function isAuth() :bool
    {
        return Yii::$app->session->has(self::AUTH_KEY);
    }

    /**
     * remove auth key for authorize user
     * @return mixed
     */
    public function removeAuthSessionKey()
    {
        if (!Yii::$app->session->has(self::AUTH_KEY)) {
            throw new \DomainException('Error. Auth key не найден');
        }
        return Yii::$app->session->remove(self::AUTH_KEY);
    }

    /**
     * create auth key for user
     * @return mixed
     */
    public function createAuthSessionKey()
    {
        return Yii::$app->session->set(self::AUTH_KEY, true);
    }

    /**
     * increment attempt count
     */
    public function incrementAttempts()
    {
        $attempt = 0;

        if (Yii::$app->session->has('attempt_count')) {
            $attempt = Yii::$app->session->get('attempt_count');
            return Yii::$app->session->set('attempt_count', $attempt + 1);
        }
        Yii::$app->session->set('attempt_count', $attempt);
        return $attempt;
    }

    /**
     * get attemptCount
     * @return int
     */
    public function getAttemptCount() :int
    {
        if (!Yii::$app->session->has('attempt_count')) {
            return $this->incrementAttempts();
        }
        return (int) Yii::$app->session->get('attempt_count');
    }

    /**
     * temporarily block user after three error attempts login
     * @return float|int
     */
    public function temporarilyBlock()
    {
        $blockedTime = time() + (1 * 20);

        if (Yii::$app->session->has('blockedTime')) {
            return $blockedTime;
        }
        Yii::$app->session->set('blockedTime', $blockedTime);
        return $blockedTime;
    }


    /**
     * get time to unlock user
     * @return false|int|string
     */
    public function getTimeToUnlock()
    {
        $currentTime = time();
        $blockedTime = Yii::$app->session->get('blockedTime');
        $timeToUnlock = date('i:s', $blockedTime - $currentTime);

        if ($currentTime > $blockedTime) {
           Yii::$app->session->remove('blockedTime');
           Yii::$app->session->remove('attempt_count');
           return false;
        }
        return $timeToUnlock;
    }

    /**
     * check is blocked user
     * @return bool
     */
    public function isBlocked() :bool
    {
        if (Yii::$app->session->has('blockedTime')) {
            return true;
        }
        return false;
    }
}