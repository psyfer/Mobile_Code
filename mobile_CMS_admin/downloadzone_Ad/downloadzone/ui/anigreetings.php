<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:annimated greeting uploading
Description: common page to upload animated greetings
Version Date: 1.0 10.10.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/helper.inc");

if(isset($_REQUEST["vendor"]))$agvend=$_REQUEST["vendor"]; else $agvend="";
if(isset($_REQUEST["rate"]))$agrate=$_REQUEST["rate"]; else $agrate="";
if(isset($_REQUEST["category"]))$agcat=$_REQUEST["category"];else $agcat="";
if(isset($_REQUEST["dname"]))$agdname=$_REQUEST["dname"]; else $agdname="";


//check for blank entries
function checkblank()
{
	global	$agdname,$agcat,$agvend,$ErrMsg;
		// check for blank in display name
		if(trim($agdname) == "" )
		{
			$ErrMsg = "Please enter display name!";
			return false;
			exit;
		}
		//check blank in cetegory
		if($agcat=="--select--")
		{
			$ErrMsg = "Please select a Category!";
			return false;
			exit;
		}
		//check blank in rate
		if($agrate=="--select--")
		{
			$ErrMsg = "Please select a wap rate!";
			return false;
			exit;
		}
		//check blank in rate
		if($agvend=="--select--")
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
			$agpimg=$HTTP_POST_FILES['pimg'];
			//upload preview image
			$agimg=$HTTP_POST_FILES['img'];
			
			//current system date
			$date=date('y-m-d H:i:s');
			
			if($agpimg['name'] <> "" && $agimg['name'] <> "")
			{
				//convert image files to binary
				$agpimagedata = addslashes(fread(fopen( $agpimg['tmp_name'], "r"), filesize( $agpimg['tmp_name'])));
				$agimagedata = addslashes(fread(fopen( $agimg['tmp_name'], "r"), filesize( $agimg['tmp_name'])));
			
				$aginsert_qry="insert into AniGree_Details (ID,PIMAGE,IMAGE,DISPLAY_NAME,VENDOR_ID,RATE_ID,Date_Time,IMAGE_SIZE) values (".$agcat.",'".$agpimagedata."','".$agimagedata."','".$agdname."','".$agvend."',".$agrate.",'".$date."','".$agimg['size']."')";
				$agres=helper::insertData($aginsert_qry);
						
				if($agres==StdError::$SUCCESS){
					
					$ErrMsg="Animated Greeting uploaded succesfully";
				}
				else
				{
					$ErrMsg="Animated Greeting upload Failure";
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
$selrate="select SERVICE_NAME,RATE_ID from Wap_Rate where SERVICE_NAME='Animated Greeting' or SERVICE_NAME='Premium Animated Greeting'";
$resrate=helper::getdata($selrate);

//get the wallpaper category list
$selcal="select ID,CATAGORIES from AniGree_Main_Cat ORDER BY CATAGORIES";
$rescal=helper::getdata($selcal);
?>


<form name="anigree" action="<?PHP $PHP_SELF ?>" method="post" enctype="multipart/form-data">
<font color="#FF0000"><?=$ErrMsg?></font>
<fieldset>
	<legend><b>Upload Animated Greeting<b></legend>
	<table>
		<tr>
			<td>Display Name:</td>
			<td><input type="text" name="dname" value="<?=$agdname?>" size="40"></td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<select name="category">
				<option>--select--</option>
				<?PHP foreach($rescal as $valc){?>
				<option value="<?=$valc["ID"]?>" <?PHP if($valc["ID"]==$agcat) {?>selected<?PHP } ?>><?=$valc["CATAGORIES"]?>-<?=$valc["ID"]?></option>
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
				<option value="<?=$valr["RATE_ID"]?>" <?PHP if($valr["RATE_ID"]==$agrate) {?>selected<?PHP } ?>><?=$valr["SERVICE_NAME"]?></option>
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
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$agvend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
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