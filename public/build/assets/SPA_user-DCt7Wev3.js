import"./bootstrap-DG2U1ArM.js";var e=document.body,t=e.dataset.spaBase,n=new URLSearchParams(window.location.search),r=n.get(`page`)||e.dataset.spaInitial||`dashboard`,i={};n.forEach((e,t)=>{t!==`page`&&(i[t]=e)});var a=document.getElementById(`spa-content`);function o(){let e=document.querySelector(`.wrapper-materi`);if(!e)return;let t=Array.from(e.querySelectorAll(`.box-materi`));if(!t.length)return;function n(e){t.forEach(e=>e.classList.remove(`active`)),e.classList.add(`active`)}function r(t,n=!0){let r=t.offsetLeft+t.offsetWidth/2-e.clientWidth/2;n?e.scrollTo({left:r,behavior:`smooth`}):e.scrollLeft=r}function i(){let n=e.scrollLeft+e.clientWidth/2,r=null,i=1/0;return t.forEach(e=>{let t=e.offsetLeft+e.offsetWidth/2,a=Math.abs(n-t);a<i&&(i=a,r=e)}),r}let a=null;e.addEventListener(`scroll`,()=>{let e=i();e&&n(e),clearTimeout(a),a=setTimeout(()=>{let e=i();e&&(n(e),r(e,!0))},180)},{passive:!0}),t.forEach(e=>{e.addEventListener(`click`,t=>{e.classList.contains(`active`)||(t.preventDefault(),t.stopPropagation(),n(e),r(e,!0))})}),e._sliderCenterCard=r,e._sliderSetActive=n,e._sliderCards=t,requestAnimationFrame(()=>{requestAnimationFrame(()=>{setTimeout(()=>{let e=t[Math.floor(t.length/2)]??t[0];n(e),r(e,!1)},50)})})}function s(e){try{let t=new URL(e,location.origin),n=t.searchParams.get(`page`),r={};return t.searchParams.forEach((e,t)=>{t!==`page`&&(r[t]=e)}),{page:n,params:r}}catch{return{page:null,params:{}}}}function c(e){document.querySelectorAll(`.box-nav-bottom`).forEach(t=>{let n=t.querySelector(`.icon-nav-bottom`);n&&n.classList.toggle(`active`,t.dataset.page===e)}),document.querySelectorAll(`.neo-nav-link`).forEach(t=>{t.classList.toggle(`active`,t.dataset.spaPage===e)})}function l(e){e.querySelectorAll(`script`).forEach(e=>{let t=document.createElement(`script`);e.src?t.src=e.src:t.textContent=e.textContent,e.replaceWith(t)})}async function u(e,n={},r=!0){if(!t||!a)return;let i=`${t.replace(/\/$/,``)}/${encodeURIComponent(e)}`,s=new URLSearchParams(n).toString();s&&(i+=`?${s}`),a.style.opacity=`1`,a.innerHTML=`
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding: 4rem 1rem;">
            <svg class="animate-spin text-indigo-500" style="height:2rem; width:2rem; margin-bottom:1rem; animation: spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p style="font-size:0.875rem; color:#6b7280; font-weight:500;">Memuat data...</p>
            <style>
                @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                .animate-spin { animation: spin 1s linear infinite; }
            </style>
        </div>
    `;try{let t=await fetch(i,{headers:{"X-Requested-With":`XMLHttpRequest`,Accept:`text/html`},credentials:`same-origin`});if(!t.ok){a.innerHTML=`<p style="text-align:center;padding:2em;color:#ef4444;">Gagal memuat halaman.</p>`;return}let s=document.getElementById(`global-search-input`);s&&(s.value=``),window.__currentSearchHandler=null,a.innerHTML=await t.text(),l(a),window.scrollTo({top:0,behavior:`smooth`}),c(e);let u=document.getElementById(`navBar`);if(u&&(e===`account`?u.style.display=`none`:u.style.display=``),o(),r){let t=new URLSearchParams({page:e,...n});window.history.pushState({page:e,params:n},``,`?${t.toString()}`)}}catch{window.__lastFailedPage={page:e,params:n},a.innerHTML=`<p style="text-align:center;padding:2em;color:#ef4444;">Gagal memuat halaman.</p>`}finally{a.style.opacity=`1`}}window.loadPage=u;var d=!1,f=null;async function p(){let e=new AbortController,t=setTimeout(()=>e.abort(),5e3);try{return await fetch(`https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css`,{method:`HEAD`,mode:`no-cors`,cache:`no-store`,signal:e.signal}),clearTimeout(t),!0}catch{return clearTimeout(t),!1}}function m(){if(d)return;d=!0;let e=document.getElementById(`offline-overlay`);if(!e)return;e.classList.add(`active`),e.classList.remove(`reconnecting`),document.body.classList.add(`no-scroll`);let t=e.querySelector(`.offline-icon i`),n=e.querySelector(`.offline-status span:last-child`),r=e.querySelector(`.offline-title`);t&&(t.className=`bx bx-wifi-off`),n&&(n.textContent=`Offline`),r&&(r.textContent=`Tidak Ada Koneksi Internet`),g()}function h(){if(!d)return;let e=document.getElementById(`offline-overlay`);if(!e||!e.classList.contains(`active`))return;e.classList.add(`reconnecting`);let t=e.querySelector(`.offline-icon i`),n=e.querySelector(`.offline-status span:last-child`),r=e.querySelector(`.offline-title`);t&&(t.className=`bx bx-wifi`),n&&(n.textContent=`Online`),r&&(r.textContent=`Koneksi Terhubung Kembali!`),setTimeout(()=>{e.classList.remove(`active`),e.classList.remove(`reconnecting`),document.body.classList.remove(`no-scroll`),d=!1;let t=window.__lastFailedPage;t&&(u(t.page,t.params),window.__lastFailedPage=null)},1200),_()}function g(){_(),f=setInterval(async()=>{await p()&&h()},5e3)}function _(){f&&=(clearInterval(f),null)}window.__retryConnection=async function(){let e=document.getElementById(`offline-retry-btn`);e&&e.classList.add(`loading`);let t=await p();if(e&&e.classList.remove(`loading`),t)h();else{let e=document.querySelector(`.offline-icon`);e&&(e.style.animation=`none`,e.offsetHeight,e.style.animation=``)}},document.addEventListener(`DOMContentLoaded`,async()=>{let t=document.getElementById(`offline-overlay`);await p()?(t&&(t.classList.remove(`active`,`checking`,`reconnecting`),t.style.display=`none`,setTimeout(()=>{t.style.display=``},100)),d=!1,document.body.classList.remove(`no-scroll`)):(t&&t.classList.remove(`checking`),d=!0,document.body.classList.add(`no-scroll`),g()),u(r,i,!1),window.addEventListener(`popstate`,t=>{if(t.state&&t.state.page)u(t.state.page,t.state.params,!1);else{let t=new URLSearchParams(window.location.search),n=t.get(`page`)||e.dataset.spaInitial||`dashboard`,r={};t.forEach((e,t)=>{t!==`page`&&(r[t]=e)}),u(n,r,!1)}}),document.body.addEventListener(`click`,e=>{let t=e.target.closest(`[data-spa-page]`);if(t){e.preventDefault();let n=t.dataset.spaPage;n&&u(n);return}let n=e.target.closest(`.box-nav-bottom[data-page]`);if(n){e.preventDefault();let t=n.dataset.page;t&&u(t);return}let r=e.target.closest(`.link-spa`);if(r){e.preventDefault();let t=r.closest(`.box-materi`);if(t){let e=t.closest(`.wrapper-materi`);if(!t.classList.contains(`active`)){e&&e._sliderSetActive&&(e._sliderSetActive(t),e._sliderCenterCard(t,!0));return}}let{page:n,params:i}=s(r.getAttribute(`href`));n&&u(n,i);return}let i=e.target.closest(`.archive-btn`);if(i){e.preventDefault(),e.stopPropagation(),v(i);return}}),y(),window.addEventListener(`offline`,()=>{m()}),window.addEventListener(`online`,async()=>{await p()&&h()}),setInterval(async()=>{!await p()&&!d&&m()},1e4)});async function v(e){let t=e.dataset.id,n=e.dataset.type,r=document.querySelector(`meta[name="csrf-token"]`)?.content;if(!t||!n)return;let i=e.classList.contains(`bxs-star`);e.classList.toggle(`bx-star`,i),e.classList.toggle(`bxs-star`,!i),e.classList.toggle(`active`,!i),e.style.transform=`scale(1.3)`,setTimeout(()=>e.style.transform=``,200);try{let i=await fetch(`/app/favorite/toggle`,{method:`POST`,headers:{"Content-Type":`application/json`,"X-CSRF-TOKEN":r,Accept:`application/json`,"X-Requested-With":`XMLHttpRequest`},body:JSON.stringify({type:n,id:parseInt(t)}),credentials:`same-origin`}),a=await i.json();i.ok&&a.success&&(e.classList.toggle(`bx-star`,!a.is_favorited),e.classList.toggle(`bxs-star`,a.is_favorited),e.classList.toggle(`active`,a.is_favorited),b(a.is_favorited?`⭐ Favorit!`:`✕ Dihapus`,a.message,a.is_favorited?`#f59e0b`:`#555`,`reminder`))}catch{e.classList.toggle(`bx-star`,!i),e.classList.toggle(`bxs-star`,i),e.classList.toggle(`active`,i)}}function y(){x(),`Notification`in window&&Notification.permission===`default`&&Notification.requestPermission();let e=`schedule_notif_fired`,t=`schedule_notif_day`,n=new Date().toDateString();localStorage.getItem(t)!==n&&(localStorage.setItem(t,n),localStorage.setItem(e,JSON.stringify([])));function r(){try{return JSON.parse(localStorage.getItem(e))||[]}catch{return[]}}function i(t){let n=r();n.push(t),localStorage.setItem(e,JSON.stringify(n))}let a=[],o=0;async function s(){try{let e=await fetch(`/app/api/schedules/today`,{headers:{"X-Requested-With":`XMLHttpRequest`,Accept:`application/json`},credentials:`same-origin`});e.ok&&(a=await e.json(),o=Date.now())}catch{}}window.__refetchSchedules=s;function c(){let e=new Date;return String(e.getHours()).padStart(2,`0`)+`:`+String(e.getMinutes()).padStart(2,`0`)}function l(){let e=c(),t=r();a.forEach(n=>{let r=`start-${n.id}-${n.start_time}`,a=`end-${n.id}-${n.end_time}`;n.start_time===e&&!t.includes(r)&&(i(r),d(`📚 Waktunya Belajar!`,`${n.title} — mulai sekarang (${n.start_time})`,n.color||`#6366f1`,`start`)),n.end_time&&n.end_time===e&&!t.includes(a)&&(i(a),d(`☕ Waktunya Istirahat!`,`${n.title} — sesi selesai (${n.end_time})`,`#10b981`,`end`));let o=`pre-${n.id}-${n.start_time}`;u(n.start_time,5)===e&&!t.includes(o)&&(i(o),d(`⏰ 5 Menit Lagi!`,`${n.title} dimulai pukul ${n.start_time}`,n.color||`#f59e0b`,`reminder`))})}function u(e,t){let[n,r]=e.split(`:`).map(Number),i=new Date(2e3,0,1,n,r-t);return String(i.getHours()).padStart(2,`0`)+`:`+String(i.getMinutes()).padStart(2,`0`)}function d(e,t,n,r){if(`Notification`in window&&Notification.permission===`granted`)try{let n=new Notification(e,{body:t,icon:`/assets/img/img001non.jpg`,tag:`schedule-${r}-${Date.now()}`});setTimeout(()=>n.close(),8e3)}catch{}typeof window.__addNotification==`function`&&window.__addNotification(e,t,n,r),b(e,t,n,r)}window.__sendScheduleNotification=d;async function f(){await s();let e=`schedule_welcome_`+n;if(!localStorage.getItem(e)&&(localStorage.setItem(e,`1`),a.length>0)){let e=a.map(e=>e.title).slice(0,3),t=a.length>3?` dan ${a.length-3} lainnya`:``,n=e.join(`, `)+t;typeof window.__addNotification==`function`&&window.__addNotification(`📋 ${a.length} jadwal hari ini`,n,`#6366f1`,`system`)}}f(),setInterval(()=>{Date.now()-o>120*1e3&&s(),l()},15e3),setTimeout(l,3e3)}function b(e,t,n,r){let i=document.getElementById(`toast-container`);if(!i)return;let a={start:`bx bx-book-open`,end:`bx bx-coffee`,reminder:`bx bx-bell`},o=document.createElement(`div`);o.className=`schedule-toast`,o.style.setProperty(`--toast-color`,n),o.innerHTML=`
        <div class="toast-icon"><i class='${a[r]||`bx bx-bell`}'></i></div>
        <div class="toast-content">
            <h5>${e}</h5>
            <p>${t}</p>
        </div>
        <button class="toast-close" onclick="this.closest('.schedule-toast').remove()">
            <i class='bx bx-x'></i>
        </button>
        <div class="toast-progress"></div>
    `,i.appendChild(o),requestAnimationFrame(()=>o.classList.add(`show`)),setTimeout(()=>{o.classList.remove(`show`),o.classList.add(`hide`),setTimeout(()=>o.remove(),400)},8e3)}function x(){if(document.getElementById(`toast-styles`))return;let e=document.createElement(`style`);e.id=`toast-styles`,e.textContent=`
        #toast-container {
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
            max-width: 380px;
            width: calc(100% - 32px);
        }
        .schedule-toast {
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: #191825;
            border-radius: 16px;
            border: 1px solid #1f1e2e;
            border-left: 4px solid var(--toast-color, #6366f1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.45);
            transform: translateX(120%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .schedule-toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        .schedule-toast.hide {
            transform: translateX(120%);
            opacity: 0;
        }
        .toast-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--toast-color, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .toast-icon i {
            color: #fff;
            font-size: 20px;
        }
        .toast-content {
            flex: 1;
            min-width: 0;
        }
        .toast-content h5 {
            color: #E6E0E9;
            font-size: 13px;
            font-weight: 600;
        }
        .toast-content p {
            color: #8a898a;
            font-size: 12px;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .toast-close {
            background: none;
            border: none;
            color: #555;
            font-size: 18px;
            cursor: pointer;
            padding: 4px;
            flex-shrink: 0;
        }
        .toast-close:hover {
            color: #E6E0E9;
        }
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: var(--toast-color, #6366f1);
            border-radius: 0 0 0 16px;
            animation: toast-countdown 8s linear forwards;
        }
        @keyframes toast-countdown {
            from { width: 100%; }
            to   { width: 0%; }
        }
    `,document.head.appendChild(e)}