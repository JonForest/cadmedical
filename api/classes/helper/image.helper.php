<?php

/**
 * @author: Jonathan Hollingsworth
 * @description: Category Helper Class
 */
class imageHelper {
    /**
     * Resize an image
     *
     * @param string $filename
     * @param string $dest
     * @param int    $width
     * @param int    $height
     * @return bool
     * @throws Exception
     */
    private function resize($filename, $dest, $width, $height)
    {
        ini_set('memory_limit', '200M'); // 100 megs

        $format = strtolower(substr(strrchr($filename, "."), 1));
        switch ($format) {
            case 'gif' :
                $type = "gif";
                $img  = imagecreatefromgif($filename);
                break;

            case 'png' :
                $type = "png";
                $img  = imagecreatefrompng($filename);
                break;

            case 'jpg' :
                $type = "jpg";
                $img  = imagecreatefromjpeg($filename);
                break;

            case 'jpeg' :
                $type = "jpg";
                $img  = imagecreatefromjpeg($filename);
                break;

            default :
                throw new Exception('Unsupported image type: ' . $format);
        }

        list($org_width, $org_height) = getimagesize($filename);
//        $xoffset = 0;
//        $yoffset = 0;

        // portrait image?
        if ($org_width < $org_height) {
            // H and W were set for landscape
            $tmp    = $height;
            $height = $width;
            $width  = $tmp;
        }

        //Get the ratio
        $xtmp       = $org_width / $width;
        $new_width  = $width;
        $new_height = $org_height / $xtmp;

        //If the resizing causes the height to be too large, then resize again based on the supplied $height
        if ($new_height > $height) {
            $ytmp       = $org_height / $height;
            $new_height = $height;
            $new_width  = $org_width / $ytmp;
        }

        //Tidy up
        $width  = round($new_width);
        $height = round($new_height);

        $img_n = imagecreatetruecolor($width, $height);
        imagecopyresampled($img_n, $img, 0, 0, 0, 0, $width, $height, $org_width, $org_height);

        if ($type == "gif") {
            imagegif($img_n, $dest);
        } elseif ($type == "jpg") {
            imagejpeg($img_n, $dest);
        } elseif ($type == "png") {
            imagepng($img_n, $dest);
        } elseif ($type == "bmp") {
            imagewbmp($img_n, $dest);
        }

        return true;
    }

    public function createThumbnail($filename, $newFilename)
    {
        $this->resize($filename, $newFilename, 100, 100);
    }

    public function createCommon($filename, $newFilename)
    {
        $this->resize($filename, $newFilename, 400, 400);
    }




    public function saveCaption(mysqli $con, $captionInfo)
    {
        $sql = "UPDATE images SET caption=?, imageTitle=? WHERE imageId=?";
        $stmt = $con->prepare($sql);

        //Make safe
        $captionInfo->caption = strip_tags($captionInfo->caption);
        $captionInfo->imageTitle = strip_tags($captionInfo->imageTitle);

        $stmt->bind_param("ssi", $captionInfo->caption, $captionInfo->imageTitle, $captionInfo->imageId);
        $stmt->execute();
        $stmt->close();

        $retArray = array('success' => true);
        return $retArray;
    }

    public function deleteImage($imageId)
    {
        if (!isset($imageId)) {
            throw new HttpInvalidParamException("Image Id has not been passed");
        }

        $con = getConnection();
        $sql = "UPDATE images SET status=3 WHERE imageId=?";
        $stmt = $con->prepare($sql);

        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        $stmt->close();

        $retArray = array('success' => true);
        return $retArray;
    }


}

