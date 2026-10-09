document.querySelector('.menu-toggle')?.addEventListener('click',function(){const n=document.getElementById('navigation');this.setAttribute('aria-expanded',String(n.classList.toggle('open')));});
document.querySelectorAll('[data-confirm]').forEach(f=>f.addEventListener('submit',e=>{if(!confirm(f.dataset.confirm))e.preventDefault();}));
