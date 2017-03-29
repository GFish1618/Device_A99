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
            $category = substr($category, 0, -1);
            if ($category!=''){ $array += Array( $category => $category); }

        }
        fclose($file);
        return $array;
    }

    static function addCategory($new_cat)
    {
    	$file = fopen('categories.txt', 'a');
        fseek($file, 0, SEEK_END);
        fputs($file, "\n".$new_cat);
        fclose($file);
    }

    static function deleteCategory($del_cat)
    {
    	$file = fopen('categories.txt', 'a');
    	$contents = file_get_contents('categories.txt');
		$contents = str_replace($del_cat."\n", '', $contents);
		$contents = str_replace("\n".$del_cat, '', $contents);
		file_put_contents('categories.txt', $contents);
        fclose($file);
    }

}