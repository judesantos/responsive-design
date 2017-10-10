<?php


$file = "./assets/files/Entire_NAI_Leasing_Brochure.pdf";

if (file_exists($file))
{
  header('Content-disposition: attachment; filename="'.$file.'"');
  readfile($file);
}
