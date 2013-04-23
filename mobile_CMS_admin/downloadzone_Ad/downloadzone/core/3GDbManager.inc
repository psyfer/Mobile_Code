<?php
/*************************************************************************

PHP Version: 5.0.4 Xampp
Class Name: DbManager
Description: database constructor and connection builder
Version Date: 1.0 21.09.2006      
Author: Pasan Rajapaksha
**************************************************************************/

include_once("3GConfigurationSettings.inc");
include_once("DataTable.inc");



class DbManager {


			private $Host = NULL;
			private $Database = NULL;
			private $Username = NULL;
			private $Password = NULL;
			private $Connection = NULL;
			private $AppSettings = NULL;
			

	function __construct()
	{
		try
		{
		   //$this->AppSettings  = new ConfigurationSettings();
		   $this->Host         = ConfigurationSettings::$Host;
		   $this->Database     = ConfigurationSettings::$Database;//$this->AppSettings->Settings['Database'];
		   $this->Username     = ConfigurationSettings::$Username;//$this->AppSettings->Settings['Username'];
		   $this->Password     = ConfigurationSettings::$Password;//$this->AppSettings->Settings['Password'];
		   
		   //$this->Connection = mysql_connect($this->Host,$this->Username,$this->Password);
	
		   
		}
		catch(Exception $e)
		{
			$ErrCode =  ExManager::Manage($e,"public function DbManager::__construct()");

		}
	}



	public function executeQuery($strQry)
    {
		try
		{
			$tmpTable = NULL;

						
			$this->Connection = mysql_connect($this->Host,$this->Username,$this->Password);
						
			if($this->Connection == NULL)
			{
			
				$tmpTable = StdError::$DATABASE_FAILURE;
			}
			else
			{
				mysql_select_db($this->Database,$this->Connection);

				
				$result = mysql_query($strQry,$this->Connection);// or die(mysql_error());
				
				
				if($result != NULL)
				{
						$tmpTable = new DataTable($result,$this->Connection);
				}
				
				mysql_close($this->Connection);
			}
		}
		catch(Exception $e)
		{
			
			$ErrCode =  ExManager::Manage($e,"public function DbManager::executeQuery()");
		}        
		return $tmpTable;
    }
    
    public function executeNonQuery($strQry)
    {
		try
		{
			$this->Connection = mysql_connect($this->Host,$this->Username,$this->Password);
			
			
			if(is_null($this->Connection))
			{
							
				$return = StdError::$DATABASE_FAILURE;
			}
			else
			{

			mysql_select_db($this->Database,$this->Connection);


			$result = mysql_query($strQry,$this->Connection);
			$return = mysql_affected_rows($this->Connection);
			
			mysql_close($this->Connection);
			}

		}
		catch(Exception $e)
		{
			$ErrCode =  ExManager::Manage($e,"public function DbManager::executeNonQuery()");
		}	
		return $return;
    }

	public function beginTransaction()
    {
    	try
    	{
			
            mysql_query("BEGIN",$this->Connection);
    	}
    	catch(Exception $e)
    	{
    		throw $e;
		}
    }
    
    public function commitTransaction()
    {
    	try
		{
			
			
	        mysql_query("COMMIT",$this->Connection);
		}	
		catch(Exception $e)
		{
			throw $e;
		}
    }
    
    public function rollbackTransaction()
    {
    	try
		{
	        mysql_query("ROLLBACK",$this->Connection);
		}
		catch(Exception $e)
		{
			throw $e;
		}
    }
	
	/*function __destruct()
	{
		mysql_close($this->Connection);
	}
    */
    
    public function execStoredProcedure()
    {
    	$procName;
    	$strSQL;
    	$result;
    	$params = array();
    	try
    	{
    		$procName = func_get_arg(0);
    		if($procName != NULL)
    		{
    			for($i = 1 ; $i < func_num_args(); $i++) 
    			{
    	 			$params[$i] = func_get_arg($i);
			}
			
			$elements = count($params)-1;
			
			$strSQL = "call " . $procName . "(";
			foreach($params as $param)
			{
				if($index == $elements)
					$strSQL .= $param;
				else
					$strSQL .= $param . ",";
				$index++;
			}
			$strSQL .= ")";
		}
		$result = $this->executeQuery($strSQL);
    	}
    	catch(Exception $e)
    	{
    		return $e;
    	}

    	return $result;
    }

}

?>