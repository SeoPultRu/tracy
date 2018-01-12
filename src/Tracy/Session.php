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

        if (!isset($_SESSION[$this->globalKey])) {
            $_SESSION[$this->globalKey] = [];
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
    public function setValue($key, $value)
    {
        $keys = (array)$key;
        $session = &$_SESSION[$this->globalKey];

        foreach ($keys as $keyNode) {
            if (!isset($session[$keyNode])) {
                $session[$keyNode] = [];
            }

            $session = &$session[$keyNode];
        }

        $session = $value;
    }

    /**
     * @inheritdoc
     */
    public function getValue($key)
    {
        return $this->getValueByArray((array)$key);
    }

    /**
     * Returns value by keys array
     *
     * @param array $keys
     * @param bool $create if true, nodes will be created
     * @return mixed
     */
    private function getValueByArray(array $keys, $create = false)
    {
        $node = $_SESSION[$this->globalKey];
        $currentKey = [];

        foreach ($keys as $key) {
            if ($node === null) {
                if ($create) {
                    $this->setValue($currentKey, []);
                    $node = $this->getValue($currentKey);
                } else {
                    return null;
                }
            }

            $currentKey[] = $key;
            if (!isset($node[$key])) {
                if ($create) {
                    $this->setValue($currentKey, null);
                } else {
                    return null;
                }
            }

            $node = $this->getValue($currentKey);
        }

        return $node;
    }
}