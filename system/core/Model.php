<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		log_message('info', 'Model Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}



    public function getOne($id)
    {
        if ($id <= 0) return array();

        $this->db->where($this->pkey, $id);
        $rows = $this->db->get($this->table);

        return $rows->row_array();
    }

    /**
     * 获得单条
     */
    public function getOneByCondition($condition)
    {
        $data = array();
        if (!is_array($condition)) return $data;

        $this->setCondition($condition);
        $this->db->order_by($this->pkey, 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $data = $query->row_array();
        return $data;
    }

    public function update($id, $data)
    {
        if ($id <= 0 || !is_array($data) || empty($data)) return 0;

        $this->db->where($this->pkey, $id);
        return $this->db->update($this->table, $data);
    }


    public function insert($data)
    {
        if (!is_array($data) || empty($data)) return 0;

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


    public function delete($id)
    {
        if ($id <= 0) return;

        $this->db->where($this->pkey, $id);
        $this->db->delete($this->table);

        return $this->db->affected_rows();
    }


    public function doQuery($sql)
    {
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function lastQuery()
    {
        return $this->db->last_query();
    }

    public function setCondition(array $condition)
    {
        if (empty($condition)) return;
        foreach ($condition as $key=>$value)
        {
            if (is_array($value))
            {
                $function = $value[1];
                $this->db->$function($key, $value[0]);
            }
            else
            {
                $this->db->where($key, $value);
            }

        }
    }

    public function updateByCondition($condition, $data)
    {
        if (!is_array($condition) || empty($condition) || !is_array($data) || empty($data)) return;

        $this->setCondition($condition);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

}
