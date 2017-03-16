<?php
$srcs = [
	realpath(__DIR__ . '/../skeleton'),
	realpath(__DIR__ . '/../src'),
	realpath(__DIR__ . '/../templates'),
];

$templates = [
	realpath(__DIR__ . '/../templates')
];

$libs = [
	// LiteObject
	realpath(__DIR__ . '/../vendor/oktopost/objection/src'),
	
	// Skeleton
	realpath(__DIR__ . '/../vendor/oktopost/skeleton/src'),
	
	// Squid
	realpath(__DIR__ . '/../vendor/oktopost/squid/skeleton'),
	realpath(__DIR__ . '/../vendor/oktopost/squid/src'),
];

$buildRoot = realpath(__DIR__ . '/build');
$fileName = 'squid';
$buildFile = "$buildRoot/$fileName.phar";
$finalFile = "$buildRoot/$fileName";


if (file_exists($buildFile))
	unlink($buildFile);
if (file_exists($finalFile))
	unlink($finalFile);

$p = new Phar($buildFile, 0, $fileName);
$p->startBuffering();

$p->setStub(
	"#!/usr/bin/env php\n" . 
	$p->createDefaultStub('index.php')
);

foreach ($srcs as $src)
{
	$p->buildFromDirectory($src, '$(.*)\.php$');
}

foreach ($templates as $template)
{
	$p->buildFromDirectory($template, '$(.*)\.template$');
}

foreach ($libs as $lib)
{
	$p->buildFromDirectory($lib, '$(.*)\.php$');
}

$p['index.php'] = file_get_contents(realpath(__DIR__ . '/index.php'));

$p->compressFiles(Phar::GZ);
$p->stopBuffering();

copy($buildFile, $finalFile);
unlink($buildFile);