<?php

namespace Hashbangcode\Composerexample\Utilities;

class Url
{
protected $rawUrl;
protected string $scheme;
protected string $host;

protected string $path;
protected string $query;

public function __construct(string $url)
{
$url = trim($url);
$this->rawUrl = $url;
$this->scheme = parse_url($url, PHP_URL_SCHEME) ?: '';
$this->host = parse_url($url, PHP_URL_HOST) ?: '';
$this->path = parse_url($url, PHP_URL_PATH) ?: '';
$this->query = parse_url($url, PHP_URL_QUERY) ?: '';
}

public function getRawUrl(): string
{
return $this->rawUrl;
}

public function getHost()
{
return $this->host;
}

public function getPath(): string
{
return $this->path;
}

public function getScheme(): string
{
return $this->scheme;
}

public function getQuery(): string{
return $this->query;}
}