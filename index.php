
 <head> 
   <link href="main.css" rel="stylesheet" />
 </head> 

  <?php
  date_default_timezone_set('America/Denver');
  $dev_list = file("/run/kasa_device_list");
  
  # is there a switch to toggle
  if ( isset( $_POST['dev']) )
  {
    $o = explode (".", $_POST['dev']);
    $onoff = ($o[1])? "off":"on";
    exec ("./hs100 $o[0] $onoff &",  $ret);
  }
  
  $cols = 0;
  echo "<blockquote><blockquote><H1>KASA</H1>\n";
  echo "<h3>" . date ('h:m:s') . "</h3>";
  echo "<table border=0>\n";

  foreach ($dev_list as $dev_ip)
  {
    $dev_ip = trim($dev_ip);
    $status = "";
    exec ("./hs100 $dev_ip info", $status);
    $a = substr ($status[0], strpos($status[0], 'alias')+8, 25);
    $b = strpos ($a, "\"");
    $alias = substr ($a, 0, $b);

    $relay_state = (substr ($status[0], strpos($status[0], 'relay_state')+13, 1));
    $onoff = ($relay_state)? "kon":"koff";
    
    if ($cols == 0)
      echo "<tr>\n";
    $alias = str_replace (" ", "<br>", $alias);
    echo "<td><b>$alias</b></td>\n";
    echo "<form method=POST action=index.php>\n";
    echo "<td> <input type='hidden'  name='dev' value='$dev_ip.$relay_state'>\n";
    echo "<input type=image name=submit src=./$onoff.png border=0 />\n";
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

