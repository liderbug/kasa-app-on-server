#!/bin/bash

# the file goes in /usr/local/bin/fake.bash
# this script updates the table status because "select from status"
# is much faster the "kasa get state"

kup="--username my@tplinkemail.com --password 12345678" #ya right...
sqlup="-u [me] --password=[nuther-secret]"

  if [[ "$2" = "1" ]] # kasa requires the word on or off
  then
    oo="on"
  else
    oo="off"
  fi
  # device state = on(True) or off(False)
  case $2 in
    'stat') ret=`/usr/local/bin/kasa --host $1 $kup state | grep State | grep 'False' `
            oo=`echo $?`
            mysql $sqlup kasa -e "update status set oo = $oo where id = '$1';" ;;
         *) ret=`/usr/local/bin/kasa --host $1 $kup $oo`
            mysql $sqlup kasa -e "update status set oo = $2 where id = '$1';" ;;
  esac

