<?php

/*************************************************************************

PHP Version: 5.0.4 Xampp
Class Name: DataTable
Description: data table constructs
Version Date: 1.0 21.09.2006      
Author: Pasan Rajapaksha
**************************************************************************/

class DataTable
{

    private $props = array('mySQLResult' => NULL,
                           'ROWS' => NULL,
                           'RowCount' => NULL);
			                      
	private function _get($property)
	{
		$value = NULL;
		if(array_key_exists($property,$this->props))
			$value = $this->props[$property];
		else
			$value = "Property not exist";
		
		return $value;
	}	

	private function _set($property,$value)
	{
		if(array_key_exists($property,$this->props))
			$this->props[$property] = $value;
		else
			print "Property not exist";
		
	}

    public function __construct($mySqlResult)
    {
        $this->mySQLResult = $mySqlResult;
        $this->ROWS = $this->toArray();
        $this->RowCount = $this->getRowCount();
    }

    private function getRowCount()
    {
        if($this->mySQLResult <> false)
            return mysql_num_rows($this->mySQLResult);
        else    
            return 0;
    }

    private function toArray()
    {
        $arr = array();
        $rowid = 0;
        $cols = mysql_num_fields($this->mySQLResult);
        while ($row = mysql_fetch_array($this->mySQLResult, MYSQL_BOTH))
        {
            for($i=0;$i<=$cols-1;$i++)
            {
		$fieldName = mysql_field_name($this->mySQLResult,$i);
                $arr[$rowid][$fieldName] = $row[$fieldName];
            }
            $rowid++;
        }
        return $arr;
    }
}
?>