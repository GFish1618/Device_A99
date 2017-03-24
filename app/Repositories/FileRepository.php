<?php

namespace App\Repositories;

class FileRepository
{

    static $file_path = 'categories.txt';
    //protected $file = fopen('categories.txt', 'r+');

    static function readLine($n)
    {
        $file = fopen('categories.txt', 'r');
        $line = 0;
        while ($line<=$n)
        {
            $line++;
            $category = fgets($file);
        }
        fclose($file);
        return $category;
    }

    static function length()
    {
    	$file = fopen('categories.txt', 'r');
        $line = 0;
        $category ='_';
        while ($category!='')
        {
            $line++;
            $category = fgets($file);
        }
        fclose($file);
        return $line;
    }

    static function makeArray()
    {
    	$file = fopen('categories.txt', 'r');
    	$array = Array(null => 'No category');
        $line = 0;
        $category ='_';
        while ($category!='')
        {
            $line++;
            $category = fgets($file);
            if ($category!=''){ $array += Array( $category => $category); }
        }
        fclose($file);
        return $array;
    }

    static function addCategory(string $new_cat)
    {
    	$file = fopen($file_path, 'a');
        fseek($file, 0, SEEK_END);
        fputs($file, "\n".$new_cat);
        fclose($file);
    }
}