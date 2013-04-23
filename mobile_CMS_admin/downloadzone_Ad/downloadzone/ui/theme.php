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
if(isset($_REQUEST["rate"]))$trate=$_REQUEST["rate"]; else $trate="";
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
		if($trate=="--select--")
		{
			$ErrMsg = "Please select a wap rate!";
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
			//upload preview image
			$tpimg=$HTTP_POST_FILES['pimg'];
			//array of  theme
			$theme=$HTTP_POST_FILES['theme'];
			//array of  theme type
			$ttype=$_REQUEST['ttype'];
			
			//array of  screen size
			$tscr=$_REQUEST['tscreen'];
			
			//current system date
			$date=date('y-m-d H:i:s');
			
			if($tpimg['name'] <> "")
			{
				//convert image files to binary
				$tpimagedata = addslashes(fread(fopen( $tpimg['tmp_name'], "r"), filesize( $tpimg['tmp_name'])));
				
				for($i=0;$i<6;$i++)
				{
					if($theme['name'][$i]<>"")
					{
						//convert theme files to binary
						$themedata = addslashes(fread(fopen($theme['tmp_name'][$i], "r"), filesize($theme['tmp_name'][$i])));
						$tinsert_qry="insert into Theme_Details (ID,PIMAGE,THEME,DISPLAY_NAME,SCREEN_SIZE,VENDOR_ID,RATE_ID,Date_Time,THEME_TYPE,THEME_SIZE) values (".$tcat.",'".$tpimagedata."','".$themedata."','".$tdname."','".$tscr[$i]."','".$tvend."',".$trate.",'".$date."','".$ttype[$i]."','".$theme['size'][$i]."')";
						$tres=helper::insertData($tinsert_qry);
													
						if($tres==StdError::$SUCCESS){
							$err[$i]="Theme uploaded succesfully";
						}
						else
						{
							$err[$i]="Theme upload Failure";
						}
						
					}
				}
				
			}	
			else $ErrMsg="Please select a image
			 to upload";
		}
	break;
}

//retrieve vendor information
$strsqlv="select * from Vendor ORDER BY VENDOR_ID";
$resv=helper::getdata($strsqlv);

//get the wap rates
$selrate="select SERVICE_NAME,RATE_ID from Wap_Rate where SERVICE_NAME='Theme' or SERVICE_NAME='Premium Theme'";
$resrate=helper::getdata($selrate);

//get the wallpaper category list
$selcal="select ID,CATAGORIES from Theme_Main_Cat ORDER BY CATAGORIES";
$rescal=helper::getdata($selcal);

//get the theme type
$selth="select distinct THEME_TYPE from Theme_Details";
$resth=helper::getdata($selth);

//get the screen size
$selsc="select distinct SCREEN_SIZE from Theme_Details";
$ressc=helper::getdata($selsc);
?>


<form name="anigree" action="<?PHP $PHP_SELF ?>" method="post" enctype="multipart/form-data">
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
			<td>Rate Id :</td>
			<td>
				<select name="rate">
				<option>--select--</option>
				<?PHP foreach($resrate as $valr){?>
				<option value="<?=$valr["RATE_ID"]?>" <?PHP if($valr["RATE_ID"]==$trate) {?>selected<?PHP } ?>><?=$valr["SERVICE_NAME"]?></option>
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
	<legend><b>Theme Information<b></legend>
	<table>
		<tr>
		<td><strong>Preview Image</strong></td>
		<td><input type="file" name="pimg"></td>
		</tr>	
	</table><br>
	<table>
		<tr>
			<td><strong>Theme</strong></td>
			<td><strong>Theme Type</strong></td>
			<td><strong>Screen Size</strong></td>
			<td></td>
		</tr>
<?PHP for($i=0;$i<6;$i++) 
		{
?>
		<tr>			
			<td><input type="file" name="theme[]"></td>
			<td>
				<select name="ttype[]">
				<option>--select--</option>
				<?PHP foreach($resth as $valt){?>
				<option value="<?=$valt["THEME_TYPE"]?>" <?PHP if($valt["THEME_TYPE"]==$ttype) {?>selected<?PHP } ?>><?=$valt["THEME_TYPE"]?></option>
				<?PHP } ?>
				</select>
			</td>
			<td>
				<select name="tscreen[]">
					<option>--select--</option>
					<?PHP foreach($ressc as $valsc){?>
					<option value="<?=$valsc["SCREEN_SIZE"]?>" <?PHP if($valsc["SCREEN_SIZE"]==$ttype) {?>selected<?PHP } ?>><?=$valsc["SCREEN_SIZE"]?></option>
					<?PHP } ?>
				</select>
			</td>
			<td><font color="#CC0000"><?=$err[$i]?></font></td>
		</tr>
<?PHP 	}

?>			<tr>
			<td><input type="submit" name="upload" value="Upload"></td>
		</tr>
	</table>
	</fieldset>
</fieldset>
</form>