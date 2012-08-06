<?php

/**
 * PHPOne/Db/Table/Column/Abstract.php
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


abstract class PHPOne_Db_Table_Column_Abstract extends PHPOne
{

    /**
     * Column length
     *
     * @var string
     */
    protected $length;

    /**
     * Column data type
     *
     * @var PHPOne_Db_Table_Column_Type_Abstract
     */
    protected $type;

    /**
     * Column default
     *
     * @var string
     */
    protected $default;

    /**
     * Column is null
     *
     * @var boolean
     */
    protected $isNull;

    /**
     * Is column autoincrement
     *
     * @var boolean
     */
    protected $isAutoIncrement;

    /**
     * Column is primary
     *
     * @var boolean
     */
    protected $isPrimaryKey;

    /**
     * Is column unique
     *
     * @var boolean
     */
    protected $isUnique;

    /**
     * Is column multiple
     *
     * @var boolean
     */
    protected $isMultiple;

    /**
     * Get column length
     *
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Get column type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get column default
     *
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Set column length
     *
     * @param string
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * Set column type
     *
     * @param PHPOne_Db_Table_Column_Index_Abstract
     */
    public function setType(PHPOne_Db_Table_Column_Type_Abstract $type)
    {
        $this->type = $type;
    }

    /**
     * Set column default
     *
     * @param string
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * Set column attributes
     *
     * @param string
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Constructor
     *
     * @return string column name
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    /**
     * Get/Set is null
     *
     * @param boolean use to set
     * @return boolean
     */
    public function isNull($isNull = null)
    {
        if ($isNull !== null) {
            $this->isNull = (bool)$isNull;
        }
        return $this->isNull;
    }

    /**
     * Get/Set autoincrement
     *
     * @param boolean use to set
     * @return boolean
     */
    public function isAutoIncrement($autoIncrement = null)
    {
        if ($autoIncrement !== null) {
            $this->isAutoIncrement = (bool)$autoIncrement;
        }
        return $this->isAutoIncrement;
    }

    /**
     * Get/Set is primary key
     *
     * @param boolean use to set
     * @return boolean
     */
    public function isPrimaryKey($isPrimaryKey = null)
    {
        if ($isPrimaryKey !== null) {
            $this->isPrimaryKey = (bool)$isPrimaryKey;
        }
        return $this->isPrimaryKey;
    }

    /**
     * Get/Set is unique
     *
     * @param boolean use to set
     * @return boolean
     */
    public function isUnique($isUnique = null)
    {
        if ($isUnique !== null) {
            $this->isUnique = (bool)$isUnique;
        }
        return $this->isUnique;
    }

    /**
     * Get/Set is multiple
     *
     * @param boolean use to set
     * @return boolean
     */
    public function isMultiple($isMultiple = null)
    {
        if ($isMultiple !== null) {
            $this->isMultiple = (bool)$isMultiple;
        }
        return $this->isMultiple;
    }

}
