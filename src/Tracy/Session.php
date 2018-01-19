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
        if (!$this->isActive()) {
            ini_set('session.use_cookies', '1');
            ini_set('session.use_only_cookies', '1');
            ini_set('session.use_trans_sid', '0');
            ini_set('session.cookie_path', '/');
            ini_set('session.cookie_httponly', '1');
            session_start();
        }
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
    public function set($key, $value)
    {
        $node = &$this->get($key);
        $node = $value;
    }

    /**
     * @inheritdoc
     */
    public function &get($key)
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

        return $node;
    }

    /**
     * @inheritdoc
     */
    public function add($key, $value)
    {
        $current = &$this->get($key);

        if (!is_array($current)) {
            $current = [];
        }

        $current[] = $value;
    }

    /**
     * @inheritdoc
     */
    public function delete($key, $value)
    {
        $node = &$this->get($key);

        if (is_array($node)) {
            $k = array_search($value, $node, true);
            if ($k !== false) {
                unset($node[$k]);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function clear($key)
    {
        $keys = (array)$key;
        $last = array_pop($keys);
        $node = &$this->get($keys);

        if (is_array($node)) {
            unset($node[$last]);
        }
    }

    /**
     * @inheritdoc
     */
    public function hasHistoryManagement()
    {
        return false;
    }
}