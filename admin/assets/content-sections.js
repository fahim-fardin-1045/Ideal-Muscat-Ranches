(()=>{
'use strict';
const input=document.getElementById('image-upload'),preview=document.getElementById('image-preview'),status=document.getElementById('image-upload-status');
if(!input||!preview||!status)return;
const originalPreview=preview.getAttribute('src')||'';
let chosen=null,source=null,url=null,previewURL=null,accepted=null,acceptedSource=null,pending=false,opener=null;
const edit=document.createElement('button');edit.type='button';edit.textContent='Crop selected image';edit.hidden=true;input.after(edit);
const style=document.createElement('style');style.textContent=`.im-crop{border:0;border-radius:14px;padding:18px;width:min(480px,92vw);max-height:88vh;overflow:auto;color:#29344b;background:#fff;box-shadow:0 20px 70px #0003}.im-crop::backdrop{background:#15203c99}.im-crop h2{margin:0 0 6px;font-size:19px}.im-crop p{font-size:12px;color:#68758a;margin:6px 0 10px}.im-crop canvas{display:block;width:auto;height:auto;max-width:100%;max-height:min(30vh,240px);margin:10px auto;background:#edf1f6;touch-action:none;cursor:grab;border-radius:6px;outline-offset:3px}.im-crop canvas:active{cursor:grabbing}.im-crop label{display:block;font-size:13px;font-weight:600;margin:9px 0 4px}.im-crop select,.im-crop input{width:100%;margin:0;padding:6px}.im-crop .crop-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:12px}.im-crop button{border:0;border-radius:7px;padding:8px 13px;cursor:pointer}.im-crop .crop-apply{background:#5d87ff;color:#fff}.im-crop .crop-error{color:#aa3333}`;document.head.append(style);
const dialog=document.createElement('dialog');dialog.className='im-crop';dialog.setAttribute('aria-labelledby','crop-heading');dialog.innerHTML=`<h2 id="crop-heading">Crop image</h2><p id="crop-help">Drag to reposition. Use the zoom slider to crop closer. Arrow keys also move the image.</p><label for="crop-ratio">Crop shape</label><select id="crop-ratio"><option value="original">Original shape</option><option value="1">Square (1:1)</option><option value="1.7777777778">Landscape (16:9)</option><option value="1.3333333333">Landscape (4:3)</option><option value="0.75">Portrait (3:4)</option></select><canvas width="560" height="315" tabindex="0" role="img" aria-label="Crop preview; use arrow keys to reposition" aria-describedby="crop-help"></canvas><label for="crop-zoom">Zoom</label><input id="crop-zoom" type="range" min="1" max="4" step="0.01" value="1"><p class="crop-error" role="alert"></p><div class="crop-actions"><button type="button" class="crop-reset">Reset</button><button type="button" class="crop-cancel">Cancel</button><button type="button" class="crop-apply">Apply crop</button></div>`;document.body.append(dialog);
const canvas=dialog.querySelector('canvas'),ctx=canvas.getContext('2d'),ratio=dialog.querySelector('select'),zoom=dialog.querySelector('input'),error=dialog.querySelector('.crop-error'),apply=dialog.querySelector('.crop-apply');
let scale=1,x=0,y=0,drag=null;
function clamp(){x=Math.min(0,Math.max(canvas.width-source.naturalWidth*scale,x));y=Math.min(0,Math.max(canvas.height-source.naturalHeight*scale,y));}
function draw(){clamp();ctx.clearRect(0,0,canvas.width,canvas.height);ctx.drawImage(source,x,y,source.naturalWidth*scale,source.naturalHeight*scale);}
function reset(){const r=ratio.value==='original'?source.naturalWidth/source.naturalHeight:Number(ratio.value);canvas.width=Math.round(Math.min(560,420*r));canvas.height=Math.round(canvas.width/r);zoom.value='1';scale=Math.max(canvas.width/source.naturalWidth,canvas.height/source.naturalHeight);x=(canvas.width-source.naturalWidth*scale)/2;y=(canvas.height-source.naturalHeight*scale)/2;draw();}
function restoreInput(){const dt=new DataTransfer();if(accepted)dt.items.add(accepted);input.files=dt.files;}
function cancel(){if(pending){restoreInput();chosen=accepted;source=acceptedSource;pending=false;}dialog.close();}
function open(){if(!source)return;opener=document.activeElement;error.textContent='';reset();dialog.showModal();}
function setPreview(f){if(previewURL)URL.revokeObjectURL(previewURL);previewURL=URL.createObjectURL(f);preview.src=previewURL;preview.style.display='block';edit.hidden=false;}
input.addEventListener('change',async()=>{
 const f=input.files[0];if(!f)return;
 if(!['image/jpeg','image/png','image/webp'].includes(f.type)||f.size>5*1024*1024){status.textContent='Choose a JPG, PNG or WebP up to 5 MB.';restoreInput();return;}
 if(typeof dialog.showModal!=='function'||typeof DataTransfer==='undefined'){status.textContent='Your browser does not support the crop editor. Please update your browser.';input.value='';return;}
 if(url)URL.revokeObjectURL(url);url=URL.createObjectURL(f);const img=new Image();
 try{await new Promise((resolve,reject)=>{img.onload=resolve;img.onerror=reject;img.src=url;});if(img.naturalWidth>6000||img.naturalHeight>6000||img.naturalWidth*img.naturalHeight>16000000)throw new Error('large');source=img;chosen=f;pending=true;ratio.value=location.pathname.endsWith('/team.php')?'1':'original';open();}
 catch(e){status.textContent='Cannot open image. Use a valid image up to 6,000 pixels per side and 16 megapixels.';restoreInput();}
});
edit.addEventListener('click',()=>{if(chosen)open();});
ratio.addEventListener('change',reset);dialog.querySelector('.crop-reset').addEventListener('click',reset);dialog.querySelector('.crop-cancel').addEventListener('click',cancel);dialog.addEventListener('cancel',e=>{e.preventDefault();cancel();});dialog.addEventListener('close',()=>opener?.focus());
zoom.addEventListener('input',()=>{const old=scale;scale=Math.max(canvas.width/source.naturalWidth,canvas.height/source.naturalHeight)*Number(zoom.value);x=canvas.width/2-(canvas.width/2-x)*scale/old;y=canvas.height/2-(canvas.height/2-y)*scale/old;draw();});
canvas.addEventListener('pointerdown',e=>{canvas.focus();canvas.setPointerCapture(e.pointerId);drag={x:e.clientX,y:e.clientY};});canvas.addEventListener('pointermove',e=>{if(!drag)return;const r=canvas.getBoundingClientRect();x+=(e.clientX-drag.x)*canvas.width/r.width;y+=(e.clientY-drag.y)*canvas.height/r.height;drag={x:e.clientX,y:e.clientY};draw();});for(const event of ['pointerup','pointercancel'])canvas.addEventListener(event,()=>drag=null);
canvas.addEventListener('keydown',e=>{const keys={ArrowLeft:[-10,0],ArrowRight:[10,0],ArrowUp:[0,-10],ArrowDown:[0,10]};if(keys[e.key]){e.preventDefault();x+=keys[e.key][0];y+=keys[e.key][1];draw();}});
apply.addEventListener('click',()=>{
 apply.disabled=true;error.textContent='';const out=document.createElement('canvas');const sw=canvas.width/scale,sh=canvas.height/scale,factor=Math.min(1,2000/Math.max(sw,sh));out.width=Math.max(1,Math.round(sw*factor));out.height=Math.max(1,Math.round(sh*factor));out.getContext('2d').drawImage(source,-x/scale,-y/scale,sw,sh,0,0,out.width,out.height);
 const mime=chosen.type==='image/png'?'image/png':'image/jpeg';out.toBlob(blob=>{try{if(!blob||blob.size>5*1024*1024)throw new Error('Crop is too large. Zoom in more or choose a smaller image.');const f=new File([blob],mime==='image/png'?'cropped-image.png':'cropped-image.jpg',{type:mime});const dt=new DataTransfer();dt.items.add(f);input.files=dt.files;accepted=f;acceptedSource=source;pending=false;setPreview(f);status.textContent=`Crop ready (${out.width} × ${out.height}). Click Save to upload.`;dialog.close();}catch(e){error.textContent=e.message;}finally{apply.disabled=false;}},mime,.92);
});
// Selecting a file never saves it until the normal content form is submitted.
input.form?.addEventListener('submit',e=>{if(dialog.open){e.preventDefault();error.textContent='Apply or cancel your crop first.';}});
window.addEventListener('pagehide',()=>{if(url)URL.revokeObjectURL(url);if(previewURL)URL.revokeObjectURL(previewURL);});
})();
