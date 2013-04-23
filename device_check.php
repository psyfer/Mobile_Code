<?php
error_reporting(E_ALL & ~E_NOTICE);
$url = $_SERVER ['HTTP_HOST'];

if(!isset($_SERVER["HTTP_MSISDN"])){
    header ("Location: msisdnerror.xhtml");    
    die();
}
 
require_once('/etc/mobiledevices/wurfl/wurfl_config.php');
require_once('/etc/mobiledevices/wurfl/wurfl_class.php');

$myDevice = new wurfl_class($wurfl, $wurfl_agents);
$myDevice->GetDeviceCapabilitiesFromAgent($_SERVER["HTTP_USER_AGENT"]);

#---- Default Vars ----
$xhtmlSite = true;
$ctype='application/xhtml+xml';

$doctype = '<?xml version="1.0"?>';
$doctype .= "\n";
$doctype .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN"
                            "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">';
                            
#---------------------------------------------

if ( $myDevice->GetDeviceCapability('is_wireless_device') ) {
    switch($myDevice->GetDeviceCapability('preferred_markup')){
        case 'wml_1_1':
        case 'wml_1_2':
        case 'wml_1_3':

            /*$ctype='text/vnd.wap.wml';

            $doctype = '<?xml version="1.0" encoding="ISO-8859-15"?>';
            $doctype .= "\n";
            $doctype .= '<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN"
                            "http://www.wapforum.org/DTD/wml_1.1.xml">';*/            
            $xhtmlSite = false;
            header ("Location: http://$url/wml/index.wml");  
            die();            
            break;

        case 'xhtml_basic':
        case 'html_wi_w3_xhtmlbasic':

            $ctype='application/xhtml+xml';

            $doctype = '<?xml version="1.0"?>';
            $doctype .= "\n";
            $doctype .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN"
                            "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">';            
            break;

        case 'xhtml_mobileprofile':
        case 'html_wi_oma_xhtmlmp_1_0':
        case 'xhtml_mp_1.0':

            $ctype='application/vnd.wap.xhtml+xml';

            $doctype = '<?xml version="1.0" encoding="UTF-8"?>';
            $doctype .= "\n";
            $doctype .= '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN"
                            "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">';
            break;

        case 'html_wi_imode_html_1':
        case 'html_wi_imode_html_2':
        case 'html_wi_imode_html_3':
        case 'html_wi_imode_html_4':
        case 'html_wi_imode_html_5':
        case 'html_wi_imode_compact_generic':

            $ctype='text/html';
            $doctype = '';
            break;

        case 'html_web_3_2':
        
            $ctype='text/html';

            $doctype='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">';
            $doctype .= "\n";          
            break;

        case 'html_web_4_0':

            $ctype='text/html';
            $doctype='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                        "http://www.w3.org/TR/html4/loose.dtd">';
            $doctype .= "\n";        
            break;        
    }
}

header("Content-Type: $ctype");    
echo $doctype."\n";
?>
