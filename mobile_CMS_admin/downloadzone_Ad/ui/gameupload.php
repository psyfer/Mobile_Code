<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:game uploading
Description: common page to upload all the game upload s
Version Date: 1.0 2.09.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/helper.inc");

if(isset($_REQUEST["category"]))$cat=$_REQUEST["category"];else $cat="";
if(isset($_REQUEST["rate"]))$rate=$_REQUEST["rate"]; else $rate="";
if(isset($_REQUEST["vendor"]))$vend=$_REQUEST["vendor"]; else $vend="";
if(isset($_REQUEST["dname"]))$dname=$_REQUEST["dname"]; else $dname="";
if(isset($_REQUEST["desc"])) $desc=$_REQUEST["desc"]; else $desc="";

//check for blank entries
function checkblank()
{
	 global	$dname,$desc,$cat,$vend,$ErrMsg;
		// check for blank in display name
		if(trim($dname) == "" )
		{
			$ErrMsg = "Please enter display name!";
			return false;
			exit;
		}
		//check blank in description
		if(trim($desc) == "" )
		{
			$ErrMsg = "Please enter Description!";
			return false;
			exit;
		}
		//check blank in cetegory
		if($cat=="--select--")
		{
			$ErrMsg = "Please select a Category!";
			return false;
			exit;
		}
		//check blank in rate
		if($rate=="--select--")
		{
			$ErrMsg = "Please select a wap rate!";
			return false;
			exit;
		}
		//check blank in rate
		if($vend=="--select--")
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
			//upload image
			$imgfile=$HTTP_POST_FILES['image'];
			//array of jar files
			$jarfile=$HTTP_POST_FILES['filer'];
			//array of jag files
			$jadfile=$HTTP_POST_FILES['filed'];
			//retrieve the series
			$series=$_REQUEST["series"];
			//print_r($series);
			
			//current system date
			$date=date('y-m-d H:i:s');
					
			if($imgfile['name']<>"")
			{
				$imagedata = addslashes(fread(fopen( $imgfile['tmp_name'], "r"), filesize( $imgfile['tmp_name']))); 
				for($i=0;$i<25;$i++)
				{
					if($jarfile['size'][$i]<>0 && $jadfile['size'][$i]<>0)
					{
						//build insert quary
						$jaddata = addslashes(fread(fopen( $jadfile['tmp_name'][$i], "r"), filesize($jadfile['tmp_name'][$i]))); //convert jad file to binary format
						$jardata = addslashes(fread(fopen( $jarfile['tmp_name'][$i], "r"), filesize($jarfile['tmp_name'][$i]))); //convert the jar file to binary format
						$desc1=addslashes($desc);
						
						$insert_qry="insert into Game_Details (ID,PIMAGE,GAME_JAD,GAME_JAD_SIZE,GAME_JAR,GAME_JAR_SIZE,DESCRIPTION,DISPLAY_NAME,SERIES,VENDOR_ID,RATE_ID,Date_Time) values (".$cat.",'".$imagedata."','".$jaddata."',".$jadfile['size'][$i].",'".$jardata."',".$jarfile['size'][$i].",'".$desc1."','".$dname."','".$series[$i]."','".$vend."',".$rate.",'".$date."')";
						$res=helper::insertData($insert_qry);
						
						if($res==StdError::$SUCCESS){
							$err[$i]="Game uploaded succesfully";
						}
						else
						{
							$err[$i]="Game upload Failure";
						}
					}
				
				}
			}	
			else
			{
				$ErrMsg="Please select an image to upload";
			}

		}
			
	break;
}

//retrieve vendor information
$strsqlv="select * from Vendor";
$resv=helper::getdata($strsqlv);

//get the game category list
$selcal="select ID,CATAGORIES from Game_Main_Cat";
$rescal=helper::getdata($selcal);

//get the wap rates
$selrate="select SERVICE_NAME,RATE_ID from Wap_Rate where SERVICE_NAME='Java Game' or SERVICE_NAME='Premium Java Game'";
$resrate=helper::getdata($selrate);

//get the series of phones for games
$selseries="select distinct gseries from Mobile_Group order by model";
$resseries=helper::getdata($selseries);
?>

<form name="game" method="post" action="<?PHP $PHP_SELF ?>" enctype="multipart/form-data">
<font color="#FF0000"><?=$ErrMsg?></font>
<fieldset>
	<legend><b>Upload Game<b></legend>
	<fieldset>
	<legend><b>Common Info<b></legend>
	<table>
		<tr>
			<td>Display Name :</td>
			<td><input type="text" name="dname" value="<?=$dname?>" size="40"></td>
		</tr>
		<tr>
			<td valign="top">Description :</td>
			<td><textarea name="desc" cols="40" rows="2"><?=stripslashes($desc)?></textarea></td>
		</tr>
		<tr>
			<td>Category :</td>
			<td>
				<select name="category">
				<option>--select--</option>
				<?PHP foreach($rescal as $valc){?>
				<option value="<?=$valc["ID"]?>" <?PHP if($valc["ID"]==$cat) {?>selected<?PHP } ?>><?=$valc["CATAGORIES"]?>-<?=$valc["ID"]?></option>
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
				<option value="<?=$valr["RATE_ID"]?>" <?PHP if($valr["RATE_ID"]==$rate) {?>selected<?PHP } ?>><?=$valr["SERVICE_NAME"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Vendor :</td>
			<td>
				<select name="vendor">
				<option>--select--</option>
				<?PHP foreach($resv as $valv){?>
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$vend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
	</table>
	</fieldset>
	<fieldset>
	<legend><b>Upload-Files<b></legend>
	<table>
		<tr>
			<td>Game image :</td>
			<td><input type="file" name="image"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
			<table>
					<tr>
						<td></td>
						<td><strong>JAR-File</strong></td>
						<td><strong>JAD-File</strong></td>
						<td><strong>Series</strong></td>
						<td></td>
					</tr>
<?PHP for($i=1;$i<=25;$i++){ ?>
					<tr>
						<td><?=$i?></td>
						<td><input type="file" name="filer[]"></td>
						<td><input type="file" name="filed[]"></td>
						<td>
							<select name="series[]">
							<option>--select--</option>
							<?PHP foreach($resseries as $vals){?>
								<option value="<?=$vals["gseries"]?>"><?=$vals["gseries"]?></option>
							<?PHP } ?>
							</select>
						</td>
						<td><font color="#FF0033"><?=$err[$i-1]?></font></td>
					</tr>
<?PHP					} ?>
					
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="upload" value="Upload">
			</td>
		 </tr>
	</table>
	</fieldset>
</fieldset>
</form>

