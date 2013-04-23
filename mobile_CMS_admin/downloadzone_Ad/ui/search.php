<?PHP
/*************************************************************************

PHP Version: 5.0.4 Xampp
ui name:search criteria
Description: select period and the vendor
Version Date: 1.0 21.09.2006      
Author: Pasan Rajapaksha
**************************************************************************/
include_once("../core/helper.inc");

if(isset($_REQUEST["datef"]))$datef=$_REQUEST["datef"]; else $datef="";//date from
if(isset($_REQUEST["datet"]))$datet=$_REQUEST["datet"]; else $datet="";//date to
if(isset($_REQUEST["vendor"]))$vend=$_REQUEST["vendor"];else $vend="";//vendor code
if(isset($_REQUEST["sort"]))$sort=$_REQUEST["sort"];else $sort="";//sort by value
if(isset($_REQUEST["tone"]))$tonet=$_REQUEST["tone"];else $tonet="";//sort by value

if($_REQUEST["main"]==1){ $tbl="Gree_Log"; $tblname="Greeting Log"; }
else if($_REQUEST["main"]==2) { $tbl="Ani_Log"; $tblname="Animation Log"; }
else if($_REQUEST["main"]==3) { $tbl="AniGree_Log"; $tblname="Animated Greeting Log"; }
else if($_REQUEST["main"]==4) { $tbl="Game_Log"; $tblname="Game Log"; }
else if($_REQUEST["main"]==5) { $tbl="Theme_Log"; $tblname="Theme Log"; }
else if($_REQUEST["main"]==6) { $tbl="Tone_Log"; $tblname="Tone Log"; }
else if($_REQUEST["main"]==7) { $tbl="Wall_Log"; $tblname="Wallpaper Log"; }
else echo "unknown error";

//if log is tone the get the additional field 
if($tbl=="Tone_Log")$tone=",Type";else $tone="";

//retrieve vendor information
$strsqlv="select * from vendor";
$resv=helper::getdata($strsqlv);

//if the type is tone
if(isset($_REQUEST["tone"]))
{
	if($_REQUEST["tone"]=="ALL")$qrychng="";
	else $qrychng="and Type='".$_REQUEST['tone']."'";
}

switch($_REQUEST["search"]){
	case "Search" ://search the list of information usinf from date to date and vendor name 
			if($datef <> "" && $datet <> "" )
			{
					if($_REQUEST["vendor"]=="ALL"){//if vendor vaulue set to all
						$strsql="select Display_Name,Catagories,count(*),Rate,Vendor_Id".$tone." from ".$tbl." where date >'".$datef." 00:00:00' and date < '".$datet." 23:59:59' ".$qrychng." group by Display_Name";
					} else { 
						$strsql="select Display_Name,Catagories,count(*),Rate,Vendor_Id".$tone." from ".$tbl." where date >'".$datef." 00:00:00' and date < '".$datet." 23:59:59' ".$qrychng." and vendor_id='".$_REQUEST["vendor"]."' group by Display_Name"; 		
							}
							$sort="Select";
							$res=helper::getdata($strsql);
			}
			else{
				echo "<font color='#ff0000'>Please select a From/To date</font>";
			}
	break;
	case "Sort" :
			if($datef <> "" && $datet <> "" )
			{
					if($_REQUEST["vendor"]=="ALL"){
						$strsql="select Display_Name,Catagories,count(*),Rate,Vendor_Id".$tone." from ".$tbl." where date >'".$datef." 00:00:00' and date < '".$datet." 23:59:59' ".$qrychng." group by Display_Name Order by '".$_REQUEST["sort"]."'";
					} else { 
						$strsql="select Display_Name,Catagories,count(*),Rate,Vendor_Id".$tone." from ".$tbl." where date >'".$datef." 00:00:00' and date < '".$datet." 23:59:59' ".$qrychng." and vendor_id='".$_REQUEST["vendor"]."' group by Display_Name  Order by '".$_REQUEST["sort"]."'"; 		
							}
							$res=helper::getdata($strsql);
			}
			else{
				echo "<font color='#ff0000'>Please select a From/To date</font>";
			}
			
	break;
	
}
?>
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>
<title>Content Management Admin Pannel</title>
<body>
<form name="search" action="<?PHP $PHP_SELF ?>" method="post">
	<!-- Primary Details -->
	<fieldset>
	<legend><b>Search - <?=$tblname?><b></legend>
	<table width="400">
		<tr>
			<td>From:</td>
			<td><input type="Text" name="datef" id="datef" maxlength="25" size="25" value="<?=$datef?>"></td>
			<td valign="middle"><a href="javascript:NewCal('datef','YYYYMMDD')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
			<td>To:</td>
			<td><input type="Text" name="datet" id="datet" maxlength="25" size="25" value="<?=$datet?>"></td>
			<td valign="middle"><a href="javascript:NewCal('datet','YYYYMMDD')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
		</tr>
		<tr>
			<td colspan="2">Vendor:
				<select name="vendor">
				<option>ALL</option>
				<?PHP foreach($resv as $valv){?>
				<option value="<?=$valv["VENDOR_ID"]?>" <?PHP if($valv["VENDOR_ID"]==$vend) {?>selected<?PHP } ?>><?=$valv["VENDOR_ID"]?></option>
				<?PHP } ?>
				</select>
			</td>
		</tr>
<?PHP if($_REQUEST["main"]==6){?>
		<tr>
			<td colspan="2">Tone Type:
				<select name="tone">
					<option>ALL</option>
					<option <?PHP if($tonet=="poly"){?>selected<?PHP } ?>>poly</option>
					<option <?PHP if($tonet=="low_poly"){?>selected<?PHP } ?>>low_poly</option>
					<option <?PHP if($tonet=="true"){?>selected<?PHP } ?>>true</option>
					<option <?PHP if($tonet=="mp3"){?>selected<?PHP } ?>>mp3</option>
				</select>
			</td>
		</tr>
<?PHP	} ?>
		<tr>
		  <td colspan="4"><input type="submit" name="search" value="Search"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>			<td></td>

		</tr>
	</table>
	</fieldset>
	
<?PHP if($res[0]["Display_Name"] <> "")
	{
?>	
	<fieldset>
	<legend><b>Result Set<b></legend>
	<?PHP include_once("result.php"); ?>
	</fieldset>
<?PHP }else {
 			//echo "<font color='#FF0000'>No records found</font>";
			}
 ?>
 
</form>
</body>