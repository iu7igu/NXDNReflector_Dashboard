<?php
include "config/config.php";
include "include/tools.php";
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>NXDNReflector-Dashboard by IU7IGU - Setup</title>
  </head>
  <body>
<?php
	if ($_GET['cmd'] =="writeconfig") {
		if (!file_exists('./config')) {
		    if (!mkdir('./config', 0777, true)) {
?>
<div class="alert alert-danger" role="alert">You forgot to give write-permissions to your webserver-user!</div>

<?php
		    }
		}
		$configfile = fopen("config/config.php", 'w');
		fwrite($configfile,"<?php\n");
		fwrite($configfile,"# This is an auto-generated config-file!\n");
		fwrite($configfile,"# Be careful, when manual editing this!\n\n");
		fwrite($configfile,"date_default_timezone_set('UTC');\n");
		fwrite($configfile, createConfigLines());
		fwrite($configfile,"?>\n");
		fclose($configfile);
?>
  <div class="page-header">
    <h1><small>NXDNReflector-Dashboard by IU7IGU</small> Setup-Process</h1>
    <div class="alert alert-success" role="alert">Your config-file is written in config/config.php, please remove setup.php for security reasons!</div>
    <p><a href="index.php">Your dashboard is now available.</a></p>
  </div>
<?php
	} else {
?>
  <div class="page-header">
    <h1><small>NXDNReflector-Dashboard by IU7IGU</small> Setup-Process</h1>
    <h4>Please give necessary information below</h4>
  </div>
  <form id="config" action="setup.php" method="get">
    <input type="hidden" name="cmd" value="writeconfig">
    <div class="container">
      <h2>NXDNReflector-Configuration</h2>
	  <div class="input-group">
        <span class="input-group-addon" id="NXDNREFLECTORNAME" style="width: 300px">Name of NXDNReflector</span>
        <input type="text" value="<?php echo constant("NXDNREFLECTORNAME") ?>" name="NXDNREFLECTORNAME" class="form-control" placeholder="ITALY-Reflector" aria-describedby="NXDNREFLECTORNAME" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="NXDNREFLECTORLOGPATH" style="width: 300px">Path to NXDNReflector-logfile</span>
        <input type="text" value="<?php echo constant("NXDNREFLECTORLOGPATH") ?>" name="NXDNREFLECTORLOGPATH" class="form-control" placeholder="/var/log/NXDNReflector/" aria-describedby="NXDNREFLECTORLOGPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="NXDNREFLECTORLOGPREFIX" style="width: 300px">Logfile-prefix</span>
        <input type="text" value="<?php echo constant("NXDNREFLECTORLOGPREFIX") ?>" name="NXDNREFLECTORLOGPREFIX" class="form-control" placeholder="NXDNReflector" aria-describedby="NXDNREFLECTORLOGPREFIX" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="NXDNREFLECTORINIPATH" style="width: 300px">Path to NXDNReflector.ini</span>
        <input type="text" value="<?php echo constant("NXDNREFLECTORINIPATH") ?>" name="NXDNREFLECTORINIPATH" class="form-control" placeholder="/etc/" aria-describedby="NXDNREFLECTORINIPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="NXDNREFLECTORINIFILENAME" style="width: 300px">NXDNReflector.ini-filename</span>
        <input type="text" value="<?php echo constant("NXDNREFLECTORINIFILENAME") ?>" name="NXDNREFLECTORINIFILENAME" class="form-control" placeholder="NXDNReflector.ini" aria-describedby="NXDNREFLECTORINIFILENAME" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="NXDNREFLECTORPATH" style="width: 300px">Path to NXDNReflector-executable</span>
        <input type="text" value="<?php echo constant("NXDNREFLECTORPATH") ?>" name="NXDNREFLECTORPATH" class="form-control" placeholder="/usr/local/bin/" aria-describedby="NXDNREFLECTORPATH" required data-fv-notempty-message="Value is required">
      </div>
    </div>
    <div class="container">
      <h2>Global Configuration</h2>
      <?php
function get_tz_options($selectedzone, $label, $desc = '') {
   echo '<div class="input-group">';
    echo '<span class="input-group-addon" id="TIMEZONE" style="width: 300px">Timezone</span>';
   echo '<div class="input"><select name="TIMEZONE">';
  function timezonechoice($selectedzone) {
    $all = timezone_identifiers_list();
    $i = 0;
    foreach($all AS $zone) {
      $zone = explode('/',$zone);
      $zonen[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
      $zonen[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
      $zonen[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
      $i++;
    }
    asort($zonen);
    $structure = '';
    foreach($zonen AS $zone) {
      extract($zone);
   //   if($continent == 'Africa' || $continent == 'America' || $continent == 'Antarctica' || $continent == 'Arctic' || $continent == 'Asia' || $continent == 'Atlantic' || $continent == 'Australia' || $continent == 'Europe' || $continent == 'Indian' || $continent == 'Pacific') {
        if(!isset($selectcontinent)) {
          $structure .= '<optgroup label="'.$continent.'">'; // continent
        } elseif($selectcontinent != $continent) {
          $structure .= '</optgroup><optgroup label="'.$continent.'">'; // continent
        }
        if(isset($city) != ''){
          if (!empty($subcity) != ''){
            $city = $city . '/'. $subcity;
          }
          if ($continent != "UTC") {
             $structure .= "<option ".((($continent.'/'.$city)==$selectedzone)?'selected="selected "':'')." value=\"".($continent.'/'.$city)."\">".str_replace('_',' ',$city)."</option>"; //Timezone
          } else {
            $structure .= "<option ".(("UTC"==$selectedzone)?'selected="selected "':'')." value=\"UTC\">UTC</option>"; //Timezone
          }
        } else {
          if (!empty($subcity) != ''){
            $city = $city . '/'. $subcity;
          }
          $structure .= "<option ".(($continent==$selectedzone)?'selected="selected "':'')." value=\"".$continent."\">".$continent."</option>"; //Timezone
        }
        $selectcontinent = $continent;
     // }
    }
    $structure .= '</optgroup>';
    return $structure;
  }
  echo timezonechoice($selectedzone);
  echo '</select>';
  echo '</input>';
  echo '</div>';
  echo '</div>';
}
get_tz_options(constant("TIMEZONE"), "Timezone", '');
?>
      <div class="input-group">
        <span class="input-group-addon" id="LOGO" style="width: 300px">URL to Logo</span>
        <input type="text" value="<?php echo constant("LOGO") ?>" name="LOGO" class="form-control" placeholder="http://your-logo" aria-describedby="LOGO">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="REFRESHAFTER" style="width: 300px">Refresh page after in seconds</span>
        <input type="text" value="<?php echo constant("REFRESHAFTER") ?>" name="REFRESHAFTER" class="form-control" placeholder="60" aria-describedby="REFRESHAFTER" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="SHOWPROGRESSBARS" style="width: 300px">Show progressbars</span>
        <div class="panel-body"><input type="checkbox" <?php if (defined("SHOWPROGRESSBARS")) echo "checked" ?> name="SHOWPROGRESSBARS"></div>
      </div>
	  <div class="input-group">
        <span class="input-group-addon" id="SHOWDISK" style="width: 300px">Show Disk-Usage</span>
        <div class="panel-body"><input type="checkbox" <?php if (defined("SHOWDISK")) echo "checked" ?> name="SHOWDISK"></div>
      </div>
	  <div class="input-group">
        <span class="input-group-addon" id="SHOWSYSTEM" style="width: 300px">Show System INFO</span>
        <div class="panel-body"><input type="checkbox" <?php if (defined("SHOWSYSTEM")) echo "checked" ?> name="SHOWSYSTEM"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREALERT" style="width: 300px">Enable CPU-temperature-warning</span>
        <div class="panel-body"><input type="checkbox" <?php if (defined("TEMPERATUREALERT")) echo "checked" ?> name="TEMPERATUREALERT"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREHIGHLEVEL" style="width: 300px">Warning temperature</span>
        <input type="text" value="<?php echo constant("TEMPERATUREHIGHLEVEL") ?>" name="TEMPERATUREHIGHLEVEL" class="form-control" placeholder="60" aria-describedby="TEMPERATUREHIGHLEVEL" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="SHOWQRZ" style="width: 300px">Show link to QRZ.com on Callsigns</span>
        <div class="panel-body"><input type="checkbox" name="SHOWQRZ" <?php if (defined("SHOWQRZ")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="GDPR" style="width: 300px">Anonymize Callsigns (no function if QRZ.com enabled)</span>
        <div class="panel-body"><input type="checkbox" name="GDPR" <?php if (defined("GDPR")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit" form="config">Save configuration</button>
      </span>
    </div>
    </div>
  </form>
  <?php
	}
  ?>
  </body>
</html>