<?php
require "../../api/common/dbconnection.php";

$con = getConnection();
/** @var Product[] $products */
$products = array();
$sql = "select imagePath from images";
$stmt = $con->prepare($sql);
$stmt->execute();
$stmt->bind_result($imagePath);

$con2 = getConnection();

$filenames = array();

while ($stmt->fetch())
{
    $filenames[] = $imagePath;
}


$dir = new DirectoryIterator(dirname('../../images/thumbnail/dfdsfd'));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        if (!in_array($fileinfo->getFilename(), $filenames)) {
            var_dump($fileinfo->getFilename());
            unlink('../../images/thumbnail/' . $fileinfo->getFilename());
        }
    }
}
