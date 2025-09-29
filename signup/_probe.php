<?php
$cmd='/usr/bin/sendmail.postfix -t -i -f signup@tilde.club';
$ds=[0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']];
$p=proc_open($cmd,$ds,$pipes);
fwrite($pipes[0],"To: root@tilde.club\r\nSubject: proc_open test\r\n\r\nhi\r\n"); fclose($pipes[0]);
$stdout=stream_get_contents($pipes[1]); fclose($pipes[1]);
$stderr=stream_get_contents($pipes[2]); fclose($pipes[2]);
$rc=proc_close($p);
var_dump(['rc'=>$rc,'stderr'=>$stderr,'sendmail_path'=>ini_get('sendmail_path')]);
