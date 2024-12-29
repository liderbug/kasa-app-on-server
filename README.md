# kasa-app-on-server
Web version of Android Kasa app.

Spending most of my time on my laptop or my desktop I wanted to be able to have the same KASA app display as on my Android.  What you'll find here is A) A php web page that looks (sort'a) like the smartphone app.  B) A external program found here on github. HS100 C code. C) A php script to find and save a list of all of your smart switches and plugs.

C:  run_update.php runs "arp_scan" to find the IP addresses of the smart switches and plugs in your network and creates a file in the "/run" tmpfs.  This file is accessed by the web page.

B:  HS100.c an external program found here in/on github.  Download separately, compile and save in the web sub-directory.

A: index.php - the web page that does it all.   Hopefully it's written so you can read it and tweek it to fit your needs.

After installing A, B, and C.  Run "sudo php run_update.php".  It will create the file "/run/kasa_device_list".  You may have to install "arp_scan".  Then you should be able to browser:  https[s]://[server]/kasa/index.php 

  
