<?php

/**
 * PHPOne/Db/Table/Abstract.php
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


abstract class PHPOne_Db_Table_Abstract extends PHPOne
{

    /**
     * List of table columns
     *
     * @var array of PHPOne_Db_Table_Column_Abstract
     */
    protected $columns;

    /**
     * Table comments
     *
     * @var string
     */
    protected $comments;

    /**
     * Table storage engine
     *
     * @var PHPOne_Db_Table_Engine_Abstract
     */
    protected $engine;

    /**
     * Get table columns
     *
     * @return array of PHPOne_Db_Table_Column_Abstract
     */
    public function getColumns()
    {
        if (!is_array($this->columns)) {
            $this->columns = $this->_populateColumns();
        }
        return $this->columns;
    }

    /**
     * Set table columns
     *
     * @param array of PHPOne_Db_Table_Column_Abstract
     */
    public function setColumns(Array $columns)
    {
        $this->columns = array();
        // accepts only PHPOne_Db_Table_Column_Abstract
        foreach ($columns as $column) {
            if (!$column instanceof PHPOne_Db_Table_Column_Abstract) continue;
            $this->columns[] = $column;
        }
    }

    /**
     * Get table comment
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set table comments
     *
     * @param string
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get table storage engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set table storage engine
     *
     * @param PHPOne_Db_Table_Engine_Abstract
     */
    public function setEngine(PHPOne_Db_Table_Engine_Abstract $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Constructor
     *
     * @param string optional table name
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
    }

}
