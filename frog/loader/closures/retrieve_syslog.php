<?php
namespace castle;
return function (array &$vals) : string
{
    $log_json = file_get_contents($vals['syslog_dir'] . $vals['parsed_query_string']['syslog_id'] . '.json');
    $log_json_decoded = json_decode($log_json, true);
    echo <<<EOF
<html lang="ja"><head>
<style>
body {background-color: #fff; color: #222; font-family: sans-serif;}
pre {margin: 0; font-family: monospace;}
a:link {color: #009; text-decoration: none; background-color: #fff;}
a:hover {text-decoration: underline;}
table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
.center {text-align: center;}
.center table {margin: 1em auto; text-align: left;}
.center th {text-align: center !important;}
td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
th {position: sticky; top: 0; background: inherit;}
h1 {font-size: 125%;}
.p {text-align: left;}
.e {background-color: #e0eeff; width: 300px; font-weight: bold;}
.h {background-color: #95bff3; font-weight: bold;}
.v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
.v i {color: #999;}
img {float: right; border: 0;}
hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
</style>
<title></title><meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE" /></head>
<body>
<div class="center">
<h1>summary</h1>
<table>
<tr class="h"><th>_SERVER value</th><th></th><tr>
<tr><td class="e">syslog_id</td><td class="v">{$log_json_decoded['syslog_id']}</td><tr>
</table>
</div>
EOF;
    /*
    foreach ($log_json_decoded as $key => $data)
    {
    }
    */
    return 'success';
};