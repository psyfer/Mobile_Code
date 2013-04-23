<?PHP
/*************************************************************************
PHP Version: 5.0.4 Xampp
ui name:search criteria
Description: select period and the vendor
Version Date: 1.0 21.09.2006      
Author: Pasan Rajapaksha
**************************************************************************/
?>
<form name="result" action="<?PHP $PHP_SELF?>" method="post">
	<br>
<table>
		<tr>
			<td>Sort By :</td>
			<td>
				<select name="sort">
					<option>--Select--</option>
					<option value="Catagories" <?PHP if($sort=="Catagories") {?>selected<?PHP } ?>>Catagories</option>
					<option value="count(*)" <?PHP if($sort=="count(*)") {?>selected<?PHP } ?>>Count</option>						
					<option value="Display_Name" <?PHP if($sort=="Display_Name") {?>selected<?PHP } ?>>Display Name</option>
					<option value="Vendor" <?PHP if($sort=="Vendor") {?>selected<?PHP } ?>>Vendor</option>
					<option value="Rate" <?PHP if($sort=="Rate") {?>selected<?PHP } ?>>Rate</option>

				</select>
			</td>
			<td><input type="submit" name="search" value="Sort">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--<input type="submit" name="search" value="Export to Excel">--><a href="mysqltoexcel.php?&sql=<?=$strsql?>&id=<?=$_REQUEST["main"]?>" target="_blank">Export to Excel</a></td>
		</tr> 
	</table>
	<br>

	<table border="1">
		<tr>
		<td bgcolor="#FFFF33">Display Name</td>
		<td bgcolor="#FFFF33">Categories</td>
		<td bgcolor="#FFFF33">Count</td>
		<td bgcolor="#FFFF33">Rate</td>
		<td bgcolor="#FFFF33">Vendor Id</td>
<?PHP if($tbl=="Tone_Log"){?>
		<td bgcolor="#FFFF33">Type</td>
<?PHP } ?>
		</tr>
<?PHP  foreach($res as $val)
		{?>	
		<tr>
		<td><?=$val["Display_Name"]?></td>
		<td><?=$val["Catagories"]?></td>
		<td><?=$val["count(*)"]?></td>
		<td><?=$val["Rate"]?></td>
		<td><?=$val["Vendor_Id"]?></td>
<?PHP if($tbl=="Tone_Log"){?>
		<td><?=$val["Type"]?></td>
<?PHP } ?>
		</tr>
<?PHP 	}
?>	
		
	</table>

</form>