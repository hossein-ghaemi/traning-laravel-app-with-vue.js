<?php

namespace App\Http\Controllers;

use App\Models\FileInfo;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Symfony\Component\Console\Input\Input;

class FileController extends Controller
{


    public static $extensions = [
        'image' => ['jpeg', 'jpg', 'png', 'webp', 'gif'],
        'doc' => ['pdf', 'doc', 'docx', 'rtf', 'txt', 'xls', 'xlsx', 'html', 'htm'],
        'video' => ['mp4', 'avi', 'webp', 'webm', 'mkv', 'wmv', 'mpg', 'flv'],
        'audio' => ['mp3', 'wav', 'ogg', 'mp2', 'mpeg'],
        'zip' => ['zip', 'rar', 'tar'],
    ];
    public static $max_file_size = 500 * 1024 * 1024;

    public function uploader()
    {
        return view('upload', [
            'status' => false
        ]);
    }

    public function upload(Request $request, $owner, $table_relation, $relation_id, $path_save, $type = 'all', $key = 'file', $is_fake = false)
    {

        $file = $request->file($key);

        if ($file != null) {

            $file_name = $file->getClientOriginalName();
            $new_name = rand(100000, 999999) . $file_name;
            $path = $path_save . $new_name;
            $explode_path = explode(".", $path);
            $file_info = pathinfo($path);
            $file_ext = $file_info['extension'];
            $file_size = $file->getSize();

            $errors = '';

            if ($type != 'all') $extensions = self::$extensions[$type];
            if ($type == 'all') {
                $extensions = array_merge(
                    self::$extensions['image'],
                    self::$extensions['doc'],
                    self::$extensions['video'],
                    self::$extensions['audio'],
                    self::$extensions['zip']);
            }

            // doc+image+zip
            if (strstr($type, '+')) {
                $extensions = [];
                $types = explode('+', $type);
                foreach ($types as $addtype) {
                    $extensions = array_merge($extensions, self::$extensions[trim(strtolower($addtype))]);
                }
            }

            if (in_array($file_ext, $extensions) === false) {
                return 'File extension in not allowed, please choose a valid file.';
            }

            if ($file_size > self::$max_file_size) {
                return 'File size must be less than ' . floor(self::$max_file_size / (1024 * 1024)) . ' MB';
            }


            $arr = [
                'file_name' => $file_name,
                'file_format' => $explode_path[sizeof($explode_path) - 1],
                'file_path' => $path,
                'table_relation' => $table_relation,
                'relation_id' => $relation_id,
                'owner' => $owner,
                'alt' => '',
                'description' => '',
                'title' => '',
            ];



            if (in_array($file_ext, self::$extensions['image'])) {
                $arr['width'] = getimagesize($file)[0];
                $arr['height'] = getimagesize($file)[1];
            }

            $file_data = File::create($arr);
            if ($file_data) {
                if (!$is_fake) {
                    $file->move($path_save, $new_name);
                }else{
                    rename($file->getPathname(), $path);
                }

                $arr_info = [
                    'id' => $file_data->id,
                    'alt' => '',
                    'description' => '',
                    'title' => '',
                ];

                FileInfo::create($arr_info);

                return $file_data->id;
            }else{
                return '';
            }

        } else {
            return '';
        }

    }


    public function createUploadedFileFrom($blobData, $key, $type = 'ogg', $mim_type = 'audio/ogg') {
        // Specify the directory to save temp files
        $uploadDir = sys_get_temp_dir(); // You can change this to your desired directory

        // Generate a unique file name
        $tempFilePath = tempnam($uploadDir, $key);
//        $tempFileSep = explode(DIRECTORY_SEPARATOR, $tempFilePath);
//        $tempFileName = end($tempFileSep);

        // Write the blob data to the temp file
        file_put_contents($tempFilePath, $blobData);

        // Create an instance of UploadedFile
        $uploadedFile = UploadedFile::createFromBase(
            new \Symfony\Component\HttpFoundation\File\UploadedFile(
                $tempFilePath, // Path to temp file
                $key.'.'.$type, // Original file name
                $mim_type, // Mime type
                null, // Error code
                true // Test mode, set to true to prevent file from being moved
            )
        );

        $request = new Request();
        // Add uploaded file to request
        $request->files->set($key, $uploadedFile);

        return $request;
    }


}
