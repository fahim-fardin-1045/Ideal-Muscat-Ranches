<?php
require_once __DIR__.'/../includes/app.php';admin();require_once __DIR__.'/layout.php';require_once __DIR__.'/image-upload.php';require_once __DIR__.'/content-types.php';
$types=contentTypes();if(!isset($contentKind,$types[$contentKind])){http_response_code(404);exit('Section not found.');}
$kind=$contentKind;$type=$types[$kind];$error='';$id=(int)($_GET['id']??0);$editing=$id>0||isset($_GET['new']);
$item=['id'=>0,'kind'=>$kind,'title'=>'','summary'=>'','body'=>'','image'=>'','published'=>0,'sort_order'=>0];
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(empty($_POST)&&!empty($_SERVER['CONTENT_LENGTH'])){http_response_code(413);exit('Upload exceeds PHP request limit. Choose a smaller file.');}
 check();$id=(int)($_POST['id']??0);
}
if($id>0){$q=db()->prepare('SELECT * FROM entries WHERE id=? AND kind=?');$q->execute([$id,$kind]);$found=$q->fetch();if(!$found){http_response_code(404);top('Record not found');echo '<p>This record does not exist in this section.</p>';bottom();exit;}$item=$found;}
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(($_POST['action']??'')==='delete'){db()->prepare('DELETE FROM entries WHERE id=? AND kind=?')->execute([$id,$kind]);header('Location: '.$type['page'].'?deleted=1');exit;}
 $editing=true;
 foreach(['title','body'] as $field)$item[$field]=is_string($_POST[$field]??null)?trim($_POST[$field]):'';
 if(isset($type['summary']))$item['summary']=is_string($_POST['summary']??null)?trim($_POST['summary']):'';
 $item['published']=isset($_POST['published'])?1:0;
 $sort=filter_var($_POST['sort_order']??'0',FILTER_VALIDATE_INT,['options'=>['min_range'=>-1000000,'max_range'=>1000000]]);
 if($sort!==false)$item['sort_order']=$sort;
 $length=function(string $s):int{return preg_match_all('/./us',$s,$m)===false?strlen($s):count($m[0]);};
 if($item['title']===''||$length($item['title'])>200)$error=$type['title'].' is required (maximum 200 characters).';
 elseif(isset($type['summary'])&&$length($item['summary'])>1000)$error=$type['summary'].' must be at most 1,000 characters.';
 elseif($length($item['body'])>100000)$error=$type['body'].' must be at most 100,000 characters.';
 elseif($kind==='team'&&$length($item['body'])>200)$error='Job title must be at most 200 characters.';
 elseif($kind==='faq'&&$item['body']==='')$error='Please enter an answer.';
 elseif($sort===false)$error='Display order must be a whole number between -1,000,000 and 1,000,000.';
 if(!$error){$newUpload='';try{
  if($type['image']){$newUpload=saveContentImage($_FILES['image_upload']??null);if($newUpload)$item['image']=$newUpload;elseif(isset($_POST['remove_image']))$item['image']='';}
  if($id){$q=db()->prepare('UPDATE entries SET title=?,summary=?,body=?,image=?,published=?,sort_order=? WHERE id=? AND kind=?');$q->execute([$item['title'],$item['summary'],$item['body'],$item['image'],$item['published'],$item['sort_order'],$id,$kind]);}
  else{$q=db()->prepare('INSERT INTO entries(kind,title,summary,body,image,published,sort_order) VALUES(?,?,?,?,?,?,?)');$q->execute([$kind,$item['title'],$item['summary'],$item['body'],$item['image'],$item['published'],$item['sort_order']]);}
  header('Location: '.$type['page'].'?saved=1');exit;
 }catch(Throwable $ex){if($newUpload)@unlink(__DIR__.'/../'.$newUpload);error_log($ex->getMessage());$error=$ex instanceof RuntimeException&&!($ex instanceof PDOException)?$ex->getMessage():'Unable to save. Please try again.';}}
}
// Older FAQ entries may store their answer in summary. Only use it for display until saved.
if($kind==='faq'&&$_SERVER['REQUEST_METHOD']!=='POST'&&trim($item['body'])==='')$item['body']=$item['summary'];
top($type['label']);?><link rel="stylesheet" href="assets/content-sections.css"><p class="section-description">Manage <?=e(strtolower($type['label']))?> independently. Drafts stay hidden from your public website.</p>
<?php if($error):?><p class="content-notice error" role="alert"><?=e($error)?></p><?php endif;?><?php if(isset($_GET['saved'])):?><p class="content-notice" role="status">Saved successfully.</p><?php endif;?><?php if(isset($_GET['deleted'])):?><p class="content-notice" role="status">Deleted successfully.</p><?php endif;?>
<p><a class="btn-company" href="<?=e($type['page'])?>?new=1">+ Add <?=e($type['single'])?></a><?php if($editing):?> <a href="<?=e($type['page'])?>">Cancel / back to list</a><?php endif;?></p>
<?php if($editing):?><form method="post" enctype="multipart/form-data" class="content-editor"><?=token()?><input type="hidden" name="id" value="<?=$id?>">
<label for="field-title"><?=e($type['title'])?> *</label><input id="field-title" name="title" value="<?=e($item['title'])?>" maxlength="200" required>
<?php if($kind==='team'):?><label for="field-body"><?=e($type['body'])?></label><input id="field-body" name="body" value="<?=e($item['body'])?>" maxlength="200" placeholder="e.g. Operations Manager"><?php endif;?>
<?php if(isset($type['summary'])):?><label for="field-summary"><?=e($type['summary'])?></label><textarea id="field-summary" name="summary" maxlength="1000" rows="3"><?=e($item['summary'])?></textarea><?php endif;?>
<?php if($kind!=='team'):?><label for="field-body"><?=e($type['body'])?><?=$kind==='faq'?' *':''?></label><textarea id="field-body" name="body" maxlength="100000" rows="10" <?=$kind==='faq'?'required':''?>><?=e($item['body'])?></textarea><?php endif;?>
<?php if($type['image']):?><section class="upload-box"><label for="image-upload"><?=e($type['image'])?></label><input id="image-upload" type="file" name="image_upload" accept="image/jpeg,image/png,image/webp"><p>JPG, PNG or WebP up to 5 MB. Select a file, then save.</p><?php $preview=imagepath((string)$item['image']);?><img id="image-preview" <?=$preview?'src="../'.e($preview).'"':''?> alt="Image preview" style="max-width:240px;max-height:200px;<?=$preview?'':'display:none'?>"><p id="image-upload-status" role="status"></p><?php if($preview):?><label><input type="checkbox" name="remove_image"> Remove current image</label><?php endif;?></section><?php endif;?>
<label for="sort-order">Display order</label><input id="sort-order" type="number" name="sort_order" value="<?=e($item['sort_order'])?>" min="-1000000" max="1000000" required><p class="field-help">Lower numbers appear first.</p><label><input type="checkbox" name="published" <?=$item['published']?'checked':''?>> Published on website</label><button class="btn-company">Save <?=e($type['single'])?></button></form><?php endif;?>
<?php $q=db()->prepare('SELECT * FROM entries WHERE kind=? ORDER BY sort_order,id DESC');$q->execute([$kind]);$rows=$q->fetchAll();if(!$rows):?><div class="dashboard-card"><p>No <?=e(strtolower($type['label']))?> yet. Add your first <?=e($type['single'])?> above.</p></div><?php else:?><table><thead><tr><th><?=e($type['title'])?></th><?php if($kind==='team'):?><th>Job title</th><?php endif;?><th>Status</th><th>Order</th><th>Actions</th></tr></thead><tbody><?php foreach($rows as $r):?><tr><td><?=e($r['title'])?></td><?php if($kind==='team'):?><td><?=e($r['body'])?></td><?php endif;?><td><span class="status-badge <?=$r['published']?'published':'draft'?>"><?=$r['published']?'Published':'Draft'?></span></td><td><?=e($r['sort_order'])?></td><td><a href="<?=e($type['page'])?>?id=<?=$r['id']?>">Edit</a><form method="post" data-confirm="Delete this record?"><?=token()?><input type="hidden" name="id" value="<?=$r['id']?>"><button name="action" value="delete">Delete</button></form></td></tr><?php endforeach;?></tbody></table><?php endif;?><script src="assets/content-sections.js"></script><?php bottom();?>
