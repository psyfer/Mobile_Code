<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:theme uploading
Description: common page to upload Theme
Version Date: 1.0 10.10.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/helper.inc");

if(isset($_REQUEST["vendor"]))$tvend=$_REQUEST["vendor"]; else $tvend="";
if(isset($_REQUEST["category"]))$tcat=$_REQUEST["category"];else $tgcat="";
if(isset($_REQUEST["dname"]))$tdname=$_REQUEST["dname"]; else $tdname="";


//check for blank entries
function checkblank()
{
	global	$tdname,$tcat,$tvend,$ErrMsg;
		// check for blank in display name
		if(trim($tdname) == "" )
		{
			$ErrMsg = "Please enter display name!";
			return false;
			exit;
		}
		//check blank in cetegory
		if($tcat=="--select--")
		{
			$ErrMsg = "Please select a Category!";
			return false;
			exit;
		}
		//check blank in rate
		if($tvend=="--select--")
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
			//mp3 tone file
			$mp3=$HTTP_POST_FILES['mp3'];
			//low poly tone file
			$lpoly=$HTTP_POST_FILES['lpoly'];
			//poly tone file
			$poly=$HTTP_POST_FILES['poly'];
			//true tone file
			$true=$HTTP_POST_FILES['true'];
			
			//current system date
			$date=date('y-m-d H:i:s');
			
			
			//define mp3 date
			if($mp3['size']<>0)
			{
				$mp3_rate_id=2056;
				$mp3_type="audio/mpeg";
				$mp3_size=$mp3['size'];
				$mp3_data=addslashes(fread(fopen( $mp3['tmp_name'], "r"), filesize( $mp3['tmp_name'])));
			}
			else
			{
				$mp3_rate_id=0;
				$mp3_type="";
				$mp3_size=0;
			}
			//defining low poly data
			if($lpoly['size']<>0)
			{
				$lpoly_size=$lpoly['size'];
				$lpoly_data=addslashes(fread(fopen( $lpoly['tmp_name'], "r"), filesize( $lpoly['tmp_name'])));
			}
			else
			{
				$lpoly_size=0;
			}
			//defining poly data
			if($poly['size']<>0)
			{
				$poly_size=$poly['size'];
				$poly_data=addslashes(fread(fopen( $poly['tmp_name'], "r"), filesize( $poly['tmp_name'])));
			}
			else
			{
				$poly_size=0;
			}
			//defining real data
			if($true['size']<>0)
			{
				$true_size=$true['size'];
				$true_data=addslashes(fread(fopen( $true['tmp_name'], "r"), filesize( $true['tmp_name'])));
			}
			else
			{
				$true_size=0;
			}
			
			$selsql="select max(tone_id) from Tone_Details";
			$toneid=helper::getData($selsql);
			$tone_id=$toneid[0]["max(tone_id)"]+1;
			//insert data into db
			$toneqry="insert into Tone_Details values (".$tcat.",'".$mp3_data."',".$mp3_rate_id.",'".$mp3_type."',".$mp3_size.",'".$poly_data."',2031,'audio/midi',".$poly_size.",'".$lpoly_data."',2031,'audio/midi',".$lpoly_size.",0,'".$true_data."',2035,'audio/amr',".$true_size.",'".$tdname."','".$tvend."',0,'".$date."',".$tone_id.")";
			$toneres=helper::insertData($toneqry);
													
			if($toneres==StdError::$SUCCESS){
				$ErrMsg="Tone uploaded succesfully";
			}
			else
			{
				$ErrMsg="Tone upload Failure";
			}
						
		}
	break;
}

//retrieve vendor information
$strsqlv="select * from Vendor ORDER BY VENDOR_ID";
$resv=helper::getdata($strsqlv);

//get the wallpaper category list
$selcal="select ID,CATAGORIES from Tone_Main_Cat ORDER BY CATAGORIES";
$rescal=helper::getdata($selcal);
?>
<form name="tone" action="<?PHP $PHP_SELF ?>" method="post" enctype="multipart/form-data">
<font color="#FF0000"><?=$ErrMsg?></font>
<fieldset>
	<legend><b>Upload Theme<b></legend>
	<table>
		<tr>
			<td>Display Name:</td>
			<td><input type="text" name="dname" value="<?=$tdname?>" size="40"></td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<select name="category">
				<option>--select--</option>
				<?PHP foreach($rescal as $valc){?>
				<option value="<?=$valc["ID"]?>" <?PHP if($valc["ID"]==$tcat) {?>selected<?PHP } ?>><?=$valc["CATAGORIES"]?>-<?=$valc["ID"]?></option>
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
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$tvend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
	</table>
	<fieldset>
		<legend>Tone Info</legend>
		<table>
			<tr>
				<td>Mp3 :</td>
				<td><input type="file" name="mp3"></td>
			</tr>
			<tr>
				<td>Low Poly :</td>
				<td><input type="file" name="lpoly"></td>
			</tr>
			<tr>
				<td>Poly :</td>
				<td><input type="file" name="poly"></td>
			</tr>
			<tr>
				<td>True :</td>
				<td><input type="file" name="true"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="upload" value="Upload"></td>
			</tr>
		</table>
	</fieldset>
</fieldset>

</form>