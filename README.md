# kasa-app-on-server

Web version of Android Kasa app.

Spending most of my time on my laptop or my desktop (and my smartphone is NOT attached to the end of my arm) I wanted to be able to have the same KASA app display as on my Android. What you'll find here is:

 A) A php web page that looks (sort'a) like the smartphone app.  See the file kasa.png

B) A external program found here on github.  Python-Kasa.

Found out the hard way a PHP web page will not? can not? run Python code.  I tried every way I could think of - nothing happens and Google seems to back it up.  So ...  ( fake-it ) and assumption - you're LAMP.

    pip3 install python-kasa - the external program
    mysql - create database kasa
    mysql - kasa < kasa.sql
    edit dbconnect.php, fake.bash, fakeitout.bash for your username & password
    cp fake*.bash /usr/local/bin/.
    cp index.php /var/www/html/kasa/.  also dbconnect.php and b2*.png
    I set all of my devices to have static IP's in my router stating at 192.168.0.101
    in /etc/hosts:  192.168.0.101 kasa.Front_Door
    then http(s)://[server]/kasa - and start debugging because nothing ever works right out of the box ...

Is is pretty? Eh... it's functional.
