<?php
try
{
  // Saving every page of a TIFF separately as a JPG thumbnail
  $images = new Imagick("testing.tif");
  foreach($images as $i=>$image) {
    // Providing 0 forces thumbnail Image to maintain aspect ratio
    $image->thumbnailImage(768,0);
    $image->writeImage("page".$i.".jpg");
    echo "<img src='page$i.jpg' alt='images' ></img>";
  }
  $images->clear();
}
catch(Exception $e)
{
  echo $e->getMessage();
}
?>