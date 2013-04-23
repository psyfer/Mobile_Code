<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:greeting uploading
Description: common page to upload all greetings
Version Date: 1.0 10.10.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/helper.inc");

if(isset($_REQUEST["vendor"]))$gvend=$_REQUEST["vendor"]; else $gvend="";
if(isset($_REQUEST["rate"]))$grate=$_REQUEST["rate"]; else $grate="";
if(isset($_REQUEST["category"]))$gcat=$_REQUEST["category"];else $gcat="";
if(isset($_REQUEST["dname"]))$gdname=$_REQUEST["dname"]; else $gdname="";


//check for blank entries
function checkblank()
{
	global	$gdname,$gcat,$gvend,$ErrMsg;
		// check for blank in display name
		if(trim($gdname) == "" )
		{
			$ErrMsg = "Please enter display name!";
			return false;
			exit;
		}
		//check blank in cetegory
		if($gcat=="--select--")
		{
			$ErrMsg = "Please select a Category!";
			return false;
			exit;
		}
		//check blank in rate
		if($grate=="--select--")
		{
			$ErrMsg = "Please select a wap rate!";
			return false;
			exit;
		}
		//check blank in rate
		if($gvend=="--select--")
		{
			$ErrMsg = "Please select a vendor!";
			return false;
			exit;
		}
	return true;
}

switch ($_REQUEST["upload"])
{
	case "Upload":
		
		if(checkblank())
		{
			//upload preview image
			$gpimg=$HTTP_POST_FILES['pimg'];
			//upload preview image
			$gimg=$HTTP_POST_FILES['img'];
			
			//current system date
			$date=date('y-m-d H:i:s');
			
			if($gpimg['name'] <> "" && $gimg['name'] <> "")
			{
				//convert image files to binary
				$gpimagedata = addslashes(fread(fopen( $gpimg['tmp_name'], "r"), filesize( $gpimg['tmp_name'])));
				$gimagedata = addslashes(fread(fopen( $gimg['tmp_name'], "r"), filesize( $gimg['tmp_name'])));
			
				$ginsert_qry="insert into Gree_Details (ID,PIMAGE,IMAGE,DISPLAY_NAME,VENDOR_ID,RATE_ID,Date_Time,IMAGE_SIZE) values (".$gcat.",'".$gpimagedata."','".$gimagedata."','".$gdname."','".$gvend."',".$grate.",'".$date."','".$gimg['size']."')";
				$wres=helper::insertData($ginsert_qry);
						
				if($wres==StdError::$SUCCESS){
					
					$ErrMsg="Greeting uploaded succesfully";
				}
				else
				{
					$ErrMsg="Greeting upload Failure";
				}
			}
			else $ErrMsg="Please select an image to upload";
			
		}
	break;
}

//retrieve vendor information
$strsqlv="select * from Vendor ORDER BY VENDOR_ID";
$resv=helper::getdata($strsqlv);

//get the wap rates
$selrate="select SERVICE_NAME,RATE_ID from Wap_Rate where SERVICE_NAME='Greeting' or SERVICE_NAME='Premium Greeting'";
$resrate=helper::getdata($selrate);

//get the wallpaper category list
$selcal="select ID,CATAGORIES from Gree_Main_Cat ORDER BY CATAGORIES";
$rescal=helper::getdata($selcal);
?>


<form name="gree" action="<?PHP $PHP_SELF ?>" method="post" enctype="multipart/form-data">
<font color="#FF0000"><?=$ErrMsg?></font>
<fieldset>
	<legend><b>Upload Greeting<b></legend>
	<table>
		<tr>
			<td>Display Name:</td>
			<td><input type="text" name="dname" value="<?=$gdname?>" size="40"></td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<select name="category">
				<option>--select--</option>
				<?PHP foreach($rescal as $valc){?>
				<option value="<?=$valc["ID"]?>" <?PHP if($valc["ID"]==$gcat) {?>selected<?PHP } ?>><?=$valc["CATAGORIES"]?>-<?=$valc["ID"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Rate Id :</td>
			<td>
				<select name="rate">
				<option>--select--</option>
				<?PHP foreach($resrate as $valr){?>
				<option value="<?=$valr["RATE_ID"]?>" <?PHP if($valr["RATE_ID"]==$grate) {?>selected<?PHP } ?>><?=$valr["SERVICE_NAME"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Vendor:</td>
			<td>
				<select name="vendor">
				<option>--select--</option>
				<?PHP foreach($resv as $valv){?>
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$gvend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Preview Image:</td>
			<td><input type="file" name="pimg"></td>
		</tr>
		<tr>
			<td>Image:</td>
			<td><input type="file" name="img"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="upload" value="Upload"></td>
		</tr>
	</table>
</fieldset>
</form>