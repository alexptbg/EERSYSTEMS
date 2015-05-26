<?php
defined('start') or die('Direct access not allowed.');
function get_ram(){
	$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
	$total_memory = 0;
	$free_memory = 0;
	foreach ($wmi->ExecQuery("SELECT TotalPhysicalMemory FROM Win32_ComputerSystem") as $cs) {
		$total_memory = $cs->TotalPhysicalMemory;
	}
	foreach ($wmi->ExecQuery("SELECT FreePhysicalMemory FROM Win32_OperatingSystem") as $os) {
		$free_memory = $os->FreePhysicalMemory;
	}
	$free_memory = $free_memory * 1024;
	$used_memory=$total_memory-$free_memory;
	return array(
		'type'  => 'Physical',
		'total' => $total_memory,
		'free'  => $free_memory,
		'used'  => $used_memory
	);
}
function get_bios() {
	$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
	foreach ($wmi->ExecQuery("SELECT Version FROM Win32_BIOS") as $cs) {
		$brand = $cs->Version;
	}
	foreach ($wmi->ExecQuery("SELECT Manufacturer FROM Win32_BIOS") as $cs) {
		$bios_Manufacturer = $cs->Manufacturer;
	}
	foreach ($wmi->ExecQuery("SELECT Name FROM Win32_BIOS") as $cs) {
		$bios_Version = $cs->Name;
	}
	return array(
		'brand' => $brand,
		//'date' => substr($brand, 9, 4).'-'.substr($brand, 13, 2).'-'.substr($brand, 15, 2),		
		'bios_Manufacturer' => $bios_Manufacturer,
		'bios_Version' => $bios_Version
	);
}
function get_net($lang) {
		$return = array();
		$i = 0;
		$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
		foreach ($wmi->ExecQuery("SELECT WindowsVersion FROM Win32_Process WHERE Handle = 0") as $process) {
			//$kernel->windows_version = $process->WindowsVersion;
			$kernel = $process->WindowsVersion;
		}
		if ($kernel > "6.1.0000") {
			$object = $wmi->ExecQuery("SELECT AdapterType, Name, NetConnectionStatus, GUID FROM Win32_NetworkAdapter WHERE PhysicalAdapter = TRUE");
		} else {
			$object = $wmi->ExecQuery("SELECT AdapterType, Name, NetConnectionStatus FROM Win32_NetworkAdapter WHERE NetConnectionStatus != NULL");
		}
		foreach ($object as $net) {
			$return[$net->Name] = array(
				'recieved' => array(
					'bytes' => 0,
					'errors' => 0,
					'packets' => 0
				),
				'sent' => array(
					'bytes' => 0,
					'errors' => 0,
					'packets' => 0
				),
				'state' => 0,
				'type' => $net->AdapterType
			);
			switch($net->NetConnectionStatus) {
				case 0:
					$return[$net->Name]['state'] = 'down';
					break;
				case 1:
					$return[$net->Name]['state'] = 'Connecting';
					break;
				case 2:
					$return[$net->Name]['state'] = '<span class="label label-success">'.get_lang($lang, 'Online').'</span>';
					break;
				case 3:
					$return[$net->Name]['state'] = 'Disconnecting';
					break;
				case 4:
					$return[$net->Name]['state'] = 'down';
					break;
				case 5:
					$return[$net->Name]['state'] = 'Hardware disabled';
					break;
				case 6:
					$return[$net->Name]['state'] = 'Hardware malfunction';
					break;
				case 7:
					$return[$net->Name]['state'] = '<span class="label label-important">'.get_lang($lang, 'Offline').'</span>';//media disconnected
					break;
				case 8:
					$return[$net->Name]['state'] = 'Authenticating';
					break;
				case 9:
					$return[$net->Name]['state'] = 'Authentication succeeded';
					break;
				case 10:
					$return[$net->Name]['state'] = 'Authentication failed';
					break;
				case 11:
					$return[$net->Name]['state'] = 'Invalid address';
					break;
				case 12:
					$return[$net->Name]['state'] = 'Credentials required';
					break;
				default:
					$return[$net->Name]['state'] = 'unknown';
					break;
			}
			if ($kernel > "6.1.0000") {
				$canonname = preg_replace("/[^A-Za-z0-9- ]/", "_", $net->Name);
				$isatapname = "isatap." . $net->GUID;
				$result = $wmi->ExecQuery("SELECT BytesReceivedPersec, PacketsReceivedErrors, PacketsReceivedPersec, BytesSentPersec, PacketsSentPersec FROM Win32_PerfRawData_Tcpip_NetworkInterface WHERE Name = '$canonname' OR Name = '$isatapname'");
			} else {
				$canonname = preg_replace("/[^A-Za-z0-9- ]/", "_", $net->Name);
				$result = $wmi->ExecQuery("SELECT BytesReceivedPersec, PacketsReceivedErrors, PacketsReceivedPersec, BytesSentPersec, PacketsSentPersec FROM Win32_PerfRawData_Tcpip_NetworkInterface WHERE Name = '$canonname'");
			}
			foreach ($result as $netspeed) {
				$return[$net->Name]['recieved'] = array(
					'bytes' => (int)$netspeed->BytesReceivedPersec,
					'errors' => (int)$netspeed->PacketsReceivedErrors,
					'packets' => (int)$netspeed->PacketsReceivedPersec
				);
				$return[$net->Name]['sent'] = array(
					'bytes' => (int)$netspeed->BytesSentPersec,
					'erros' => 0,
					'packets' => (int)$netspeed->PacketsSentPersec
				);
			}
			$i++;
		}
		return $return;
}
function net_widget($lang) {
	$net = get_net($lang);
    if (count($net) > 0) {
	  echo "<table cellpadding='0' cellspacing='0' class='table'>
			<thead>
            <tr>                                    
            <th width='45%'>".get_lang($lang, 'inter41')."</th>
            <th width='13%'>".get_lang($lang, 'inter42')."</th>
            <th width='16%'>".get_lang($lang, 'inter43')."</th>
            <th width='18%'>".get_lang($lang, 'inter44')."</th> 
            <th width='8%'>".get_lang($lang, 'Status')."</th>                                   
            </tr>
			</thead>
	        <tbody>";
			foreach($net as $device => $stats) {
			  echo '
				<tr>
					<td>'.$device.'</td>
					<td>'.$stats['type'].'</td>
					<td>'.byte_convert($stats['sent']['bytes']).'</td>
					<td>'.byte_convert($stats['recieved']['bytes']).'</td>
					<td>'.$stats['state'].'</td>
				</tr>';
				}
			echo "</tbody></table>";
			}
		else {
	        echo "<div class='z100'>";
	        get_error($lang, '1008'); 
		    echo "</div>"; 
		}
}
function get_disks($lang) {
		$drives = array();
		$partitions = array();
		$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
		foreach ($wmi->ExecQuery("SELECT DiskIndex, Size, DeviceID, Type FROM Win32_DiskPartition") as $partition) {
			$partitions[$partition->DiskIndex][] = array(
				'size' => $partition->Size,
				'name' => $partition->DeviceID . ' (' . $partition->Type . ')'
			);
		}
		foreach ($wmi->ExecQuery("SELECT Caption, DeviceID, Index, Size FROM Win32_DiskDrive") as $drive) {
			$caption = explode(" ", $drive->Caption);
			$drives[] = array(
				'name'   => $drive->Caption,
				'vendor' => reset($caption),
				'device' => $drive->DeviceID,
				'reads'  => false,
				'writes' => false,
				'size'   => $drive->Size,
				'partitions' => array_key_exists($drive->Index, $partitions) && is_array($partitions[$drive->Index]) ? $partitions[$drive->Index] : false 
			);
		}
		usort($drives, array('windows','compare_drives'));
		return $drives;
}
function disks_widget($lang) {
	$devs = get_disks($lang);
	if (count($devs) > 0) {
	  echo "<table cellpadding='0' cellspacing='0' class='table'>
			<thead>
            <tr>                                    
            <th>".get_lang($lang, 'inter47')."</th>
            <th>".get_lang($lang, 'inter48')."</th>
            <th>".get_lang($lang, 'Name')."</th>
            <th>".get_lang($lang, 'inter49')."</th>                                
            </tr>
			</thead>
	        <tbody>";
		foreach($devs as $drive) {
			echo "
				<tr>
					<td>".$drive['device']."</td>
					<td>".$drive['vendor']."</td>
					<td>".$drive['name']."</td>
					<td>". byte_convert($drive['size'])."</td>
				</tr>";
			if (array_key_exists('partitions', $drive) && is_array($drive['partitions']) && count($drive['partitions']) > 0) {
				echo "<tr><td colspan='6'>";
				foreach ($drive['partitions'] as $partition)
					echo "
					&#9492; ".(isset($partition['number']) ? $drive['device'].$partition['number'] : $partition['name'])
						     ." - ".byte_convert($partition['size'])."<br />";
				echo "</td></tr>";
			}
		}
		echo "</tbody></table>";
	}
	else {
	    echo "<div class='z100'>";
	    get_error($lang, '1008'); 
	    echo "</div>"; 
	}
}
function get_server_info($lang,$db) {
	$ar = multiexplode(array("/"," "),$_SERVER['SERVER_SOFTWARE']);
    $ss = ('1.1 r6');
	echo "
		 <table cellpadding='0' cellspacing='0' class='table server'>
	     <tbody>
         <tr><td class='x40' style='text-align:right;font-weight:700;'>Apache ".get_lang($lang, 'inter40')."</td>
			 <td class='x60'>".$ar[1]."</td></tr>
         <tr><td class='x40' style='text-align:right;font-weight:700;'>PHP ".get_lang($lang, 'inter40')."</td>
			 <td class='x60'>".phpversion()."</td></tr>
         <tr><td class='x40' style='text-align:right;font-weight:700;'>mySQL ".get_lang($lang, 'inter40')."</td>
			 <td class='x60'>".mysql_get_server_info()."</td></tr>
         <tr><td class='x40' style='text-align:right;font-weight:700;'>OpenSSL ".get_lang($lang, 'inter40')."</td>
			 <td class='x60'>".$ar[4]."</td></tr>
         <tr><td class='x40' style='text-align:right;font-weight:700;'>Database client ".get_lang($lang, 'inter40')."</td>
			 <td class='x60'>".mysqli_get_client_version()."</td></tr>
         <tr><td class='x40' style='text-align:right;font-weight:700;'>Socket Server ".get_lang($lang, 'inter40')."</td>
			 <td class='x60'>".$ss."</td></tr>
         <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'ad217')."</td>
			 <td class='x60'>".calc_database_size($db)."</td></tr>		 			 
         </tbody>
		 </table>";
}
function get_sys_info($lang) {
	$wmi = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
		foreach ($wmi->ExecQuery("SELECT Caption FROM Win32_OperatingSystem") as $os) {
			$osx = $os->Caption;
		}
		foreach ($wmi->ExecQuery("SELECT WindowsVersion FROM Win32_Process WHERE Handle = 0") as $process) {
			//$kernel->Windows_Version = $process->WindowsVersion;
			$kernel = $process->WindowsVersion;
		}
		foreach ($wmi->ExecQuery("SELECT Name FROM Win32_ComputerSystem") as $cs) {
			$hostname = $cs->Name;
		}
		$booted_str = "";
		foreach ($wmi->ExecQuery("SELECT LastBootUpTime FROM Win32_OperatingSystem") as $os) {
			$booted_str = $os->LastBootUpTime;
		}
		$booted = array(
			'year'   => substr($booted_str, 0, 4),
			'month'  => substr($booted_str, 4, 2),
			'day'    => substr($booted_str, 6, 2),
			'hour'   => substr($booted_str, 8, 2),
			'minute' => substr($booted_str, 10, 2),
			'second' => substr($booted_str, 12, 2)
		);
		$booted_ts = mktime($booted['hour'], $booted['minute'], $booted['second'], $booted['month'], $booted['day'], $booted['year']);
		$uptime = array(
			'up' => seconds_convert($lang,time() - $booted_ts),
			'booted' => date('Y-m-d - h:i:s', $booted_ts)
		);
		$processes = array(
			'proc_total' => 0,
			'threads' => 0
		);
		foreach($wmi->ExecQuery("SELECT ThreadCount FROM Win32_Process") as $proc) {
			$processes['threads'] += (int)$proc->ThreadCount;
			$processes['proc_total']++;
		}
		$cpus = array();
		$alt = false;
		$object = $wmi->ExecQuery("SELECT Name, Manufacturer, CurrentClockSpeed, NumberOfLogicalProcessors FROM Win32_Processor");
		if (!is_object($object)) {
			$object = $wmi->ExecQuery("SELECT Name, Manufacturer, CurrentClockSpeed FROM Win32_Processor");
			$alt = true;
		}
		foreach($object as $cpu) {
			$curr = array(
				'Model' => $cpu->Name,
				'Vendor' => $cpu->Manufacturer,
				'MHz' => $cpu->CurrentClockSpeed,
			);
			$curr['Model'] = $cpu->Name;
			if (!$alt) {
				for ($i = 0; $i < $cpu->NumberOfLogicalProcessors; $i++)
					$cpus[] = $curr;
			} else {
				$cpus[] = $curr;
			}
		}
		$cores = count($cpus);
		$hostaddr = $_SERVER['SERVER_ADDR'];
		foreach($wmi->ExecQuery("SELECT Architecture FROM Win32_Processor") as $cpu) {
			switch($cpu->Architecture) {
				case 0:
					$arc = "x86";
				case 1:
					$arc = "MIPS";
				case 2:
					$arc = "Alpha";
				case 3:
					$arc = "PowerPC";
				case 6:
					$arc = "Itanium-based systems";
				case 9:
					$arc = "x64";
			}
		}
	$sys = array(
		'os'  => $osx,
		'kernel' => $kernel,
		'hostname' => $hostname,
		'hostaddr' => $hostaddr,
		'uptime' => $uptime,
		'processes' => $processes,
		'cpu' => $cpus,
		'core' => $cores,
		'arc' => $arc
	);
	return $sys;
}
function sys_widget($lang) {
    $rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
    function get_uptime() {
	    setInterval(function () {
			$.ajax({
				url: 'uptime.php?lang=$lang', 
				success: function(point) {
		    y = eval(point);
			up = y[1];
			$('span#uptime').text(up);
			},
				cache: false
			});
	    }, 1000);
	}
    function get_mhz() {
	    setInterval(function () {
			$.ajax({
				url: 'mhz.php', 
				success: function(point) {
		    y = eval(point);
			num = y[1];
			$('span#c$rand').text(num+' Mhz');
			},
				cache: false
			});
	    }, 2000);
	}
    $(function () { get_mhz(); get_uptime(); });
</script>";
    $bios = get_bios();
	$sys = get_sys_info($lang);
		echo "
		    <table cellpadding='0' cellspacing='0' class='table'>
			<tbody>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'ad296')."</td>
			    <td class='x60'>".$bios['brand']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'ad295')."</td>
			    <td class='x60'>".$bios['bios_Manufacturer']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'ad298')."</td>
			    <td class='x60'>".$bios['bios_Version']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter26')."</td>
			    <td class='x60'>".$sys['os']."<img src='img/icons/windows.png' alt='windows' /></td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter27')."</td>
			    <td class='x60'>".$sys['kernel']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter28')."</td>
			    <td class='x60'>".$sys['hostname']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter29')."</td>
			    <td class='x60'>".$sys['hostaddr']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter30')."</td>
			    <td class='x60'><span id='uptime'>".$sys['uptime']['up']."</span></td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter31')."</td>
			    <td class='x60'>".$sys['uptime']['booted']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter32')."</td>
			    <td class='x60'>".$sys['core']." X ".$sys['cpu']['0']['Model']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter33')."</td>
			    <td class='x60'>".$sys['core']." X <span id='c$rand'>2401 Mhz</span></td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter34')."</td>
			    <td class='x60'><span id='load'>11 %</span></td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter35')."</td>
			    <td class='x60'>".$sys['arc']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter36')."</td>
			    <td class='x60'>".$sys['processes']['proc_total']."</td></tr>
            <tr><td class='x40' style='text-align:right;font-weight:700;'>".get_lang($lang, 'inter37')."</td>
			    <td class='x60'>".$sys['processes']['threads']."</td></tr>
            </tbody>
			</table>";
}
function get_servers_status($lang){
    mysql_query("SET NAMES 'utf8'");
    $query = "SELECT * FROM `servers_info`";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) != 0 ) {
		echo "
		    <table cellpadding='0' cellspacing='0' class='table'>
			<thead>
            <tr>                                    
            <th width='25%'>".get_lang($lang, 'Name')."</th>
            <th width='25%'>".get_lang($lang, 'Status')."</th>
            <th width='20%'>".get_lang($lang, 'Port')."</th>
            <th width='30%'>".get_lang($lang, 'Latency')."</th>                                    
            </tr>
			</thead>
			<tbody>
		";
		while($row = mysql_fetch_array($result)) {
			check_server_status($lang,$row['name'],$row['ip_addr'],$row['port']);
		}
		echo "</tbody></table>";
	} else {
	    echo "<div class='z100'>";
	    get_error($lang, '1007'); 
		echo "</div>"; 
	}
}
function check_server_status($lang,$name,$host,$port) {
  $start_time = microtime(TRUE);
  $status = @fsockopen($host,$port,$errno, $errstr,1);
  if (!$status) { 
  echo "
  <tr>
  <td>$name</td>
  <td><span class='label label-important'>".get_lang($lang, 'Offline')."</span></td>
  <td>$port</td>
  <td>-</td>
  </tr>
  ";
  }
  elseif ($status) {
  $end_time = microtime(TRUE);
  $time_taken = $end_time - $start_time;
  $time_taken = round($time_taken,5);
  $time_taken = $time_taken * 1000 / 2;
  $time_taken = number_format($time_taken,2);
  echo "
  <tr>
  <td>$name</td>
  <td><span class='label label-success'>".get_lang($lang, 'Online')."</span></td>
  <td>$port</td>
  <td>$time_taken <em><small>(".get_lang($lang, 'ms').")</small></em></td>
  </tr>
  ";
  } else {
    //do nothing
  }
}
function ram_widget($lang) {
	$ram = get_ram();
    $used = $ram['used'];
	$total = $ram['total'];
	$free = $ram['free'];
	$rp = ($ram['used'] / $ram['total']) * 100;
	echo "<div class='w98'>";
	$rf = decodeSize($free);
	$rfp = 100-$rp;
	$rfp2 = number_format($rfp,2);
	$rp0 = number_format($rp,0);	
	$rp1 = number_format($rp,1);
	$rp2 = number_format($rp,2);
	if ($rp0>80) { $progress = 'danger'; }
	elseif (($rp0>60) && ($rp0<81)) { $progress = 'warning'; }
	else { $progress = 'success'; }
	echo "<strong>".get_lang($lang, 'inter08') . ":</strong> " . decodeSize($total). "<br/>";
    echo "<div class='progress progress-$progress'>
              <div class='bar tipb' style='width:". $rp0 ."%' title=' " . get_lang($lang, 'inter09') . ": " . $rp2 ."%'></div>
          </div>";
	echo "<strong>".get_lang($lang, 'inter09') . ":</strong> " . $rp2 . "% (" . decodeSize($used) . ")<br/>";
	echo "<strong>".get_lang($lang, 'inter10') . ":</strong> " . $rfp2 . "% (" . $rf . ")</div>";
}
function ram_widget_chart($lang) {
	$ram = get_ram();
	$rp = ($ram['used'] / $ram['total']) * 100;
	$rp2 = number_format($rp,2);
	$total = $ram['total'];
	$rfp = 100-$rp;
	$rfp2 = number_format($rfp,2);
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
    var chart$rand;
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]
		        ]
		    };
		});
    $(document).ready(function () {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_$rand',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			margin: [0, 0, 0, 0],
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: null
            },
            tooltip: {
formatter: function() {
    return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
}
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                },
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
            },
            legend: {
                enabled: false
            },
        credits: {
            enabled: false
        },
            exporting: {
                enabled: false
            },
            series: [{
                type: 'pie',
                data: [
					{
						name: '".get_lang($lang, 'inter10') . "',
						y: $rfp2
					},
                    {
                        name: '".get_lang($lang, 'inter09') . "',
                        y: $rp2,
                        sliced: true,
                        selected: true
                    }
                ]
            }]
        });
    }); 
});
</script>
<div id='clml10'><span id='c$rand'>".decodeSize($total)."</span></div>
<div id='chart_$rand' style='width:100%; height:240px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function disk_widget($drive,$lang) {
    $used = get_disk_used_space($drive);
	$total = get_disk_total_space($drive);
	echo "<div class='w98'>";
	$dp = get_disk_used_percent($drive);
	$df = decodeSize(get_disk_free_space($drive));
	$dfp = 100-$dp;
	$dfp2 = number_format($dfp,2);
	$dp0 = number_format($dp,0);	
	$dp1 = number_format($dp,1);
	$dp2 = number_format($dp,2);	
	if ($dp0>80) { $progress = 'danger'; }
	elseif (($dp0>60) && ($dp0<81)) { $progress = 'warning'; }
	else { $progress = 'success'; }
	echo "<strong>".get_lang($lang, 'inter04') . ":</strong> " . decodeSize($total). "<br/>";
    echo "<div class='progress progress-$progress'>
              <div class='bar tipb' style='width:". $dp0 ."%' title=' " . get_lang($lang, 'inter02') . ": " . $dp2 ."%'></div>
          </div>";
	echo "<strong>".get_lang($lang, 'inter02') . ":</strong> " . $dp2 . "% (" . decodeSize($used) . ")<br/>";
	echo "<strong>".get_lang($lang, 'inter03') . ":</strong> " . $dfp2 . "% (" . $df . ")</div>";
}
function disk_widget_chart($drive,$lang) {
	$total = get_disk_total_space($drive);
	$dp = get_disk_used_percent($drive);
	$dp2 = number_format($dp,2);
	$dfp = 100-$dp;
	$dfp2 = number_format($dfp,2);
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
    var chart$rand;
    $(document).ready(function () {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_$rand',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			margin: [0, 0, 0, 0],
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
            },
            title: {
                text: null
            },
            tooltip: {
formatter: function() {
    return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' %';
}
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                },
            series: {
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
            }
            },
            legend: {
                enabled: false
            },
        credits: {
            enabled: false
        },
            exporting: {
                enabled: false
            },
            series: [{
                type: 'pie',
                data: [
					{
						name: '".get_lang($lang, 'inter03') . "',
						y: $dfp2,
						color:'#FF00FF'
					},
                    {
                        name: '".get_lang($lang, 'inter02') . "',
                        y: $dp2,
						color: '#0000FF',
                        sliced: true,
                        selected: true
                    }
                ]
            }]
        });
    }); 
});
</script>
<div id='clml10'><span id='c$rand'>".decodeSize($total)."</span></div>
<div id='chart_$rand' style='width:100%; height:240px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>";
}
function get_cpu_chart($lang) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        var chart$rand;
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_$rand',
                type: 'area',
                marginRight: 10,
                events: {
                    load: function() {
                        var series = this.series[0];
                        setInterval(function() {
			$.ajax({
				url: 'cpu.php', 
				success: function(point) {
				    y = eval(point);
					var x = y[0],
					    y = y[1] + (Math.random()*0.5);
						z = y.toPrecision(3);
					series.addPoint([x, y], true);
					$('span#c$rand').text(z+' %');
					$('span#load').text(z+' %');					
					 },
				cache: false
			});
                        }, 2000);
                    }
                }
            },
            title: {
                text: '".get_lang($lang, 'inter12')."'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 100
            },
            yAxis: {
                title: {
                    text: null
                },
				min: 0,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
                        Highcharts.numberFormat(this.y, 2) +'%';
                }
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, 'rgba(116,232,0,0.5)'],
                            [1, 'rgba(0,196,0,0.8)']
                        ]
                    },
                    lineWidth: 1,
                    marker: {
                        enabled: false,
                        states: {
                            hover: {
                                enabled: true,
                                radius: 5
                            }
                        }
                    },
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                },
            series: {
				lineColor: '#00C400',
                marker: {
                    enabled: false,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            }
            },
            legend: {
                enabled: false
            },
        credits: {
            enabled: false
        },
            exporting: {
                enabled: false
            },
            series: [{
                name: '".get_lang($lang, 'inter15')."',
                data: []
            }]
        });
    });
});
</script>
<div id='clml'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:280px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}
function get_ram_chart($lang) {
	$rand = rand(1000,9999);
    echo "
<script type='text/javascript' charset='UTF-8'>
$(function () {
    $(document).ready(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        var chart$rand;
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_$rand',
                type: 'area',
                marginRight: 10,
                events: {
                    load: function() {
                        var series = this.series[0];
                        setInterval(function() {
			$.ajax({
				url: 'ram.php', 
				success: function(point) {
				    y = eval(point);
					var x = y[0],
					    y = y[1];
					series.addPoint([x, y], true);
					$('span#c$rand').text(y.toPrecision(10)+'');
					 },
				cache: false
			});
                        }, 1000);
                    }
                }
            },
            title: {
                text: '".get_lang($lang, 'inter12')."'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 100
            },
            yAxis: {
                title: {
                    text: null
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
                        Highcharts.numberFormat(this.y, 0);
                }
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, 'rgba(5,125,245,0.5)'],
                            [1, 'rgba(0,85,170,0.8)']
                        ]
                    },
                    lineWidth: 1,
                    marker: {
                        enabled: false,
                        states: {
                            hover: {
                                enabled: true,
                                radius: 5
                            }
                        }
                    },
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                },
            series: {
				lineColor: '#0055aa',
                marker: {
                    enabled: false,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                }
            }
            },
            legend: {
                enabled: false
            },
        credits: {
            enabled: false
        },
            exporting: {
                enabled: false
            },
            series: [{
                name: '".get_lang($lang, 'inter13')."',
                data: []
            }]
        });
    });
});
</script>
<div id='clml'><span id='c$rand'>0</span></div>
<div id='chart_$rand' style='width:100%; height:280px; margin: 0 auto'><div class='loading'><img src='img/loaders/c_loader_gr.gif' /></div></div>
	";
}
function calc_database_size($database) {
    $tables = mysql_query("SHOW TABLES FROM `$database`");
    if (!$tables) { return -1; }
    $table_count = mysql_num_rows($tables);
    $size = 0;
    for ($i=0; $i < $table_count; $i++) {
        $tname = mysql_tablename($tables, $i);
        $r = mysql_query("SHOW TABLE STATUS FROM `".$database."` LIKE '".$tname."'");
        $data = mysql_fetch_array($r);
        $size += ($data['Index_length'] + $data['Data_length']);
    };
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size > 1024; $i++) { $size /= 1024; }
    return round($size, 2).$units[$i];
}
function seconds_convert($lang,$uptime) {
	$uptime += $uptime > 60 ? 30 : 0;
	$years = floor($uptime / 31556926);
	$uptime %= 31556926;
	$days = floor($uptime / 86400);
	$uptime %= 86400;
	$hours = floor($uptime / 3600);
	$uptime %= 3600;
	$minutes = floor($uptime / 60);
	$seconds = floor($uptime % 60);
	$return = array();
	if ($years > 0)
		$return[] = $years.' '.($years > 1 ? get_lang($lang, 'inter17') : get_lang($lang, 'inter16'));
	if ($days > 0)
		$return[] = $days.' '.($days > 1 ? get_lang($lang, 'inter21') : get_lang($lang, 'inter20'));
	if ($hours > 0)
		$return[] = $hours.' '.($hours > 1 ? get_lang($lang, 'inter19') : get_lang($lang, 'inter18'));
	if ($minutes > 0)
		$return[] = $minutes.' '.($minutes > 1 ? get_lang($lang, 'inter23') : get_lang($lang, 'inter22'));
	if ($seconds > 0)
		$return[] = $seconds.' '.($seconds > 1 ? get_lang($lang, 'inter25') : get_lang($lang, 'inter24'));
	return implode(', ', $return);
}
function byte_convert($size, $precision = 2) {
	if (!is_numeric($size)) return '?';
	$notation = 1024;
	$types = array('B', 'KB', 'MB', 'GB', 'TB');
	$types_i = array('B', 'KiB', 'MiB', 'GiB', 'TiB');
	for($i = 0; $size >= $notation && $i < (count($types) -1 ); $size /= $notation, $i++);
	return(round($size, $precision) . ' ' . ($notation == 1000 ? $types[$i] : $types_i[$i]));
}
class windows {
	static function compare_devices($a, $b) {
		if ($a['type'] == $b['type']) {
			if ($a['vendor'] == $b['vendor']) {
				if ($a['device'] == $b['device']) {
					return 0;
				}
				return ($a['device'] > $b['device']) ? 1 : -1;
			}
			return ($a['vendor'] > $b['vendor']) ? 1 : -1;
		}
		return ($a['type'] > $b['type']) ? 1 : -1;
	}
	static function compare_drives($a, $b) {
		if ($a['device'] == $b['device']) {
			return 0;
		}
		return ($a['device'] > $b['device']) ? 1 : -1;
	}
	static function compare_mounts($a, $b) {
		if ($a['mount'] == $b['mount']) {
			return 0;
		}
		return ($a['mount'] > $b['mount']) ? 1 : -1;
	}
}
?>