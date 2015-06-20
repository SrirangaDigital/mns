#!/bin/sh

host="localhost"
db="mns"
usr="root"
pwd="mysql"

echo "DROP DATABASE IF EXISTS mns; CREATE DATABASE mns;" | /usr/bin/mysql -uroot -pmysql

perl author_blb.pl $host $db $usr $pwd
perl author_bulletin.pl $host $db $usr $pwd

perl feat_blb.pl $host $db $usr $pwd
perl feat_bulletin.pl $host $db $usr $pwd

perl articles_blb.pl $host $db $usr $pwd
perl articles_bulletin.pl $host $db $usr $pwd

perl ocr_blb.pl $host $db $usr $pwd
perl ocr_bulletin.pl $host $db $usr $pwd

perl searchtable_blb.pl $host $db $usr $pwd
perl searchtable_bulletin.pl $host $db $usr $pwd

echo "create fulltext index text_index_blb on searchtable_blb (text);" | /usr/bin/mysql -uroot -pmysql mns
echo "create fulltext index text_index_bulletin on searchtable_bulletin (text);" | /usr/bin/mysql -uroot -pmysql mns
