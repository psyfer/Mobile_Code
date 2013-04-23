<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:wallpaper uploading
Description: common page to upload all the wallpapaer upload s
Version Date: 1.0 09.10.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/helper.inc");

if(isset($_REQUEST["vendor"]))$wvend=$_REQUEST["vendor"]; else $wvend="";
if(isset($_REQUEST["rate"]))$wrate=$_REQUEST["rate"]; else $wrate="";
if(isset($_REQUEST["category"]))$wcat=$_REQUEST["category"];else $wcat="";
if(isset($_REQUEST["dname"]))$wdname=$_REQUEST["dname"]; else $wdname="";

//check for blank entries
function checkblank()
{
	global	$wdname,$wcat,$wvend,$ErrMsg;
		// check for blank in display name
		if(trim($wdname) == "" )
		{
			$ErrMsg = "Please enter display name!";
			return false;
			exit;
		}
		//check blank in cetegory
		if($wcat=="--select--")
		{
			$ErrMsg = "Please select a Category!";
			return false;
			exit;
		}
		//check blank in rate
		if($wrate=="--select--")
		{
			$ErrMsg = "Please select a wap rate!";
			return false;
			exit;
		}
		//check blank in rate
		if($wvend=="--select--")
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
			$pimg=$HTTP_POST_FILES['pimg'];
			//upload preview image
			$img=$HTTP_POST_FILES['img'];
			
			//current system date
			$date=date('y-m-d H:i:s');
			
			if($pimg['name'] <> "" && $img['name'] <> "")
			{
				//convert image files to binary
				$pimagedata = addslashes(fread(fopen( $pimg['tmp_name'], "r"), filesize( $pimg['tmp_name'])));
				$imagedata = addslashes(fread(fopen( $img['tmp_name'], "r"), filesize( $img['tmp_name'])));
			
				$winsert_qry="insert into Wall_Details (ID,PIMAGE,IMAGE,DISPLAY_NAME,VENDOR_ID,RATE_ID,Date_Time,IMAGE_SIZE) values (".$wcat.",'".$pimagedata."','".$imagedata."','".$wdname."','".$wvend."',".$wrate.",'".$date."','".$img['size']."')";
				$wres=helper::insertData($winsert_qry);
						
				if($wres==StdError::$SUCCESS){
					
					$ErrMsg="Wallpaper uploaded succesfully";
				}
				else
				{
					$ErrMsg="Wallpaper upload Failure";
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
$selrate="select SERVICE_NAME,RATE_ID from Wap_Rate where SERVICE_NAME='Wallpaper' or SERVICE_NAME='Premium Wallpaper'";
$resrate=helper::getdata($selrate);

//get the wallpaper category list
$selcal="select ID,CATAGORIES from Wall_Main_Cat ORDER BY CATAGORIES";
$rescal=helper::getdata($selcal);
?>


<form name="wall" action="<?PHP $PHP_SELF ?>" method="post" enctype="multipart/form-data">
<font color="#FF0000"><?=$ErrMsg?></font>
<fieldset>
	<legend><b>Upload Wallpaper<b></legend>
	<table>
		<tr>
			<td>Display Name:</td>
			<td><input type="text" name="dname" value="<?=$wdname?>" size="40"></td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<select name="category">
				<option>--select--</option>
				<?PHP foreach($rescal as $valc){?>
				<option value="<?=$valc["ID"]?>" <?PHP if($valc["ID"]==$wcat) {?>selected<?PHP } ?>><?=$valc["CATAGORIES"]?>-<?=$valc["ID"]?></option>
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
				<option value="<?=$valr["RATE_ID"]?>" <?PHP if($valr["RATE_ID"]==$wrate) {?>selected<?PHP } ?>><?=$valr["SERVICE_NAME"]?></option>
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
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$wvend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
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