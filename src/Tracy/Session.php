<?php

namespace Tracy;

/**
 * Default session handler
 */
class Session implements ISession
{
    private $globalKey = '_tracy';

    /**
     * @inheritdoc
     */
    public function activate()
    {
        ini_set('session.use_cookies', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_trans_sid', '0');
        ini_set('session.cookie_path', '/');
        ini_set('session.cookie_httponly', '1');
        session_start();
    }

    /**
     * @inheritdoc
     */
    public function isActive()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * @inheritdoc
     */
    public function setValue($key, $value)
    {
        $_SESSION[$this->globalKey][$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function getValue($key)
    {
        return $_SESSION[$this->globalKey][$key];
    }
}