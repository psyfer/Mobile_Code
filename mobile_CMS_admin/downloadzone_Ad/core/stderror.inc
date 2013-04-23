<?php
/*************************************************************************

PHP Version: 5.0.4 Xampp
File name: blm.core.common.error.inc
Class Name: StdError 
Description: This class handles all the non-exceptional handled errors.
Version Date: 1.0 21.12.2005      
Author: IS
**************************************************************************/

class StdError
{

	public static $SUCCESS = 1;

    public static $RECORD_NOT_FOUND = -1;
    public static $RECORD_EXISTS = -2;
    public static $MULTIPLE_RECORDS_EXISTS = -17;

    public static $RECORD_INSERT_FAILURE = -3;
    public static $RECORD_UPDATE_FAILURE = -4;
    public static $RECORD_DELETE_FAILURE = -5;

    public static $SESSION_FAILURE = -6;
    public static $USR_PASS_FAILURE = -7;

    public static $DATABASE_FAILURE = -8;

	public static $USER_DOES_NOT_EXIST = -9;
	public static $PASSWORD_UNMATCHED = -10;

	public static $PARAMETER_BLANK = -11;

	public static $UNKNOWN_ERROR = -12;
	public static $USER_DOES_EXIST = -13;
	
	public static $ARRAY_PROP_NOT_EXIST = -14;
	public static $ARRAY_PROP_RESTRICTED = -15;

	public static $USER_SAME = -16;
	
	public static $MOBILE_NUMBER_EXIST = -18;
	
	public static $USER_ALREADY_ACTIVATED = -19;
	
	public static $USER_ACTIVATED = -20;

	public static $USER_PERMISSION_DENIED = -21;

	public static $PICTURE_UPLOAD_FAILURE = -22;

	public static $FILE_NOT_FOUND = -23;
	public static $IMAGE_NOT_FOUND = -24;
	public static $IMAGE_UNLINK_FAILURE = -25;


    public static function handle($errCode)
    {
		switch ($errCode)
		{
			case -1:
				$rtnval = "RECORD_NOT_FOUND"; 
				break;
			case -2:
				$rtnval = "RECORD_EXISTS"; 
			    break;
			case -3:
				$rtnval = "RECORD_INSERT_FAILURE"; 
			    break;
			case -4:
				$rtnval = "RECORD_UPDATE_FAILURE"; 
			    break;
			case -5:
				$rtnval = "RECORD_DELETE_FAILURE"; 
			    break;
			case -6:
				$rtnval = "SESSION_FAILURE"; 
			    break;
			case -7:
				$rtnval = "USR_PASS_FAILURE"; 
			    break;
			case -8:
				$rtnval = "DATABASE_FAILURE"; 
			    break;

			case -9:
				$rtnval = "USER DOES NOT EXIST"; 
			    break;

			case -10:
				$rtnval = "PASSWORD NOT MATCHED FOR THE USER"; 
			    break;

			case -11:
				$rtnval = "PARAMETER BLANK"; 
			    break;

			case -12:
				$rtnval = "UNKNOWN_ERROR_OCCURED"; 
			    break;
			case -13:
			    $rtnval = "USER DOES EXIST"; 
			    break;
			case -14:
			    $rtnval = "ARRAY_PROP_NOT_EXIST"; 
			    break;
			case -15:
			    $rtnval = "ARRAY_PROP_RESTRICTED"; 
			    break;
			case -16:
			    $rtnval = "SAME USER INVALID"; 
			    break;
			case -17:
			    $rtnval = "MULTIPLE_RECORDS_EXISTS"; 
			    break;
			case -18:
			    $rtnval = "MOBILE_NUMBER_EXIST"; 
			    break;
			case -19:
			    $rtnval = "USER_ALREADY_ACTIVATED"; 
			    break;
			case -20:
			    $rtnval = "USER_ACTIVATED"; 
			    break;
			case -21:
			    $rtnval = "USER_PERMISSION_DENIED"; 
			    break;
			case -22:
			    $rtnval = "PICTURE_UPLOAD_FAILURE"; 
			    break;
			case -23:
			    $rtnval = "FILE_NOT_FOUND"; 
			    break;
			case -24:
			    $rtnval = "IMAGE_NOT_FOUND"; 
			    break;
			case -25:
			    $rtnval = "IMAGE_UNLINK_FAILURE"; 
			    break;
			case 1:
				$rtnval = "SUCCESS"; 
			    break;



		}  
		return $rtnval;
	}

}


?>