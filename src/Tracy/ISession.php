<?php

namespace Tracy;

/**
 * Custom session handler
 */
interface ISession
{
    /**
     * Activates custom session
     *
     * @return void
     */
    public function activate();

    /**
     * Returns true if custom session is active
     *
     * @return bool
     */
    public function isActive();

    /**
     * Sets value for key
     *
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);

    /**
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function add($key, $value);

    /**
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function delete($key, $value);

    /**
     * Returns value by key
     *
     * @param string|array $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string|array $key
     * @return void
     */
    public function clear($key);
}