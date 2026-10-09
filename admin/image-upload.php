<?php
// Called only after admin authentication and CSRF validation in entries.php.
function saveContentImage(?array $file): string {
 if(!$file || ($file['error']??UPLOAD_ERR_NO_FILE)===UPLOAD_ERR_NO_FILE)return '';
 if(!is_int($file['error']??null)||!is_string($file['tmp_name']??null))throw new RuntimeException('Invalid upload.');
 if($file['error']!==UPLOAD_ERR_OK)throw new RuntimeException('Upload failed. Check PHP upload_max_filesize and post_max_size.');
 $tmp=$file['tmp_name'];
 if(!is_uploaded_file($tmp))throw new RuntimeException('Invalid uploaded file.');
 $size=filesize($tmp);if(!$size||$size>5*1024*1024)throw new RuntimeException('Image must be up to 5 MB.');
 if(!class_exists('finfo')||!function_exists('imagecreatefromstring'))throw new RuntimeException('Enable PHP fileinfo and GD extensions to upload images.');
 $mime=(new finfo(FILEINFO_MIME_TYPE))->file($tmp);$allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
 if(!isset($allowed[$mime]))throw new RuntimeException('Only JPG, PNG and WebP images are allowed.');
 $info=@getimagesize($tmp);
 if(!$info||($info['mime']??'')!==$mime)throw new RuntimeException('This file is not a valid image.');
 if($info[0]>6000||$info[1]>6000||$info[0]*$info[1]>16000000)throw new RuntimeException('Image exceeds 6,000 pixels per side or 16 megapixels.');
 $img=@imagecreatefromstring(file_get_contents($tmp));if(!$img)throw new RuntimeException('Unable to decode image.');
 $dir=__DIR__.'/../assets/img/uploads';
 if(!is_dir($dir)||!is_writable($dir)){imagedestroy($img);throw new RuntimeException('The assets/img/uploads folder must exist and be writable by Apache. See INSTALL-UPLOAD.md.');}
 $ext=$allowed[$mime];$name=bin2hex(random_bytes(16)).'.'.$ext;$dest=$dir.'/'.$name;
 try {
  imagealphablending($img,false);imagesavealpha($img,true);
  if($ext==='webp'&&!function_exists('imagewebp'))throw new RuntimeException('WebP is unavailable in this PHP installation. Use JPG or PNG.');
  $ok=$ext==='jpg'?imagejpeg($img,$dest,90):($ext==='png'?imagepng($img,$dest,6):imagewebp($img,$dest,90));
  if(!$ok)throw new RuntimeException('Unable to write image. Check upload folder permissions.');
  @chmod($dest,0644);
 }catch(Throwable $ex){@unlink($dest);throw $ex;}finally{imagedestroy($img);}
 return 'assets/img/uploads/'.$name;
}
