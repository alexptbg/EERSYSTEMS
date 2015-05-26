<?php
defined('start') or die('Direct access not allowed.');
$_x = $settings['salt'];
$_s = strtotime(decrypt($settings['hash'],$_x));
$_e = strtotime(decrypt($settings['code'],$_x));
$_k = decrypt($settings['lkey'],$_x);
$_n = date('Y-m-d');
$_n = strtotime($_n);
$_d = constant('HOST');
$_c = get_domain($_d);
$_t = date('Y-m-d', $_e);
if ($installed>$_s) {
	$_z = date('Y-m-d', $installed);
    $end = date('Y-m-d', strtotime("$_z +30 days"));
	$_ex = strtotime($end);
    $now = strtotime(date('Y-m-d'));
    $datediff = $_ex - $now;
    $days = floor($datediff/(60*60*24));
	$stop = strtotime($end);
	$_z = date('Y-m-d', $end);
	if ($_c != $_k) {
	    if (($days<30) && ($days>0)) {
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
				<tbody>
			      <tr>                                    
                      <td  colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad81').":
                      <span class=\"text-error\"> ".get_lang($lang, 'ad97')."</span></td>                                   
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      ".get_lang($lang, 'ad95')." <strong>".$days." </strong>".get_lang($lang, 'ad96')."</span></td>
                  </tr></tbody></table>";
	    } else {
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
				<tbody>
			      <tr>                                    
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad81').":
                      <span class=\"text-error\"> ".get_lang($lang, 'ad93')."</span></td>                                   
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      ".get_lang($lang, 'ad91')." <strong>".$end." </strong></span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      ".get_lang($lang, 'ad92')."</span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					       <h4><a target=\"_blank\" href=\"admin/admin.php?lang=".$lang."\">".get_lang($lang, 'inter61')."</a></h4></span></td>
                  </tr>
				  </tbody></table>"; die;
	    }
	}
} else {
    if ($_c == $_k) {
        if (($_n>$_s) and ($_n<$_e)) {
            //do nothing
	    } 
		else {
			$_z = date('Y-m-d', $installed);
	        $now = strtotime(date('Y-m-d'));
			$_i = strtotime(date('Y-m-d',$installed));
	        $datediff = $now - $_i;
            $days = floor($datediff/(60*60*24));
            $stop = date('Y-m-d', strtotime("$_z +30 days") );
			if (($days<30) && ($days>0)) {
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
				<tbody>
			      <tr>                                  
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad81').":
                      <span class=\"text-error\"> ".get_lang($lang, 'ad86')."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad87').":
                      <span class=\"text-error\"> ".$_z."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad88').":
					  <span class=\"text-error\"> ".$days."<span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      EERS ".get_lang($lang, 'ad89')." <strong>".$stop."</strong><span></td>
                  </tr>
				  </tbody></table>";
			} else {
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
				<tbody>
			      <tr>                                  
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad81').":
                      <span class=\"text-error\"> ".get_lang($lang, 'ad86')."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad87').":
                      <span class=\"text-error\"> ".$_z."<span></td>                                   
                  </tr>
                  <tr>                                    
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad88').":
					  <span class=\"text-error\"> ".$days."<span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      EERS ".get_lang($lang, 'ad98')." <strong>".$stop."</strong><span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					       <h4><a target=\"_blank\" href=\"admin/admin.php?lang=".$lang."\">".get_lang($lang, 'inter61')."</a></h4></span></td>
                  </tr>
				  </tbody></table>"; die;
			}
	    }
    } 
	else {
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"table\">
				<tbody>
			      <tr>                                    
                      <td colspan=\"2\" style=\"text-align:center;\">".get_lang($lang, 'ad81').":
                      <span class='text-error'> ".get_lang($lang, 'ad83')."<span></td>                                   
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					      EERS ".get_lang($lang, 'ad90')." <span></td>
                  </tr>
                  <tr>                                    
					  <td colspan=\"2\" style=\"text-align:center;\"><span class=\"text-error\">
					       <h4><a target=\"_blank\" href=\"admin/admin.php?lang=".$lang."\">".get_lang($lang, 'inter61')."</a></h4></span></td>
                  </tr>
				  </tbody></table>"; die; 
    }
}
?>