<?php

/**
 * PHPOne/Db/Adapter/Abstract.php
 *
 * Copyright (c) 2012, PHP One <info@phpone.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of PHPOne nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    PHPOne
 * @subpackage Db
 * @author     Arthur Layese <spydr@phpone.org>
 * @copyright  2012 PHPOne <info@phpone.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.phpone.org/
 */


abstract class PHPOne_Db_Adapter_Abstract
{

    /**
     * Database Host name
     *
     * @var string
     */
    protected $hostname = 'localhost';

    /**
     * Database username
     *
     * @var string
     */
    protected $username;

    /**
     * Database password
     *
     * @var string
     */
    protected $password;

    /**
     * Database name
     *
     * @var string
     */
    protected $dbname;

    /**
     * Database port
     *
     * @var string
     */
    protected $port;

    /**
     * Database socket
     *
     * @var string
     */
    protected $socket;

    /**
     * Database connection
     *
     * @var object
     */
    protected $connection;

    /**
     * Error messages
     *
     * @var array
     */
    protected $errors = array();

    /**
     * Get database hostname
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Get database username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get database password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get database name
     *
     * @return string
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * Get database port
     *
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Get database socket
     *
     * @return string
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * Get database connection
     *
     * @return object
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get error messages
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set database hostname
     *
     * @param string
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Set database username
     *
     * @param string
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Set database password
     *
     * @param string
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Set database name
     *
     * @param string
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
    }

    /**
     * Set database port
     *
     * @param string
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * Set database socket
     *
     * @param string
     */
    public function setSocket($socket)
    {
        $this->socket = $socket;
    }

    /**
     * Set database connection
     *
     * @param object
     */
    public function setConnection($connection)
    {
        if (is_object($connection)) { // only set if passed connection is object type
            $this->connection = $connection;
        }
    }

    /**
     * Set error messages
     *
     * @param array
     */
    public function setErrors(Array $errors)
    {
        if (is_array($errors)) {
            $this->errors = $errors;
        }
    }

    /**
     * Add error to error message list
     *
     * @param mixed
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * Constructor
     *
     * @param string database hostname
     * @param string database username
     * @param string database password
     * @param string database name
     * @param string database port
     * @param string database socket
     */
    public function __construct($hostname = null, $username = null, $password = null, $dbname = null, $port = null, $socket = null)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
        $this->socket = $socket;
    }

    /**
     * Check if connected to db server
     *
     * @return boolean
     */
    public function isConnected()
    {
        return is_object($this->connection);
    }

    /**
     * Describe database tables
     *
     * @return array PHPOne_Db_Table_Abstract
     */
    abstract public function describeTables();

    /**
     * Describe table columns
     *
     * @param string table name
     * @return array PHPOne_Db_Table_Column_Abstract
     */
    abstract public function describeColumns($table);

}
