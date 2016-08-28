#!/usr/bin/env php
<?php

print "\e[033mWelcome to vcs_to_vcard script!!!\e[0m\n";

$vcfFile = readline(" > please specify file path to *.vcf file: ");

if (!is_readable($vcfFile)) {
    print "\e[031m file not exists\e[0m\n";
    exit(1);
}
$file = fopen($vcfFile, 'r');

$vcard = '';
$counter = 1;
while (!feof($file)) {
    $vcard .= fgets($file);
    if (strstr($vcard, 'END:VCARD')) {
        $vcardFile = dirname($vcfFile) . "/vcard_{$counter}.vcard";
        if (!is_writable($vcfFile)) {
            print "\e[031m unable to write VCARD file to {$vcardFile}\e[0m\n";
            exit(1);
        }
        file_put_contents($vcardFile, $vcard);
        $vcard = '';
        $counter++;
        print "\e[037m.\e[0m";
    }
}
$counter--;
print "\nDone. Converted \e[032m{$counter}\e[0m vcard files.\n";