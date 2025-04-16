<?php
// Path to the rendered HTML file
$html = @file_get_contents(__DIR__ . "/rendered_bandcamp.html");
if (!$html) {
    echo "❌ Failed to read rendered output.\n";
    exit(1);
}

// Load DOM
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$xpath = new DOMXPath($doc);

// Find album containers
$albums = [];
$seen = [];

// Iterate through anchor tags inside album grid
foreach ($xpath->query('//ol[contains(@class,"music-grid")]/li//a[contains(@href,"/album/")]') as $a) {
    $url = $a->getAttribute('href');
    $img = $xpath->query('.//img', $a)->item(0);
    $text = trim($a->textContent);

    // Normalize data
    $url = strpos($url, 'https://') === 0 ? $url : "https://antsyrecords.bandcamp.com" . $url;
    $thumbnail = $img ? $img->getAttribute('src') : null;
    $thumbnail = $thumbnail && strpos($thumbnail, 'http') === false ? "https://antsyrecords.bandcamp.com/" . ltrim($thumbnail, './') : $thumbnail;

    // Cleanup duplicates and empty entries
    if (isset($seen[$url])) continue;
    $seen[$url] = true;

    // Try splitting artist from title
    $parts = preg_split('/\s{2,}/', $text);
    $title = $parts[0] ?? $text;
    $artist = $parts[1] ?? '';

    $albums[] = [
        'title' => trim($title),
        'artist' => trim($artist),
        'url' => $url,
        'thumbnail' => $thumbnail
    ];
}

// Final JSON output
file_put_contents(__DIR__ . "/catalog.json", json_encode([
    'catalog' => $albums
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "✔ Saved catalog: " . count($albums) . " albums\n";
