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
        if (!isset($_SESSION[$this->globalKey])) {
            $_SESSION[$this->globalKey] = [];
        }

        $keys = (array)$key;
        $node = &$_SESSION[$this->globalKey];

        foreach ($keys as $keyNode) {
            if (!isset($node[$keyNode])) {
                $node[$keyNode] = [];
            }

            $node = &$node[$keyNode];
        }

        $node = $value;
    }

    /**
     * @inheritdoc
     */
    public function getValue($key)
    {
        if (!isset($_SESSION[$this->globalKey])) {
            $_SESSION[$this->globalKey] = [];
        }

        $keys = (array)$key;
        $node = $_SESSION[$this->globalKey];

        foreach ($keys as $keyNode) {
            if (!isset($node[$keyNode])) {
                return null;
            }

            $node = $node[$keyNode];
        }

        return $node;
    }
}