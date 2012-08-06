<?php

/**
 * PHPOne/Db.php
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
 * @author     Arthur Layese <spydr@phpone.org>
 * @copyright  2012 PHPOne <info@phpone.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.phpone.org/
 */


class PHPOne_Db extends PHPOne
{

    /**
     * Db Adapter
     *
     * @var PHPOne_Db_Adapter_Abstract
     */
    protected $adapter;

    /**
     * List of Database tables
     *
     * @var array of PHPOne_Db_Table_Abstract
     */
    protected $tables;

    /**
     * Get database adapter
     *
     * @return PHPOne_Db_Adapter_Abstract
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Get list of tables
     *
     * @return array of PHPOne_Db_Table_Abstract
     */
    public function getTables()
    {
        if (!is_array($this->tables)) {
            $this->tables = $this->_populateTables();
        }
        return $this->tables;
    }

    /**
     * Set database adapter
     *
     * @params PHPOne_Db_Adapter_Abstract
     */
    public function setAdapter(PHPOne_Db_Adapter_Abstract $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Set tables for database
     *
     * @params array of PHPOne_Db_Table_Abstract
     */
    public function setTables(Array $tables)
    {
        $this->tables = array();
        // accepts only PHPOne_Db_Table_Abstract
        foreach ($tables as $table) {
            if (!$table instanceof PHPOne_Db_Table_Abstract) continue;
            $this->tables[] = $table;
        }
    }

    /**
     * Get database adapter name
     *
     * @return string
     */
    public function getAdapterName()
    {
        $adapterName = '';
        if ($this->adapter instanceof PHPOne_Db_Adapter_Abstract) {
            $adapterPrefix = 'PHPOne_Db_Adapter_';
            $adapterName = substr(get_class($this->adapter), strlen($adapterPrefix));
        }
        return $adapterName;
    }

    /**
     * Constructor
     *
     * @param string adapter name
     * @param mixed database options - if array, keys are the following: hostname, username, password, dbname, port, socket
     */
    public function __construct($adapterName, $options)
    {
        parent::__construct();
        $adapterClass = 'PHPOne_Db_Adapter_'.$adapterName;

        $opts = array(
            'hostname' => 'localhost',
            'username' => null,
            'password' => null,
            'dbname' => null,
            'port' => null,
            'socket' => null,
        );

        if (is_array($options)) {
            foreach ($options as $key=>$value) {
                if (!array_key_exists($key, $opts)) continue;
                $opts[$key] = $value;
            }
        }
        else if ($options instanceof StdClass) {
            foreach ($opts as $key=>$value) {
                if (!isset($options->$key)) continue;
                $opts[$key] = $options->$key;
            }
        }

        $this->adapter = new $adapterClass($opts['hostname'], $opts['username'], $opts['password'], $opts['dbname'], $opts['port'], $opts['socket']);
        $connection = $this->adapter->getConnection();
        if ($this->adapter->isConnected() && $this->adapter instanceof PHPOne_Db_Adapter_Abstract) {
            $this->tables = $this->adapter->describeTables();
        }
    }

}
