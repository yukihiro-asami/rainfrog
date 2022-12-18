<?php
namespace castle;
return function (array &$vals) : string
{
    if ($vals['castle_environment_value'] === FRG_ENV_DEVELOPMENT OR $vals['castle_environment_value'] === FRG_ENV_TEST)
    {
        store_body(<<<EOF
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
    <h1>sending data</h1>
    <table>
        <tr class="h"><th>key</th><th>value</th></tr>
        <tr><td class="e"><input id="key0" style="width: 350px"></td><td class="v"><input id="value0" style="width: 562px"></td></tr>
        <tr><td class="e"><input id="key1" style="width: 350px"></td><td class="v"><input id="value1" style="width: 562px"></td></tr>
        <tr><td class="e"><input id="key2" style="width: 350px"></td><td class="v"><input id="value2" style="width: 562px"></td></tr>
        <tr><td class="e"><input id="key3" style="width: 350px"></td><td class="v"><input id="value3" style="width: 562px"></td></tr>
        <tr><td class="e"><input id="key4" style="width: 350px"></td><td class="v"><input id="value4" style="width: 562px"></td></tr>
        <tr><td class="e"><input id="key5" style="width: 350px"></td><td class="v"><input id="value5" style="width: 562px"></td></tr>
        <tr><td class="e"><input id="key6" style="width: 350px"></td><td class="v"><input id="value6" style="width: 562px"></td></tr>
        <tr><td class="e">media_type</td>
            <td class="v">
                <input type="radio" name="content_type" value="form" checked>urlencoded form
                <input type="radio" name="content_type" value="json">json
            </td>
        </tr>
        <tr><td class="e">path</td><td class="v"><input id="path" style="width: 562px"></td></tr>
        <tr><td class="e">method</td>
            <td class="v">
                <input type="radio" name="method" value="POST" checked>POST
                <input type="radio" name="method" value="GET">GET
                <input type="radio" name="method" value="PUT">PUT
                <input type="radio" name="method" value="DELETE">DELETE
                <button type="button" onclick="send()">send</button>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
<script>
function send(){
    let params = {};
    [...Array(7)].map((_, i) => i).forEach(
        index => {
            const key = _value_by_id('key' + index);
            const value = _value_by_id('value' + index);
            if (key !== '')
            {
                 params[key] = value;
            }
        }
    )
    const content_type = _select_by_name_and_get_value('content_type');
    let sending_data;
    console.log(params);
    let content_type_header = 'application/x-www-form-urlencoded';
    if (_select_by_name_and_get_value('content_type') === 'form')
    {
        console.log('form');
        sending_data = _parse_form_urlencoded(params);
    } else {
        sending_data = JSON.stringify(params);
        content_type_header = 'application/json;charset=UTF-8';
    }
    let client = new XMLHttpRequest();

    let query = '';
    if (_select_by_name_and_get_value('method') === 'GET' && content_type === 'form')
    {
        content_type_header = 'application/x-www-form-urlencoded';
        query = '?' + sending_data;
    }
    client.open(_select_by_name_and_get_value('method'), _value_by_id('path') + query);
    client.setRequestHeader('Content-Type', content_type_header);
    client.addEventListener("load", function(){
	console.log(this.response);
}, false);
    if (_select_by_name_and_get_value('method') === 'GET')
    {
        client.send();
    } else {
        client.send(sending_data);
    }
    
}

function _value_by_id(id)
{
    return document.getElementById(id).value;
}

function _parse_form_urlencoded(key_value)
{
    let params_array = [];
    Object.keys(key_value).forEach(
        (key)  => {
             params_array.push([key, encodeURIComponent(key_value[key])].join('='))
        }
    );
    return  params_array.join('&');
}

function _select_by_name_and_get_value(name)
{
    let value;
    document.getElementsByName(name).forEach(
        element => {
            if (element.checked === true)
            {
                value = element.value;
            }
        } 
    );
    return value;
}

</script>
EOF);
    } else {
        set_status(FRG_HTTP_STATUS_CODE_404_NOT_FOUND);
        store_body('<html lang="ja"><head><title>not found</title></head><body>not found</body></html>');
    }
    return 'success';
};