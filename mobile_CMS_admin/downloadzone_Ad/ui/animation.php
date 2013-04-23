<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:annimation uploading
Description: common page to upload animation
Version Date: 1.0 11.10.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/helper.inc");

if(isset($_REQUEST["vendor"]))$anivend=$_REQUEST["vendor"]; else $anivend="";
if(isset($_REQUEST["rate"]))$anirate=$_REQUEST["rate"]; else $anirate="";
if(isset($_REQUEST["category"]))$anicat=$_REQUEST["category"];else $anicat="";
if(isset($_REQUEST["dname"]))$anidname=$_REQUEST["dname"]; else $anidname="";


//check for blank entries
function checkblank()
{
	global	$anidname,$anicat,$anivend,$ErrMsg;
		// check for blank in display name
		if(trim($anidname) == "" )
		{
			$ErrMsg = "Please enter display name!";
			return false;
			exit;
		}
		//check blank in cetegory
		if($anicat=="--select--")
		{
			$ErrMsg = "Please select a Category!";
			return false;
			exit;
		}
		//check blank in rate
		if($anirate=="--select--")
		{
			$ErrMsg = "Please select a wap rate!";
			return false;
			exit;
		}
		//check blank in rate
		if($anivend=="--select--")
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
			$anipimg=$HTTP_POST_FILES['pimg'];
			//upload preview image
			$aniimg=$HTTP_POST_FILES['img'];
			
			//current system date
			$date=date('y-m-d H:i:s');
			
			if($anipimg['name'] <> "" && $aniimg['name'] <> "")
			{
				//convert image files to binary
				$anipimagedata = addslashes(fread(fopen( $anipimg['tmp_name'], "r"), filesize( $anipimg['tmp_name'])));
				$aniimagedata = addslashes(fread(fopen( $aniimg['tmp_name'], "r"), filesize( $aniimg['tmp_name'])));
			
				$aniinsert_qry="insert into Ani_Details (ID,PIMAGE,IMAGE,DISPLAY_NAME,VENDOR_ID,RATE_ID,Date_Time,IMAGE_SIZE) values (".$anicat.",'".$anipimagedata."','".$aniimagedata."','".$anidname."','".$anivend."',".$anirate.",'".$date."','".$aniimg['size']."')";
				$anires=helper::insertData($aniinsert_qry);
						
				if($anires==StdError::$SUCCESS){
					
					$ErrMsg="Animation uploaded succesfully";
				}
				else
				{
					$ErrMsg="Animation upload Failure";
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
$selrate="select SERVICE_NAME,RATE_ID from Wap_Rate where SERVICE_NAME='Animation' or SERVICE_NAME='Premium Animation'";
$resrate=helper::getdata($selrate);

//get the wallpaper category list
$selcal="select ID,CATAGORIES from Ani_Main_Cat ORDER BY CATAGORIES";
$rescal=helper::getdata($selcal);
?>


<form name="anigree" action="<?PHP $PHP_SELF ?>" method="post" enctype="multipart/form-data">
<font color="#FF0000"><?=$ErrMsg?></font>
<fieldset>
	<legend><b>Upload Animated Greeting<b></legend>
	<table>
		<tr>
			<td>Display Name:</td>
			<td><input type="text" name="dname" value="<?=$anidname?>" size="40"></td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<select name="category">
				<option>--select--</option>
				<?PHP foreach($rescal as $valc){?>
				<option value="<?=$valc["ID"]?>" <?PHP if($valc["ID"]==$anicat) {?>selected<?PHP } ?>><?=$valc["CATAGORIES"]?>-<?=$valc["ID"]?></option>
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
				<option value="<?=$valr["RATE_ID"]?>" <?PHP if($valr["RATE_ID"]==$anirate) {?>selected<?PHP } ?>><?=$valr["SERVICE_NAME"]?></option>
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
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$anivend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
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