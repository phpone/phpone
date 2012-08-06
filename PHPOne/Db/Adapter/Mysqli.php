<?php

/**
 * PHPOne/Db/Adapter/Mysqli.php
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


class PHPOne_Db_Adapter_Mysqli extends PHPOne_Db_Adapter_Abstract
{

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
    public function __construct($hostname = 'localhost', $username = null, $password = null, $dbname = null, $port = null, $socket = null)
    {
        parent::__construct($hostname, $username, $password, $dbname, $port, $socket);

        $mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->dbname, $this->port, $this->socket);

        if (mysqli_connect_error()) {
            $this->addError('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
        else {
            $this->connection = $mysqli;
        }
    }

    /**
     * Destructor, close any opened socket or database connection
     */
    public function __destruct()
    {
        if ($this->connection instanceof mysqli) {
            $this->connection->close();
        }
    }

    /**
     * Describe database tables
     *
     * @return array PHPOne_Db_Table_Abstract
     */
    public function describeTables()
    {
        $tables = array();
        $query = "SHOW TABLES";
        if ($result = $this->connection->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $key = 'Tables_in_' . $this->dbname;
                $tableName = $row[$key];
                $table = new PHPOne_Db_Table($tableName);
                if ($status = $this->describeStatus($tableName)) {
                    $engineClass = 'PHPOne_Db_Table_Engine_' . $status['Engine'];
                    $engine = new $engineClass();
                    $table->setEngine($engine);
                    $table->setComments($status['Comment']);
                }
                if ($columns = $this->describeColumns($tableName)) {
                    $table->setColumns($columns);
                }
                $tables[] = $table;
            }
        }
        return $tables;
    }

    /**
     * Describe table status
     *
     * @param string table name
     * @return array
     */
    public function describeStatus($table)
    {
        $status = array();
        $query = "SHOW TABLE STATUS FROM `{$this->dbname}` WHERE Name = '{$table}'";
        if ($result = $this->connection->query($query)) {
            $status = $result->fetch_assoc();
        }
        return $status;
    }

    /**
     * Describe table columns
     *
     * @param string table name
     * @return array PHPOne_Db_Table_Column_Abstract
     */
    public function describeColumns($table)
    {
        $columns = array();
        $query = "SHOW COLUMNS FROM `{$table}`";
        if ($result = $this->connection->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $column = new PHPOne_Db_Table_Column($row['Field']);
                $length = '';
                $pos = stripos($row['Type'], '(');
                if ($pos !== false) {
                    $datatype = ucwords(substr($row['Type'], 0, $pos));
                    $length = substr($row['Type'], ($pos + 1), -1);
                }
                else {
                    $datatype = ucwords($row['Type']);
                }

                $column->setLength($length);
                $typeClass = 'PHPOne_Db_Table_Column_Type_' . $datatype;
                $type = new $typeClass();
                $column->setType($type);
                $column->setDefault($row['Default']);

                $column->setAttributes($type);
                $isNull = ($row['Null'] == 'YES')? true : false;
                $column->isNull($isNull);
                $isAutoIncrement = ($row['Extra'] == 'auto_increment')? true : false;
                $column->isAutoIncrement($isAutoIncrement);
                switch ($row['Key']) {
                    case 'PRI':
                        $column->isPrimaryKey(true);
                        break;
                    case 'UNI':
                        $column->isUnique(true);
                        break;
                    case 'MUL':
                        $column->isMultiple(true);
                        break;
                }
                $columns[] = $column;
            }
        }
        return $columns;
    }

}
