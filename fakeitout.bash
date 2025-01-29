#!/bin/bash 

# this file goes in /usr/local/bin/fakeitout.bash
# ip101 stat/on/off
# beacause Apache won't run python we have to "fake it"

#+-------+-- fake --+------+-----+---------+----------------+
#| Field | Type     | Null | Key | Default | Extra          |
#+-------+----------+------+-----+---------+----------------+
#| id    | int(11)  | NO   | PRI | NULL    | auto_increment |
#| cmd   | char(32) | YES  |     | NULL    |                |
#| 192.168.0.101,1
#| 192.168.0.101,stat
#+-------+----------+------+-----+---------+----------------+

sqlup="-s -u [me] --password=[ooooo-secret]"

while [ 1 ] # there is a job in the table fake
do
  fake=`/usr/bin/mysql $sqlup kasa -e "select * from fake limit 1;"`
  if [[ ! -z $fake ]] # there is an on/off or status requests
  then
    id=`echo $fake | cut -f 1 -d ' '` # ip of device
    cmd=`echo $fake | cut -d' ' -f2`
    ip=`echo $cmd | cut -d',' -f1`
    cmd=`echo $cmd | cut -d',' -f2`
    case $cmd in
        'stat') /home/chuck/bin/fake.bash $ip $cmd & ;;
        *) /home/chuck/bin/fake.bash $ip $cmd & ;;
    esac
      /usr/bin/mysql $sqlup kasa -e "delete from fake where id = '$id';"
  else # so that the web page displays correctly
    list=`/usr/bin/mysql $sqlup kasa -e "select id from status where inuse = 1;"`
    for L in $list
    do
      fake.bash $L stat &
    done
    exit
  fi
done

