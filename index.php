<?php
// Allowed domain
$allowedDomain = 'https://finallystream.pages.dev';

// Check the HTTP referer or origin
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
} else {
    die('Access denied: No referer.');
}

if ($referer !== parse_url($allowedDomain, PHP_URL_HOST)) {
    die('Access denied: Invalid referer.');
}

// Get the MPD path
$get = $_GET['get'];
$mpdUrl = 'https://linearjitp-playback.astro.com.my/dash-wv/linear/' . $get;

// Set HTTP headers
$mpdheads = [
  'http' => [
      'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36\r\n",
      'follow_location' => 1,
      'timeout' => 5
  ]
];

$context = stream_context_create($mpdheads);
$res = file_get_contents($mpdUrl, false, $context);

if ($res === false) {
    die('Error fetching MPD.');
}

// Output the MPD content
echo $res;
?>
