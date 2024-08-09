---
categories: [www]
comment_count: 1
date: 2016-02-25T23:14:42-05:00
date_gmt: 2016-02-26T04:14:42+00:00
guid: 'https://tobymackenzie.wordpress.com/?p=976'
id: 976
modified: 2016-04-04T21:27:24-05:00
modified_gmt: 2016-04-05T02:27:24+00:00
name: check-request-compression-savings
tags: [compression, curl, gzip, mod_deflate, savings, script]
---

Check request compression savings
=================================

Gzip compression is almost universally recommended as a basic step to improving site performance.  It basically uses a little bit of extra processing on the server and client to significantly reduce the transfer size of most text responses.  In Apache, this is done with `mod_deflate` (see [the H5BP config](https://github.com/h5bp/server-configs-apache/blob/master/src/web_performance/compression.conf) for an example of how to set this up).

A while back, I was setting gzip up on my server, and wanted a simple way to verify that it was working and check how much transfer was saved.  One simple way to verify it is working is with `curl` on the command line.  If you run `curl -I -H 'Accept-Encoding: gzip,deflate' example.com` and see the header `Content-Encoding: gzip`, compression is working.  To test the transfer savings, I wrote a simple script using [PHP's curl library](http://php.net/manual/en/book.curl.php).  It makes a request with and without the `Accept-Encoding: gzip,deflate` header, and compares the transfer data info provided by [`curl_getinfo()`](http://php.net/manual/en/function.curl-getinfo.php).

<!--more-->

The script is run from the command-line like `checkGzipCompression http://example.com`.  It looks like:

``` php
#!/usr/bin/env php
<?php
$url = $argv[1];

function runRequest($url, $opts = Array()){
	$opts = array_replace(Array(
		CURLOPT_HEADER=> true
		,CURLOPT_RETURNTRANSFER=> true
	), $opts);
	$ch = curl_init($url);
	curl_setopt_array($ch, $opts);
	$result = curl_exec($ch);
	$chInfo = curl_getinfo($ch);
	curl_close($ch);
	return $chInfo;
};

$uncompressedRequestData = runRequest($url);
$compressedRequestData = runRequest($url, Array(
	CURLOPT_HTTPHEADER=> Array(
		'Accept-Encoding: gzip,deflate'
	)
));
$data = Array(
	'uncompressed'=> Array(
		'label'=> 'Without Gzip'
		,'headerSize'=> $uncompressedRequestData['header_size']
		,'contentSize'=> $uncompressedRequestData['size_download']
	)
	,'compressed'=> Array(
		'label'=> 'With Gzip'
		,'headerSize'=> $compressedRequestData['header_size']
		,'contentSize'=> $compressedRequestData['size_download']
	)
);
foreach($data as $key=> $item){
	$data[$key]['total'] = $item['headerSize'] + $item['contentSize'];
}
$data['savings'] = Array(
	'label'=> 'Savings'
	,'headerSize'=> $data['uncompressed']['headerSize'] - $data['compressed']['headerSize']
	,'contentSize'=> $data['uncompressed']['contentSize'] - $data['compressed']['contentSize']
	,'total'=> $data['uncompressed']['total'] - $data['compressed']['total']
);
foreach(Array('headerSize', 'contentSize', 'total') as $field){
	$data['savings'][$field . 'Percentage'] = $data['savings'][$field] / $data['uncompressed'][$field] * 100;
}
$fields = Array(
	'Header Size'=> 'headerSize'
	,'Content Size'=> 'contentSize'
	,'Total Size'=> 'total'
);
foreach($data as $item){
	echo $item['label'] . ":\n";
	foreach($fields as $label=> $key){
		echo "\t{$label}: {$item[$key]} bytes";
		if(isset($item[$key . 'Percentage'])){
			echo " (" . number_format($item[$key . 'Percentage'], 3) . "%)\n";
		}else{
			echo "\n";
		}
	}
}
```

and produces output like:

```
Without Gzip:
	Header Size: 559 bytes
	Content Size: 8885 bytes
	Total Size: 9444 bytes
With Gzip:
	Header Size: 583 bytes
	Content Size: 3337 bytes
	Total Size: 3920 bytes
Savings:
	Header Size: -24 bytes (-4.293%)
	Content Size: 5548 bytes (62.442%)
	Total Size: 5524 bytes (58.492%)
```
