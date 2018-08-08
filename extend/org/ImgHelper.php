<?php
namespace org;
/**
 * 图片上传辅助类
 * @author chenwei
 * @package common
 */

class ImgHelper
{

    /**
     * 最大上传大小，10Ｍ
     * @var integer
     */
    public static $max_size = 10485760;

    /**
     * 允许上传的文件mime类型
     * @var array
     */
    public static $mime_types = array(
        'image/jpg',
        'image/jpeg',
        'image/png',
        'image/pjpeg',
        'image/gif',
        'image/x-png',
        'application/octet-stream'
    );

    /**
     * mime类型与文件后缀对应
     * @var array
     */
    public static $mime_ext_map = array(
        'image/gif' => "gif",
        'image/jpg' => "jpg",
        'image/jpeg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/x-png' => "png",
        'image/png' => 'png',
    );

    /**
     * 下载url地址的图片，并返回类型
     *
     * 利用返回的data $img = imagecreatefromstring($datainfo['data']);
     * $img_width = imagesx($img);   $img_height = imagesy($img);
     * @param  string $img_url 图片url地址
     * @return array          数组，data字段为图片文件数据，type字段为文件类型
     */
    public static function downloadUrlImageFile($img_url)
    {
        $ch = curl_init($img_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        return array('data' => $data, 'type' => $info);
    }

    /**
     * 根据图片文件mime类型获取对应的文件后缀名
     * @param  string $mime mime类型
     * @return string       后缀
     */
    public static function getExtByMimeType($mime)
    {
        if (isset(self::$mime_ext_map[$mime])) {
            return self::$mime_ext_map[$mime];
        } else {
            return 'jpg';
        }
    }

    /**
     * 创建目录
     * @param  string $dir 目录路径
     * @return bool
     */
    public static function mkDirs($dir)
    {
        if (!is_dir($dir)) {
            if (!self::mkDirs(dirname($dir))) {
                return false;
            }
            if (!mkdir($dir, 0777)) {
                return false;
            }
            chmod($dir, 0777);
        }
        return true;
    }

    /**
     * 获取网络地址文件的大小(多少Ｍ那种大小)与类型
     * @param  string $url
     * @return array     数组，size字段为大小，type字段为类型。没获取到返回null
     */
    public static function getUrlFileSizeAndType($url)
    {
        $result = array();
        $url = parse_url($url);
        if ($fp = @fsockopen($url['host'], empty($url['port']) ? 80 : $url['port'], $error)) {
            fputs($fp, "GET " . (empty($url['path']) ? '/' : $url['path']) . " HTTP/1.1\r\n");
            fputs($fp, "Host:$url[host]\r\n\r\n");
            while (!feof($fp)) {
                $tmp = fgets($fp);
                if (trim($tmp) == '') {
                    break;
                } else {
                    if (preg_match('/Content-Length:(.*)/si', $tmp, $arr)) {
                        $result['size'] = trim($arr[1]);
                        if ($result['size'] <= 43) {
                            return null;
                        }
                    } else {
                        if (preg_match('/Content-Type:(.*)/si', $tmp, $arr)) {
                            $result['type'] = trim($arr[1]);
                        }
                    }
                }
                if (count($result) == 2) {
                    return $result;
                }
            }
            return null;
        } else {
            return null;
        }
    }


    /**
     * 下载图片到本地服务器
     * @param  string $img_url 图片地址
     * @param  string $upload_path 本地目录 如：upload/user/108/
     * @return string          upload/user/108/1442625710.jpg
     */
    public static function downImg($img_url, $upload_path)
    {
        if (empty($img_url)) {
            return '';
        }
        self::mkDirs($upload_path);

        $img_data = self::downloadUrlImageFile($img_url);
        if (empty($img_data['data'])) {
            return '';
        }

        $file_ext = self::getExtByMimeType($img_data['type']);
        $file_name = time() . '.' . $file_ext;

        $file_path = $upload_path . $file_name;

        $fp = fopen($file_path, 'w');
        fwrite($fp, $img_data['data']);
        fclose($fp);
        return $file_name;
    }

    /**
     * 上传文件
     *
     * @param $files
     * @param $path
     * @param int $maxsize
     * @param array $allowtype
     * @return array
     */
    public static function uploadImg($file, $path, $maxsize = 10485760)
    {
        $tmpname = $file['tmp_name'];
        $size = $file['size'];
        $mime_type = $file['type'];
        $stuff = pathinfo($file['name']);
        //检测当前上传文件大小是否合法。
        if ($size > $maxsize) {
            return array(false, 'size can not big than '. $maxsize);
        }

        $abs_path = $path;
        self::mkDirs($abs_path);

        $file_ext = self::getExtByMimeType($mime_type);
//        if(!$file_ext){
//            return array(false, 'img mime type is not in rules : '. $mime_type);
//        }
        $file_name = time().$stuff['filename'] . '.' .$file_ext;
        $file_path = $abs_path . $file_name;
        if (!move_uploaded_file($tmpname, $file_path)) {
            return array(false, 'move file fail');
        }

        return array(true, $path . $file_name);
    }
}