<?php
function contentTypes(): array {
 return [
 'service'=>['page'=>'services.php','label'=>'Services','single'=>'service','title'=>'Service name','summary'=>'Short description','body'=>'Service details','image'=>'Service image'],
 'project'=>['page'=>'projects.php','label'=>'Projects','single'=>'project','title'=>'Project name','summary'=>'Project overview','body'=>'Project details','image'=>'Project image'],
 'blog'=>['page'=>'blog.php','label'=>'Blog','single'=>'post','title'=>'Post headline','summary'=>'Excerpt','body'=>'Article','image'=>'Featured image'],
 'team'=>['page'=>'team.php','label'=>'Team','single'=>'team member','title'=>'Full name','summary'=>'Bio (optional)','body'=>'Job title / designation','image'=>'Profile photo'],
 'faq'=>['page'=>'faqs.php','label'=>'FAQs','single'=>'question','title'=>'Question','body'=>'Answer','image'=>'']
 ];
}
