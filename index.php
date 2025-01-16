
 <head> 
   <link href="main.css" rel="stylesheet" />
 </head> 

  <?php
$unpw = "--password nonofyourbiz --username myemail@server.com";

  date_default_timezone_set('America/Denver');
  exec ("grep kasa /etc/hosts", $dev_list);  
  # is there a switch to toggle
  if ( isset( $_GET['dev']) )
  {
    $o = explode (',', $_GET['dev']);
    $oo = ($o[1])? "off":"on";
    exec ("./hs100 $o[0] $oo &",  $ret);
    if ( strlen($ret[0]) == 0)
      echo "KASA<br>";
  }

  $cols = 0;
  echo "<blockquote><blockquote><H1>KASA</H1>\n";
  echo "<h3>" . date ('h:m:s') . "</h3>";
  echo "<table border=0>\n";

  foreach ($dev_list as $dev_ip)
  {
    $sw = explode (' ', $dev_ip);
    $dev_ip = $sw[0];
    $status = "";
    exec ("timeout 1 ./hs100 $sw[0] info", $status);

    if ( sizeof($status) == 0)
    {
        # kasa is a python script and I can't get it working ... yet :-/
        #   echo "/usr/local/bin/kasa --host 192.168.0.105 $unpw sysinfo | grep -i device_on<br>";
        #   exec ("/usr/local/bin/kasa --host $sw[0] $unpw sysinfo | /usr/bin/grep -i 'device_on'", $status);
    }

    $alias = str_replace ("kasa.", "", $sw[2]);

    $relay_state = (substr ($status[0], strpos($status[0], 'relay_state')+13, 1));
    $onoff = ($relay_state)? "b2on":"b2off";
    
    if ($cols == 0)
      echo "<tr>\n";
    echo "<td><b>$alias</b></td>\n";
    echo "<form method=GET action=index.php>\n";
    echo "<td> <input type='hidden'  name='dev' value='$dev_ip,$relay_state'>\n";
    echo "<input type=image name=submit src=./$onoff.png width=75 border=0 />\n";
    echo "</form>\n";
    echo "</td>\n";
    
    if ($cols == 0)
    {
      echo "<td width=50px>&nbsp;</td>";
      $cols = 1;
    } else {
      $cols=0;
      echo "</tr>\n\n";
    }
  }
  
  if ($cols == 1)
    echo "</tr>\n\n";
  echo "</table>\n";
  
  echo "<meta http-equiv='refresh' content='5;url=index.php' />";

