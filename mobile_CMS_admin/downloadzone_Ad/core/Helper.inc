<?php
/*************************************************************************

PHP Version: 5.0.4 Xampp
Class Name: Helper 
Description: these are common helper functions
Version Date: 1.0 21.09.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("dbmanager.inc");
include_once("stderror.inc");
class Helper
{
	public static function deleteData($delete_qry)
	{
		try
		{
			$dbc = new DbManager();
			//delete query returns no of rows affected. need to check for greater than 1 for success
			if($dbc->executeNonQuery($delete_qry) >= StdError::$SUCCESS)
			{
				$ret_val = StdError::$SUCCESS;
			}
			else
			{
				$ret_val = StdError::$RECORD_DELETE_FAILURE;
			}
		}
		catch(Exception $e)
		{
			$ErrCode =  ExManager::Manage($e,"public function Helper::deleteData()");
			$ret_val = StdError::$UNKNOWN_ERROR;
		}
		return $ret_val;
	}


	public static function insertData($insert_qry)
	{
		try
		{
			$dbc = new DbManager();

			if($dbc->executeNonQuery($insert_qry) == StdError::$SUCCESS)
			{
				$ret_val = StdError::$SUCCESS;
			}
			else
			{
				$ret_val = StdError::$RECORD_INSERT_FAILURE;
			}
		}
		catch(Exception $e)
		{
			$ErrCode =  ExManager::Manage($e,"public function Helper::insertData()");
			$ret_val = StdError::$UNKNOWN_ERROR;
		}
		return $ret_val;
	}

	public static function checkExists($checkQry)
	{
		try
		{	
			$dbc = new DbManager();
			$tmpTable = $dbc->executeQuery($checkQry);	
			
			if($tmpTable->RowCount == 1)
			{
				$ret_val =  StdError::$RECORD_EXISTS;	
			}
			else if($tmpTable->RowCount > 1)
			{
				$ret_val = StdError::$MULTIPLE_RECORDS_EXISTS;
			}
			else
			{
				$ret_val = StdError::$RECORD_NOT_FOUND;
				
			}
			//echo StdError::$RECORD_EXISTS;
		}
		catch(Exception $e)
		{
			$ErrCode =  ExManager::Manage($e,"public function Helper::checkExists()");
			$ret_val = StdError::$UNKNOWN_ERROR;
		}
		return $ret_val;
	}

	public static function updateData($update_qry)
	{
		try
		{
			$dbc = new DbManager();

			if($dbc->executeNonQuery($update_qry) == StdError::$SUCCESS)
			{
				$ret_val = StdError::$SUCCESS;
			}
			else
			{
				$ret_val = StdError::$RECORD_UPDATE_FAILURE;
			}
		}
		catch(Exception $e)
		{
			$ErrCode =  ExManager::Manage($e,"public function Helper::updateData()");
			$ret_val = StdError::$UNKNOWN_ERROR;
		}
		return $ret_val;
	}

	public static function getData($select_qry)
	{
		try
		{
			$dbc = new DbManager();
			$tmpTable = $dbc->executeQuery($select_qry); 

			if($tmpTable != NULL && $tmpTable->RowCount >= 1) {
				$ret_val = $tmpTable->ROWS;
			}
			else {
				$ret_val = StdError::$RECORD_NOT_FOUND;
			}

		}
		catch(Exception $e)
		{
			$ErrCode =  ExManager::Manage($e,"public function Helper::getData()");
			$ret_val = StdError::$UNKNOWN_ERROR;
		}
		return $ret_val;
	}
	
	
}

?>