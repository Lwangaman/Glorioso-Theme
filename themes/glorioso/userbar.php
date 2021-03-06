<?php
global $_FN,$_GFC,$_FB,$_THEME_CFG;
$logouturl = $_FN["self"]."?mod=login&amp;op=logout";
$loginurl = $_FN["self"]."?mod=login";
$urlregistrazione = $_FN["self"]."?mod=login&amp;op=vis_reg";
?>
<div style="clear:both;"></div>
<div id="toolbar-show"  class="fg-button fg-button-icon-left ui-corner-bottom" style="display:none;position:absolute;right:5px;top:0px;border:2px groove White;border-top:none;z-index:999999;"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span>SHOW</div>
<!-- TOOLBAR WRAPPER -->
<div id="toolbar-wrapper">
<!-- PAGE WIDE TOOLBAR -->
<div id="top_toolbar" class="ui-widget-header ui-corner-all ui-helper-clearfix" style="margin:3px 0px;">
<!-- DIV UTENTE (LEFT DIV) -->
<div style="float:left;padding:5px;margin:2px;width:39%;border:1px inset White;">
	<!-- USER WELCOME -->
	<?php	
    /*********************** LOGGED IN USER ***********************/
		if ($_FN ['user'] !== "") { 
		/* Verifico a quali gruppi l'utente appartiene */
		$fndb = new XMLDatabase("fndatabase","misc");
		$query = "SELECT group FROM users WHERE username = '".$_FN['user']."'";
		$groups = $fndb->Query($query);
    /* SE E' INCLUSO IL SISTEMA DI MESSAGGI PRIVATI, VERIFICO PRESENZA DI MESSAGGI PRIVATI */
      // imposto il nome della sezione
      $MP_section=find_section("FlatMP");
      if($MP_section!=''){     
        // importo i file necessari
        include_once("sections/$MP_section/mp_functions.php");
        // verifica l'esistenza della cartella mailboxes altrimenti la crea
        if (!file_exists($_FN['datadir']."/mailboxes"))
        	mkdir($_FN['datadir']."/mailboxes");
        // verifica l'esistenza della cartella dell'utente altrimenti la crea
        if (!file_exists($_FN['datadir']."/mailboxes/".$_FN['user']))
        	mp_first($_FN['user'],$_FN['admin']);
      }
		/* DO IL BENVENUTO */
		echo "<div style="float:left;">"._BENVENUTO."<span id=\"span_username\"> ".$_FN['user']." </span>!</div>";
    // visualizzo i messaggi privati non letti	
    if($MP_section!=''){     
      if((user_can_view_section($MP_section))) {
      		switch ( mp_count($_FN['user'],$_FN['datadir']) ) {
            case 0:
              $mp_imgsrc = "images/mp/mail.png";
              break;
            case 1:
              $mp_imgsrc = "images/mp/mail1.png";
              break;
            case 2:
              $mp_imgsrc = "images/mp/mail2.png";
              break;
            case 3:
              $mp_imgsrc = "images/mp/mail3.png";
              break;
            case 4:
              $mp_imgsrc = "images/mp/mail4.png";
              break;
            case 5:
              $mp_imgsrc = "images/mp/mail5.png";
              break;
            case 6:
              $mp_imgsrc = "images/mp/mail6.png";
              break;
            case 7:
              $mp_imgsrc = "images/mp/mail7.png";
              break;
            case 8:                       
              $mp_imgsrc = "images/mp/mail8.png";
              break;
            case 9:
              $mp_imgsrc = "images/mp/mail9.png";
              break;
            case 10:
              $mp_imgsrc = "images/mp/mail10.png";
              break;
            case (mp_count($_FN['user'],$_FN['datadir']) > 10):
              $mp_imgsrc = "images/mp/mail10+.png";   
          }
      		echo "<div style=\"float:left;margin-left:15px;\"><a href=\"index.php?mod=".$MP_section."\"><img id=\"MPimg\" class=\"jqtooltip-dx\" style=\"width:32px;\" src=\"".$mp_imgsrc."\" title=\""._MP." ".mp_count($_FN['user'],$_FN['datadir'])." "._NOREADMP."\" /></a></div>";
          }
      else
      		echo _LOGINMP;
    } // END MP
?>
	<!-- LOGIN / LOGOUT, PROFILE, REGISTRATION BUTTONSET -->
	<div id="userdetails" style="float:right;" class="fg-buttonset fg-buttonset-single ui-helper-clearfix">
	<?php
      // profile button
			echo "<div id=\"userprofile\" class=\"jqtooltip-dx fg-button fg-button-icon-left ui-state-default ui-priority-primary ui-corner-left\" onclick=\"location.href='{$_FN['self']}?mod=login&amp;opmod=profile'\" title=\""._VIEW_USERPROFILE."\">";      
      echo "<span class=\"ui-icon ui-icon-person\"></span></div>";
	    //if logged in with facebook connect, show facebook logout (which also logs out of the site)
			if ($_THEME_CFG['use_fb']==1&&$_FB['me']){ 
	?>
				<span id="fb_logout" class="jqtooltip-dx fg-button ui-state-default ui-priority-primary ui-corner-right" title="<?php echo _FB_LOGOUT ?>" >
					<img id="fb_logout_image" src="images/social/fb_logout.png" alt="Connect" />
				</span>				
	<?php }
	    elseif ($_THEME_CFG['use_gfc']==1&&$_GFC['session']){
  ?>
				<span id="gfc_logout" class="jqtooltip-dx fg-button ui-state-default ui-priority-primary ui-corner-right" title="<?php echo _GFC_LOGOUT ?>" >
					<img src="images/social/google_logo.png" alt="Connect" width=16 />
					Logout
				</span>
  <?php }
      elseif ($_THEME_CFG['use_messlive']==1&&$_MESSLIVE['session']){
  ?>
        <span id="messlive_logout" class="jqtooltip-dx fg-button ui-state-default ui-priority-primary ui-corner-right" title="<?php echo _MESSLIVE_LOGOUT ?>" >
          <wl:signin signed-in-text="Sign Out" signed-out-text="Sign In" on-signin="signInCompleted" on-signout="signOutCompleted" />
        </span>
     <?php }
      //else if user is only logged into the site and not to facebook connect, show flatnux logout
      else {  ?>
		    	<div class="jqtooltip-dx fg-button fg-button-icon-left ui-state-default ui-state-active ui-priority-primary ui-corner-right" title="<?php echo _FN_LOGOUT ?>"><span class="ui-icon ui-icon-power"></span><a href="<?php echo $logouturl ?>"><?php echo _LOGOUT ?></a></div>
	<?php } ?>
	</div><!-- END USERDETAILS BUTTONSET -->
<?php
    echo "<div style=\"clear:both;\">";
    //-disegno la barra del livello ->
		$level = getlevel($_FN['user']);
			echo "<div id=\"USERPAN_LEVEL\" class=\"jqtooltip-dx\" title=\"".fn_i18n("_LEVEL") . " ". $level ."&lt;br /&gt;Fai parte dei seguenti gruppi: ". $groups[0]['group'] ."\" style=\"float:left;text-align:center;margin:.2em 15px;vertical-align:middle;border:ridge 1px White;padding:0px 3px 3px 3px;\">";
			for ( $i = 0;$i < $level;$i++  )
				echo "<img  src=\"{$_FN['siteurl']}images/useronline/level_y.gif\" alt=\"level\" style=\"vertical-align:middle;\" />";
			for (;$i < 10;$i++  )
				echo "<img  src=\"{$_FN['siteurl']}images/useronline/level_n.gif\" alt=\"level\" style=\"vertical-align:middle;\" />";
			print "</div>";
		//-disegno la barra del livello -<
    echo "</div>";
}
/*********************** END LOGGED IN USER **********************/
/*********************** START NOT LOGGED IN *********************/
	else { 
		echo "<div style=\"float:left;\">"._BENVENUTO."<span id=\"span_username\"> "._GUEST." </span>!</div>";
  ?>
   <div id="userlogin" class="ui-corner-all ui-state-default">
    <div id="login-span-wrapper">
      <span id="login-span">LOGIN</span>
      <?php if ($_THEME_CFG['use_fb']==1){ ?>
      <img src="images/social/logo-facebook-small.png" style="width:16px;margin-left:10px;" title="<?php echo _FB_LOGIN ?>" />
      <?php }
            if ($_THEME_CFG['use_gfc']==1){ ?>
      <img src="images/social/google_logo.png" style="width:16px;margin-left:10px;" title="<?php echo _GFC_LOGIN ?>" />
      <?php } 
            if ($_THEME_CFG['use_messlive']==1){ ?>
      <img src="images/social/windowsLiveLogo.png" style="width:16px;margin-left:10px;" title="<?php echo _MESSLIVE_LOGIN ?>" />
      <?php }
      ?>
      <span style="float:right;" class="ui-icon ui-icon-carat-1-s"></span>
    </div>
    <div id="dropdown-shadow" class="ui-widget-shadow"></div>
    <div id="userlogin-dropdown" class="ui-corner-bottom ui-state-default">
  	  <!-- site login -->
      <div id="flatnuxlogin" class="jqtooltip-dx ui-corner-all" title="<?php echo _FN_LOGIN ?>">        
        <form action="?mod=login" method="post">
          <input type="hidden" name="op" value="login" />
          <input type="hidden" name="from" value="<?php	echo $_FN['mod']?>" /> 
          <fieldset>
            <legend class="ui-corner-all" style="border:1px inset Orange;">
              <span class="ui-icon ui-icon-person" style="float:left;"></span>
              <?php	echo fn_i18n("_LOGIN")?>
            </legend>
            <label for="username"><?php	echo fn_i18n("_NOMEUTENTE")?>: </label><input type="text" name="nome" id="username" /><br />
            <label for="password"><?php	echo fn_i18n("_PASSWORD")?>: </label><input type="password" name="logpassword" id="password" /><br />
            <?php
            	if ( $_FN['remember_login'] == 1 )
            	{
            		echo "\n<div style=\"margin:1em;\"><label for=\"rememberlogin\">" . fn_i18n("_REMEMBERLOGIN") . "</label>";
            		echo "\n<input type=\"checkbox\" name=\"rememberlogin\" id=\"rememberlogin\" /><br />";
            		echo "\n</div>";
            	}
            	else
            		echo "<br />";
            ?>
            <button type="submit"><?php	echo fn_i18n("_LOGIN")?></button>
            <!--  Registration button  --> 
        	  <?php if ( $_FN['enable_registration'] == 1 ) {  ?>
        		<button type="button" id="flatnuxregistration" style="float:right;" class="jqtooltip-dx" title="<?php echo _FN_REGISTER ?>" onclick="location.href='<?php echo $urlregistrazione ?>'">
              <span class="ui-icon ui-icon-star" style="float:left;"></span>
              <?php echo fn_i18n("_REGORA"); ?>
            </button>
        	  <?php } ?>
          </fieldset>
        </form>
      </div>
 		  <div style="text-align:center;margin:10px 0px;" class="ui-widget-header"> - OPPURE - </div>
      <div id="opensociallogin" class="ui-corner-all">
      <?php if ($_THEME_CFG['use_fb']==1){ ?>
      <!-- facebook login button -->		
  		  <div id="facebooklogin" class="jqtooltip-dx ui-corner-all" title="<?php echo _FB_LOGIN ?>">
  		    <img src="images/social/fb_login-button.png" alt="Facebook Login" /> 
  		  </div>    
      <?php } ?>
  		<?php if ($_THEME_CFG['use_gfc']==1){ ?>
      <!-- google friend connect button-->
        <div id="gfc-button" class="jqtooltip-dx ui-widget-header ui-corner-all" title="<?php echo _GFC_LOGIN ?>"><?php echo _GFC_LOGIN ?> - requestSignIn method</div>
        <div id="gfc-button2" class="jqtooltip-dx" title="<?php echo _GFC_LOGIN ?>"></div>
      <?php } ?>
      <?php if ($_THEME_CFG['use_messlive']==1){ ?>
      <!-- messenger live login button -->    
        <div id="messlivelogin" class="jqtooltip-dx ui-corner-all" title="<?php echo _MESSLIVE_LOGIN ?>">
          <wl:signin signed-in-text="Sign Out" signed-out-text="Sign In" on-signin="signInCompleted" on-signout="signOutCompleted"></wl:signin> 
        </div>    
      <?php } ?>
      </div><!-- END OPENSOCIAL LOGIN -->
    </div> <!-- END USERLOGIN-DROPDOWN -->
  </div> <!-- END USERLOGIN -->
<?php
    } 
/*********************** END NOT LOGGED IN ***********************/
?>
</div>
<!-- END DIV UTENTE (LEFT DIV) -->
<!-- START DIV UTENTE (RIGHT DIV) -->
<div style="width:59%;float:right;">
<!-- TOP DIV: SEARCH - ADMIN - LANG - THEME -->
<div style="margin: 5px 0px 0px 5px;" class="ui-helper-clearfix">
	<!-- SEARCH FIELD -->
		<button id="CTRLPAN_SEARCH" style="float:left;" class="jqtooltip-dx" onclick="location.href='<?php echo $_FN['self']?>?mod=search'" title="<?php echo _USERBAR_SEARCH ?>">
      <?php echo _CERCA;?>
    </button>
	<!-- USERSTUFF BUTTONSET -->
	<div id="userbuttonset" style="float:left;margin-left:20px;">
	<?php if ($_FN ['user'] != "") { // if already logged in
		//CONTROLCENTER
	    if (isadmin ()) {	?>
			<input type="checkbox" id="CTRLPAN_ADMIN" /><label for="CTRLPAN_ADMIN" class="jqtooltip-dx" title="<?php echo _MANAGEFLATNUKE;?>">CtlPan</label>
	    <input type="checkbox" id="THEME_CFG" /><label for="THEME_CFG" class="jqtooltip-dx" title="<?php echo _USERBAR_THEMECFG ?>">Cfg Theme</label>
      <?php }
		//FILEMANAGER
		if ( user_can_edit_section($_FN['vmod']) )
		{ ?>
			<input type="checkbox" id="CTRLPAN_FILEMNGR" /><label for="CTRLPAN_FILEMNGR" class="jqtooltip-dx" title="<?php echo strtoupper(fn_i18n('_MANAGEFILE')); ?> :&lt;br /&gt; <?php echo fn_i18n('_FILESINSECTION'); ?>">FileMngr</label>
	<?php
    }
		//ADMIN ON/OFF
		if ( isadmin() || can_modify($_FN['user'],"sections/{$_FN['vmod']}") ){
			echo ( $_FN['fneditmode'] != 0 ) ? "<input type=\"checkbox\" id=\"glorioso_adminonoff\" name=\"glorioso_adminonoff\" rel=\"glorioso_adminon\" checked /><label for=\"glorioso_adminonoff\" class=\"jqtooltip-dx\" title=\"" . fn_i18n("_EDITMODEOFF"). "\">OFF</label>" : "<input type=\"checkbox\" id=\"glorioso_adminonoff\" name=\"glorioso_adminonoff\" rel=\"glorioso_adminoff\" /><label for=\"glorioso_adminonoff\" class=\"jqtooltip-dx\" title=\"". fn_i18n("_EDITMODEON") ."\">ON</label>";
			}		
		}
		// whether logged in or not:
		// nnn
		?>
	</div>
  <!-- END USERSTUFF BUTTONSET -->
	<!-- SHOW/HIDE, LANG and THEME right floated -->
	<div id="toolbar-hide" style="float:right;" class="fg-button fg-button-icon-left ui-corner-top"><span class="ui-icon ui-icon-arrowthickstop-1-n"></span>HIDE</div>
	<div class="jqtooltip-dx" title="<?php echo _USERBAR_LANGS ?>" style="float:right;"><?php getlangs(); ?></div>
	<div id="gloriosothemeswitcher" class="jqtooltip-dx" title="<?php echo _USERBAR_THEMESWITCHER ?>"></div>
</div>
<!-- END TOP DIV: SEARCH - ADMIN - LANG - THEME -->
<!-- START BOTTOM RIGHT DIV: FACEBOOK AND CLOCK -->
<div style="border-top:inset 1px red;margin: 5px 0px 0px 5px;" class="ui-helper-clearfix">
  <!-- FACEBOOK LIKE AND FACEBOOK BOOKMARK ON THE LINE BELOW, TO THE LEFT -->
<?php if ($_THEME_CFG['use_fb']==1){ ?>
  	<div id="fb_bookmark_btn" class="jqtooltip-dx" style="float:left;margin-right:5px;" title="<?php echo _USERBAR_BOOKMARK ?>"><fb:bookmark></fb:bookmark></div>
    <div id="fb_like_btn" class="jqtooltip-dx" style="float:left;margin-right:5px;" title="<?php echo _USERBAR_LIKE ?>"><fb:like layout="button_count" colorscheme="light" href="<?php echo $_FN['siteurl'] ?>"></fb:like></div>
<?php } ?>
  <!-- CLOCK -->
  <div id="clockwrapper">
    <img id="gloriosocal" src="images/pagetop/calendario.gif" class="jqtooltip-dx" alt="Calendario" title="<?php echo _USERBAR_CAL ?>" />
    <!-- Calendar feed as defined in config.php -->
    <input type="hidden" id="gcal-feed" value="<?php echo $_THEME_CFG['gcal_feed']?>" />
    <?php include("fullcalendar.php"); ?>
    <!-- PHP timestamp -->
    <input type="hidden" id="current_timestamp" value="<?php echo time(); ?>" />
    <input type="hidden" id="current_langset" value="<?php echo $_FN['lang']; ?>" />
    <div id="clock"></div>
  </div>
  <!-- END CLOCK -->



</div>
<!-- END BOTTOM RIGHT DIV ON USERBAR: FACEBOOK AND CLOCK -->

</div>
<!-- END DIV UTENTE (RIGHT DIV) -->
</div><!-- END TOOLBAR -->

</div><!-- END TOOLBAR WRAPPER -->