<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:fulltrachk uploading
Description: common page to upload full tracks to 3G page
Version Date: 1.0 11.10.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/3Ghelper.inc");

if(isset($_REQUEST["vendor"]))$ftvend=$_REQUEST["vendor"]; else $ftvend="";
if(isset($_REQUEST["rate"]))$ftrate=$_REQUEST["rate"]; else $ftrate="";
if(isset($_REQUEST["category"]))$ftcat=$_REQUEST["category"];else $ftcat="";
if(isset($_REQUEST["fname"]))$ftdname=$_REQUEST["fname"]; else $ftdname="";
if(isset($_REQUEST["mime"]))$ftmime=$_REQUEST["mime"]; else $ftmime="";
if(isset($_REQUEST["alname"]))$alname=$_REQUEST["alname"]; else $alname="";
if(isset($_REQUEST["arname"]))$arname=$_REQUEST["arname"]; else $arname="";
if(isset($_REQUEST["fname"]))$fname=$_REQUEST["fname"]; else $fname="";



//check for blank entries
function checkblank()
{
	global	$ftdname,$ftcat,$ftvend,$ErrMsg,$alname,$arname,$fname;
		// check for blank in display name
		if(trim($ftdname) == "" )
		{
			$ErrMsg = "Please enter display name!";
			return false;
			exit;
		}
		//check blank in cetegory
		if($ftcat=="--select--")
		{
			$ErrMsg = "Please select a Category!";
			return false;
			exit;
		}
		//check blank in rate
		if($ftrate=="--select--")
		{
			$ErrMsg = "Please select a wap rate!";
			return false;
			exit;
		}
		//check blank in rate
		if($ftvend=="--select--")
		{
			$ErrMsg = "Please select a vendor!";
			return false;
			exit;
		}
		//check blank in mime
		if($ftmime=="--select--")
		{
			$ErrMsg = "Please select a Mime!";
			return false;
			exit;
		}
		// check for blank in album name
		if(trim($alname) == "" )
		{
			$ErrMsg = "Please enter Album name!";
			return false;
			exit;
		}
		// check for blank in album name
		if(trim($arname) == "" )
		{
			$ErrMsg = "Please enter Artist name!";
			return false;
			exit;
		}
		// check for blank in file name
		if(trim($fname) == "" )
		{
			$ErrMsg = "Please enter File name!";
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
			//upload track
			$ftrack=$HTTP_POST_FILES['ftrack'];
			
			//current system date
			$date=date('y-m-d H:i:s');
			
			if($ftrack['name'] <> "")
			{
				//convert image files to binary
				$ftrackdata = addslashes(fread(fopen( $ftrack['tmp_name'], "r"), filesize( $ftrack['tmp_name'])));
				
				echo $ftinsert_qry="insert into 3g.Fulltrack_Details (Mime,Tone,File_Name,File_Size,Display_Name,Rate_Id,Vendor_Id,Upload_Date,Cat_Id,Album_Name,Artist_Name) values ('".$ftmime."','".$ftrackdata."','".$fname."',".$ftrack['size'].",'".$ftdname."',".$ftrate.",'".$ftvend."','".$date."',".$ftcat.",'".$alname."','".$arname."')";
				$ftres=threehelper::insertData($ftinsert_qry);
						
				if($ftres==StdError::$SUCCESS){
					
					$ErrMsg="Full Track uploaded succesfully";
				}
				else
				{
					$ErrMsg="Full Track upload Failure";
				}
			}
			else $ErrMsg="Please select a track to upload";
			
		}
	break;
}

//retrieve vendor information
$strsqlv="select * from DownloadZone.Vendor ORDER BY VENDOR_ID";
$resv=threehelper::getdata($strsqlv);

//get the wap rates
$selrate="select SERVICE_NAME,RATE_ID from DownloadZone.Wap_Rate where SERVICE_NAME='Full Track' or SERVICE_NAME='Premium Full Track'";
$resrate=threehelper::getdata($selrate);

//get the wallpaper category list
$selcal="select Cat_Id,Catagory from 3g.Catagory ORDER BY Catagory";
$rescal=threehelper::getdata($selcal);

?>


<form name="ftrack" action="<?PHP $PHP_SELF ?>" method="post" enctype="multipart/form-data">
<font color="#FF0000"><?=$ErrMsg?></font>
<fieldset>
	<legend><b>Upload Full Tracks<b></legend>
	<table>
		<tr>
			<td>Display Name:</td>
			<td><input type="text" name="dname" value="<?=$ftdname?>" size="40"></td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<select name="category">
				<option>--select--</option>
				<?PHP foreach($rescal as $valc){?>
				<option value="<?=$valc["Cat_Id"]?>" <?PHP if($valc["Cat_Id"]==$ftcat) {?>selected<?PHP } ?>><?=$valc["Catagory"]?>-<?=$valc["Cat_Id"]?></option>
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
				<option value="<?=$valr["RATE_ID"]?>" <?PHP if($valr["RATE_ID"]==$ftrate) {?>selected<?PHP } ?>><?=$valr["SERVICE_NAME"]?></option>
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
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$ftvend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
		</table>
		<fieldset>
		<legend><b>Track Info</b></legend>
		<table>
		<tr>
			<td>Mime</td>
			<td>
				<select name="mime">
					<option>--select--</option>
					<option <?PHP if($ftmime=="audio/mp3") {?>selected<?PHP } ?>>audio/mp3</option>
					<option <?PHP if($ftmime=="application/vnd.oma.drm.message") {?>selected<?PHP } ?>>application/vnd.oma.drm.message</option>
				</select>
			</td>	
		</tr>
		<tr>
			<td>Full Track:</td>
			<td><input type="file" name="ftrack"></td>
		</tr>
		<tr>
			<td>File Name:</td>
			<td><input type="text" name="fname" size="40" value="<?=$fname?>"></td>
		</tr>
		<tr>
			<td>Album Name:</td>
			<td><input type="text" name="alname" size="40" value="<?=$alname?>"></td>
		</tr>
		<tr>
			<td>Artist Name:</td>
			<td><input type="text" name="arname" size="40" value="<?=$arname?>"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="upload" value="Upload"></td>
		</tr>
	</table>
	</fieldset>
</fieldset>
</form>
