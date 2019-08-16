<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/gnxcfg/Settings.php';
require_once Conn3;
require_once PortalEngine;

if(isset($_POST[UpData__nodb])){$Actualizar = $HandleData->UpdateVendor($_POST[Vid_nodb]);}

$Record = $HandleData->EditVendor($_GET[idv]);
while($row = mysql_fetch_array($Record)){extract($row);
?>
<style type="text/css">
<!--
.style2 {color: #000000}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #CCCCCC;
	font-weight: bold;
}
a:link {
	text-decoration: underline;
}
a:visited {
	text-decoration: underline;
	color: #FFFFFF;
}
a:hover {
	text-decoration: none;
	color: #006699;
}
a:active {
	text-decoration: underline;
	color: #FFFFFF;
}
body,td,th {
	font-size: x-small;
}
.style3 {font-size: small}
.style5 {font-size: small; font-weight: bold; }
-->
</style>

<table width="99%" border="0" cellpadding="3" cellspacing="3" bordercolor="#336666">
  <tr>
    <td valign="middle"><form id="form1" name="form1" method="post" action="">
      <table width="99%" border="0" align="center" bordercolor="#333333" bgcolor="#0099FF">
        <tr>
          <td colspan="2" align="center" valign="top"><img src="<?php echo $PortalURL ?>/wp-content/uploads/mslv/GreatFireplace.png" alt="" width="176" height="121" align="absmiddle" /></td>
          <td width="31%" valign="top"><div align="center"><span class="style2"><?php echo $VendorName ?></span><br />
            </div>
              <span class="style3"><strong>Product description:</strong> 200 characters maximum.</span><strong><br />
                </strong>
                <textarea name="ProdDesc" cols="54" rows="6"><?php echo $ProdDesc ?></textarea>
              </p></td>
          <td width="37%" align="left" valign="middle"><span class="style1">
&#9556;&#9552;&#9552;&#9552;&#9552;&#9552;&#9658;Owner <span class="style2"><?php echo $OwnerName ?></span><br />
&#9568;&#9552;&#9552;&#9552;&#9552;&#9552;&#9658;Region Name <span class="style2"><?php echo $RegionName ?></span><br />
&#9568;&#9552;&#9552;&#9552;&#9552;&#9552;&#9658;Parcel Name <?php echo $ParcelName  ?><br />
&#9568;&#9552;&#9552;&#9552;&#9552;&#9552;&#9658;<span class="style2">Region Rating <?php 
if($RegionRating == "MATURE"){$RegionRating = "<img src='./Imgs/Parcel_R_M.png'>";}
elseif($RegionRating == "GENERAL"){$RegionRating = "<img src='./Imgs/Parcel_R_G.png'>";} 
elseif($RegionRating == "ADULT"){$RegionRating = "<img src='./Imgs/Parcel_R_A.png'>";} 
echo $RegionRating ?></span><br />
&#9562;&#9552;&#9552;&#9552;&#9552;&#9552;&#9658;<span class="style2">Price <?php echo $ProdPrice ?></span></td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"><div align="center" class="style3"><strong><em>Your product permissions</em></strong></div></td>
          <td valign="top"><strong>Price: $L        <?php $Vprice =number_format($ProdPrice); echo $Vprice ?><br />
          </strong>
            <label>
            <input name="ProdPrice" type="text" id="ProdPrice" value="<?php echo $ProdPrice ?>" size="9" maxlength="9" />
            </label></td>
          <td valign="top"><strong>Marketplace:</strong>
            <?php if($AdvMP != ""){echo "<a href='$AdvMP' target ='_blank'>Marketplace</a>";} ?>
(Optional)<br />
            <input name="AdvMP" type="text" id="AdvMP" value="<?php echo $AdvMP ?>" size="62" /></td>
        </tr>
        <tr>
          <td width="7%" align="left" valign="top"><strong>Mod:            </strong></td>
          <td width="25%" align="left" valign="top"><input name="ProdMod" type="checkbox" id="ProdMod" value="1" />
            <?php if($ProdMod == 1){echo"<img src='Imgs/Ok.jpeg' width='18' height='18' />";} ?></td>
          <td colspan="2" valign="top"><p><span class="style3"><strong>Group Discount:</strong>(Optional) Leave in zero if don't want to apply a group discount. <br />
            Write just an integer that will be the percent you want set as discount for your group afiliates who have activated the group tag. </span><br />
            <input name="GroupDiscount" type="text" id="GroupDiscount" value="<?php echo $GroupDiscount ?>" size="2" maxlength="2" />
            <span class="style3">            Sample: 1 will be 1%, 25 will be 25% | <em><strong>Remember! set your group in the vendor general tab. </strong><strong></strong></em></span><em><strong><br />
            </strong></em><?php if($GroupDiscount > 0){$Gdiscount = ($ProdPrice*$GroupDiscount)/100;
			echo "<span class='style3'><b>[The group discount has been set to L\$$Gdiscount this amount will be refunded at the buyer in the moment of the purchase]</b></span>";}?></p>
            </td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Copy: </strong></td>
          <td align="left" valign="top"><input name="ProdCopy" type="checkbox" id="ProdCopy" value="1" />
		  <?php if($ProdCopy == 1){echo"<img src='Imgs/Ok.jpeg' width='18' height='18' />";} ?></td>
          <td colspan="2" valign="top"><span class="style5">Share earnings:</span><span class="style3"> (Optional) Leave by default both fields if don't want to use this option. <br />
          Partner SL Key: 
            <input name="PartnerKey" type="text" id="PartnerKey" value="<?php echo $PartnerKey ?>" size="45" />
            <br />
          Percent to share: 
          <input name="PartnerPercent" type="text" id="PartnerPercent" value="<?php echo $PartnerPercent ?>" size="9" maxlength="9" />
          <br />
          <?php if($PartnerPercent > 0){$PartnerEarn = ($ProdPrice*$PartnerPercent)/100;
			echo "<span class='style3'><b>[Your partner's earnings has been set to L\$$PartnerEarn this amount will be paid in the moment of the purchase.]</b></span>";}?>
          </span></td>
        </tr>
        <tr>
          <td align="left" valign="top"><strong>Transfer: </strong></td>
          <td align="left" valign="top"><input name="ProdTransfer" type="checkbox" id="ProdTransfer" value="1" />
		  <?php if($ProdTransfer == 1){echo"<img src='Imgs/Ok.jpeg' width='18' height='18' />";} ?></td>
          <td colspan="2" valign="top"><div align="center"> <a href="http://www.slurl.com/secondlife/<?php echo $ProdPoss ?>/?img=http://glavoip.com/lsl/MslVslurl.png&amp;title=<?php echo $titulo ?>&amp;msg=<?php echo $descrive ?>" target="_blank">
            <label>
            <input name="Vid_nodb" type="hidden" id="Vid_nodb" value="<?php echo $Vid ?>" />
            <input name="UpData__nodb" type="submit" id="UpData__nodb" value="Update Vendor" />
            </label>
          </a></div></td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top">&nbsp;</td>
          <td colspan="2" valign="middle"><div align="center"><a href="MyVendors.php">Back to Vendors List</a> </div></td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
<br />
<? }
?>
