  
<?php
echo "\n";

$fd = fopen ("/run/kasa_device_list", "w");
exec ("sudo /usr/sbin/arp-scan --localnet | grep -v 'Interface' | grep '192.168.0'", $arps);

$arps =  str_replace ('	', '|', $arps);

  $rep = array ( '34:60:f9:11:1e:3a', '48:22:54:2e:51:d6', '48:22:54:2e:5d:bb', '74:fe:ce:35:74:01', '98:25:4a:23:55:fa', '74:fe:ce:35:d2:db', 'b0:be:76:aa:0c:8b', 'b0:be:76:aa:12:81');
  
  $out = array();
  foreach ($rep as $r)
  {
    $s = substr ($r, 0, 17);
    foreach ($arps as $a)
    {
      $mac = explode ("|", $a);
      if ( strstr ($s, $mac[1]))
      {
        $ret = "";
        exec ("/var/www/html/kasa/hs100 $mac[0] info", $ret);
        $n = strpos ($ret[0], "alias")+8;
        $word = substr ($ret[0], $n, 20);
        $n = strpos ($word, "\"");
        $word = substr ($word, 0, $n);
	$add = "";
	exec ("grep $mac[0] /etc/hosts | awk '{print $2}'",$add);
 #       exec ("echo '$add[0]' >> /run/kasa_device_list");;
fputs ($fd,   "$add[0]\n");
      }
    }
  }
fclose ($fd);
