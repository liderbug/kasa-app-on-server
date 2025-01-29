
# this file goes in /var/www/html/kasa/index.php

<head> 
  <link href="main.css" rel="stylesheet" />
</head> 

<?php
  include_once 'dbconnect.php';
  date_default_timezone_set('America/Denver');

  # /etc/hosts= 192.168.0.105 kasa.front_door
  # my kasa device have static ip's via router

  exec ("grep kasa /etc/hosts | sort", $dev_list);  

  # is there a switch to toggle
  # Can't run python from Apache/PHP - so FAKE it.
  if ( isset( $_POST['dev']) )
  {
    $cmd = $_POST['dev'];   # 192.168.0.105,0
    $q = mysqli_query ($db1, "insert into fake values (0,'$cmd')");
    $refresh_time = 2;
  }

  $cols = 0;
  echo "<blockquote><blockquote><H1>KASA</H1>\n";
  echo "<h3>" . date ('h:i:s') . "</h3>";
  echo "<table border=0>\n";

  foreach ($dev_list as $dev_ip)
  {
    $sw = explode (' ', $dev_ip);
    $dev_ip = $sw[0]; # oo = OnOff ... inuse means installed, 0 would mean placeholder
    $s1 = mysqli_query ($db1, "select oo from status where inuse = 1 and id = '$dev_ip';");
    $stat = mysqli_fetch_row ($s1);
    $relay_state = ($stat[0])? 0:1; # is the device On or Off and flip it
    $a = explode ('.', $sw[2]); # ip kasa.kitchen becomes just kitchen
    $alias = $a[1];

    $onoff = ($relay_state)? "b2on":"b2off"; # which icon
    
    if ($cols == 0) # col 1 or 2
      echo "<tr>\n";
    echo "<td><b>$alias</b></td>\n";
    echo "<form method=POST action=index.php>\n";
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
  
  if ($cols == 1) # clean up the table
    echo "</tr>\n";
  echo "</table>\n";

  # then web says Apache won't do python - so run it from a bash script 
  shell_exec(sprintf('bash /usr/local/bin/fakeitout.bash > /dev/null 2>&1 &'));

  echo "<meta http-equiv='refresh' content='$refresh_time;url=index.php' />";
  $refresh_time = 30;

