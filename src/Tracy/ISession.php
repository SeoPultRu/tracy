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
    public function setValue($key, $value);

    /**
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function addValue($key, $value);

    /**
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function delValue($key, $value);

    /**
     * Returns value by key
     *
     * @param string|array $key
     * @return mixed
     */
    public function getValue($key);

    /**
     * @param string|array $key
     * @return void
     */
    public function clearValue($key);
}