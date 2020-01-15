<?php
/**
 * Created by PhpStorm.
 * User: prog7
 * Date: 25.04.18
 * Time: 14:13
 */
namespace api\components\avatar;

use Yii;
use yii\base\Model;
class UploadAvatar extends Model
{

    public function avatar($str)
    {
        $base = $this->checkStr($str);
        if ($base) {
            return $base;
        } else {
            return $this->saveAvatarUrl($str);
        }

    }

    private function checkStr($data)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
//                throw new \Exception('invalid image type');
                return false;
            }
            $data = base64_decode($data);
            if ($data === false) {
                return false;
            } else {

                $filePath = tempnam("/tmp", 'UserSignInFile');
                $filePath = $filePath . "." .$type ;
                file_put_contents($filePath, $data);
                $file = Yii::$app->fileStorage->save($filePath);
                unlink($filePath);
                if (isset($file)) {
                    return $file;
                }
            }
        } else {
            return false;
        }
    }

    private function saveAvatarUrl($photo)
    {
        $filePath = tempnam("/tmp", 'UserSignInFile');
        $filePath = $filePath . "." . $this->getExtension($photo);
        file_put_contents($filePath, $this->getSslPage($photo));
        $file = Yii::$app->fileStorage->save($filePath);
        unlink($filePath);
        if (isset($file)) {
            return $file;
        } else {
            return false;
        }
    }

    public function getExtension($filename) {
        return substr(strrchr($filename, '.'), 1);
    }


    function getSslPage($url) {
        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        $output = curl_exec($ch);
        return $output;
    }
}