(()=>{function O(e){return(O="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function T(){"use strict";T=function(){return a};var l,a={},e=Object.prototype,u=e.hasOwnProperty,s=Object.defineProperty||function(e,t,n){e[t]=n.value},t="function"==typeof Symbol?Symbol:{},r=t.iterator||"@@iterator",n=t.asyncIterator||"@@asyncIterator",o=t.toStringTag||"@@toStringTag";function i(e,t,n){return Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{i({},"")}catch(l){i=function(e,t,n){return e[t]=n}}function c(e,t,n,r){var o,i,a,c,t=t&&t.prototype instanceof m?t:m,t=Object.create(t.prototype),r=new k(r||[]);return s(t,"_invoke",{value:(o=e,i=n,a=r,c=f,function(e,t){if(c===v)throw new Error("Generator is already running");if(c===y){if("throw"===e)throw t;return{value:l,done:!0}}for(a.method=e,a.arg=t;;){var n=a.delegate;if(n){n=function e(t,n){var r=n.method,o=t.iterator[r];if(o===l)return n.delegate=null,"throw"===r&&t.iterator.return&&(n.method="return",n.arg=l,e(t,n),"throw"===n.method)||"return"!==r&&(n.method="throw",n.arg=new TypeError("The iterator does not provide a '"+r+"' method")),p;r=d(o,t.iterator,n.arg);if("throw"===r.type)return n.method="throw",n.arg=r.arg,n.delegate=null,p;o=r.arg;return o?o.done?(n[t.resultName]=o.value,n.next=t.nextLoc,"return"!==n.method&&(n.method="next",n.arg=l),n.delegate=null,p):o:(n.method="throw",n.arg=new TypeError("iterator result is not an object"),n.delegate=null,p)}(n,a);if(n){if(n===p)continue;return n}}if("next"===a.method)a.sent=a._sent=a.arg;else if("throw"===a.method){if(c===f)throw c=y,a.arg;a.dispatchException(a.arg)}else"return"===a.method&&a.abrupt("return",a.arg);c=v;n=d(o,i,a);if("normal"===n.type){if(c=a.done?y:h,n.arg===p)continue;return{value:n.arg,done:a.done}}"throw"===n.type&&(c=y,a.method="throw",a.arg=n.arg)}})}),t}function d(e,t,n){try{return{type:"normal",arg:e.call(t,n)}}catch(e){return{type:"throw",arg:e}}}a.wrap=c;var f="suspendedStart",h="suspendedYield",v="executing",y="completed",p={};function m(){}function g(){}function b(){}var t={},w=(i(t,r,function(){return this}),Object.getPrototypeOf),w=w&&w(w(_([]))),L=(w&&w!==e&&u.call(w,r)&&(t=w),b.prototype=m.prototype=Object.create(t));function E(e){["next","throw","return"].forEach(function(t){i(e,t,function(e){return this._invoke(t,e)})})}function S(a,c){var t;s(this,"_invoke",{value:function(n,r){function e(){return new c(function(e,t){!function t(e,n,r,o){var i,e=d(a[e],a,n);if("throw"!==e.type)return(n=(i=e.arg).value)&&"object"==O(n)&&u.call(n,"__await")?c.resolve(n.__await).then(function(e){t("next",e,r,o)},function(e){t("throw",e,r,o)}):c.resolve(n).then(function(e){i.value=e,r(i)},function(e){return t("throw",e,r,o)});o(e.arg)}(n,r,e,t)})}return t=t?t.then(e,e):e()}})}function x(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function q(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function k(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(x,this),this.reset(!0)}function _(t){if(t||""===t){var n,e=t[r];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length))return n=-1,(e=function e(){for(;++n<t.length;)if(u.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=l,e.done=!0,e}).next=e}throw new TypeError(O(t)+" is not iterable")}return s(L,"constructor",{value:g.prototype=b,configurable:!0}),s(b,"constructor",{value:g,configurable:!0}),g.displayName=i(b,o,"GeneratorFunction"),a.isGeneratorFunction=function(e){e="function"==typeof e&&e.constructor;return!!e&&(e===g||"GeneratorFunction"===(e.displayName||e.name))},a.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,b):(e.__proto__=b,i(e,o,"GeneratorFunction")),e.prototype=Object.create(L),e},a.awrap=function(e){return{__await:e}},E(S.prototype),i(S.prototype,n,function(){return this}),a.AsyncIterator=S,a.async=function(e,t,n,r,o){void 0===o&&(o=Promise);var i=new S(c(e,t,n,r),o);return a.isGeneratorFunction(t)?i:i.next().then(function(e){return e.done?e.value:i.next()})},E(L),i(L,o,"Generator"),i(L,r,function(){return this}),i(L,"toString",function(){return"[object Generator]"}),a.keys=function(e){var t,n=Object(e),r=[];for(t in n)r.push(t);return r.reverse(),function e(){for(;r.length;){var t=r.pop();if(t in n)return e.value=t,e.done=!1,e}return e.done=!0,e}},a.values=_,k.prototype={constructor:k,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=l,this.done=!1,this.delegate=null,this.method="next",this.arg=l,this.tryEntries.forEach(q),!e)for(var t in this)"t"===t.charAt(0)&&u.call(this,t)&&!isNaN(+t.slice(1))&&(this[t]=l)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(n){if(this.done)throw n;var r=this;function e(e,t){return i.type="throw",i.arg=n,r.next=e,t&&(r.method="next",r.arg=l),!!t}for(var t=this.tryEntries.length-1;0<=t;--t){var o=this.tryEntries[t],i=o.completion;if("root"===o.tryLoc)return e("end");if(o.tryLoc<=this.prev){var a=u.call(o,"catchLoc"),c=u.call(o,"finallyLoc");if(a&&c){if(this.prev<o.catchLoc)return e(o.catchLoc,!0);if(this.prev<o.finallyLoc)return e(o.finallyLoc)}else if(a){if(this.prev<o.catchLoc)return e(o.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return e(o.finallyLoc)}}}},abrupt:function(e,t){for(var n=this.tryEntries.length-1;0<=n;--n){var r=this.tryEntries[n];if(r.tryLoc<=this.prev&&u.call(r,"finallyLoc")&&this.prev<r.finallyLoc){var o=r;break}}var i=(o=o&&("break"===e||"continue"===e)&&o.tryLoc<=t&&t<=o.finallyLoc?null:o)?o.completion:{};return i.type=e,i.arg=t,o?(this.method="next",this.next=o.finallyLoc,p):this.complete(i)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),p},finish:function(e){for(var t=this.tryEntries.length-1;0<=t;--t){var n=this.tryEntries[t];if(n.finallyLoc===e)return this.complete(n.completion,n.afterLoc),q(n),p}},catch:function(e){for(var t=this.tryEntries.length-1;0<=t;--t){var n,r,o=this.tryEntries[t];if(o.tryLoc===e)return"throw"===(n=o.completion).type&&(r=n.arg,q(o)),r}throw new Error("illegal catch attempt")},delegateYield:function(e,t,n){return this.delegate={iterator:_(e),resultName:t,nextLoc:n},"next"===this.method&&(this.arg=l),p}},a}function l(e,t,n,r,o,i,a){try{var c=e[i](a),l=c.value}catch(e){return void n(e)}c.done?t(l):Promise.resolve(l).then(r,o)}var e=document.querySelectorAll(".envira-onboarding-btn-prev"),t=document.querySelectorAll(".envira-onboarding-btn-next"),n=document.querySelector(".envira-onboarding-progress"),r=document.querySelectorAll(".envira-onboarding-form-step"),o=document.querySelectorAll(".envira-onboarding-progress-step"),i=0;function a(){r.forEach(function(e){e.classList.contains("envira-onboarding-form-step-active")&&e.classList.remove("envira-onboarding-form-step-active")}),r[i].classList.add("envira-onboarding-form-step-active"),w.style.display="2"===i?"block":"none"}function u(){o.forEach(function(e,t){var n=e.previousElementSibling;t<=i?(e.classList.add("envira-onboarding-progress-step-active"),n.style.borderColor="#37993B"):(e.classList.remove("envira-onboarding-progress-step-active"),n.style.borderColor="#DCDDE1")}),n.style.width=i/(o.length-1)*100+"%"}t.forEach(function(t){t.addEventListener("click",function(){var e,r;0===i?(r=document.querySelector("#envira-general")).addEventListener("submit",function(){c=T().mark(function e(t){var n;return T().wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),t.stopPropagation(),(n=new FormData(r)).append("action","save_onboarding_data"),n.append("nonce",enviraOnboardingWizard.nonce),e.prev=5,e.next=8,fetch(enviraOnboardingWizard.ajaxUrl,{method:"POST",body:n});case 8:return n=e.sent,e.next=11,n.json();case 11:e.sent.success?(i=1,a(),u()):(i=0,console.log("Error saving the data")),e.next=19;break;case 15:e.prev=15,e.t0=e.catch(5),i=0,console.error("Error:",e.t0);case 19:case"end":return e.stop()}},e,null,[[5,15]])});var c,t=function(){var e=this,a=arguments;return new Promise(function(t,n){var r=c.apply(e,a);function o(e){l(r,t,n,o,i,"next",e)}function i(e){l(r,t,n,o,i,"throw",e)}o(void 0)})};return function(e){return t.apply(this,arguments)}}()):(e=t.getAttribute("data-next"))&&(i=e,a(),u())})}),e.forEach(function(t){t.addEventListener("click",function(){var e=t.getAttribute("data-prev");e&&(i=e,a(),u())})});t=document.querySelector("#envira-onboarding-back-to-welcome"),e=document.querySelector("#envira-get-started-btn");function c(e){return/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)}t.addEventListener("click",function(){document.querySelector(".envira-onboarding-wizard-intro").style={display:"flex"},document.querySelector(".envira-onboarding-wizard-wrapper").style="height: 85vh",document.querySelector(".envira-onboarding-wizard-pages").style.display="none"}),e.addEventListener("click",function(){document.querySelector(".envira-onboarding-wizard-intro").style.display="none",document.querySelector(".envira-onboarding-wizard-wrapper").style="height: auto",document.querySelector(".envira-onboarding-wizard-pages").style={display:"flex"}}),document.querySelectorAll(".no-clicks").forEach(function(e){e.addEventListener("click",function(e){e.preventDefault(),e.stopPropagation()})}),document.querySelector(".envira-onboarding-wizard-wrapper").style="height: 85vh";function s(){h.innerHTML="Please enter a valid email address.",f.disabled=!0,f.classList.add("envira-disabled")}var d=document.querySelector("#email_address"),f=document.querySelector("#save-opt-in"),h=document.querySelector(".envira-email-error"),v=(h.innerHTML="",document.querySelector("#email_opt_in")),y=(v.addEventListener("change",function(){y()}),function(){""!==d.value&&c(d.value)||!v.checked||s(),""===d.value||c(d.value)||v.checked||s(),(""!==d.value&&c(d.value)||""===d.value&&!v.checked)&&(h.innerHTML="",f.disabled=!1,f.classList.remove("envira-disabled"))}),p=(d.addEventListener("input",function(){y()}),document.querySelectorAll("input[name='eow[_user_type]']"));p.forEach(function(e){e.addEventListener("change",function(e){"other"===e.target.value?(document.querySelector("#others_div").style.display="block",document.querySelector("#others").required=!0):(document.querySelector("#others_div").style.display="none",document.querySelector("#others").required=!1),Array.from(p).some(function(e){return e.checked})?(f.disabled=!1,f.classList.remove("envira-disabled")):(f.disabled=!0,f.classList.add("envira-disabled"))})});var t=document.querySelectorAll(".feature"),m=[];t.forEach(function(e){e.addEventListener("click",function(t){t.target.checked?m.includes(t.target.value)||(m.push(t.target.value),document.querySelector("#".concat(t.target.value,"-desc")).style.display="block"):(m=m.filter(function(e){return e!==t.target.value}),document.querySelector("#".concat(t.target.value,"-desc")).style.display="none")})});document.querySelector("#envira-save-features").addEventListener("click",function(){var e;0!==m.length&&(e={action:"save_selected_addons",addons:m,nonce:enviraOnboardingWizard.nonce},fetch(enviraOnboardingWizard.ajaxUrl,{method:"post",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams(e).toString()}).then(function(e){return e.json()}).then(function(e){e.success}).catch(function(e){console.error("Error:",e)}),document.querySelectorAll(".selected-addon-item").forEach(function(e){e.remove()}),m.forEach(function(e){var t=document.createElement("div"),n=(t.classList.add("envira-col","col-sm-6","col-xs-12","envira-col","text-xs-left","selected-addon-item"),document.querySelector('input[name="'.concat(e,'"]')).getAttribute("data-name"));t.innerHTML="".concat(S).concat(n,"</div>"),x.appendChild(t),document.querySelector("#".concat(e,"-desc")).style.display="block"}))});var g=document.querySelectorAll(".recommended"),b=[],w=document.querySelector(".selected-plugins-names"),L=[],E=(g.forEach(function(e){e.addEventListener("click",function(t){t.target.checked?(b.push(t.target.value),L.push(t.target.getAttribute("data-name")),document.querySelector("#".concat(t.target.value,"-desc")).style.display="block"):(b=b.filter(function(e){return e!==t.target.value}),L=L.filter(function(e){return e!==t.target.getAttribute("data-name")}),document.querySelector("#".concat(t.target.value,"-desc")).style.display="none"),E()})}),function(){w.innerHTML="",0===L.length&&g.forEach(function(e){!e.checked||b.includes(e.value)||enviraOnboardingWizard.plugins_list.includes(e.value)||(L.push(e.getAttribute("data-name")),document.querySelector("#".concat(e.value,"-desc")).style.display="block")}),0<L.length&&(w.innerHTML="The following plugins will be installed: "),L.forEach(function(e){var t=document.createElement("span");t.innerHTML="".concat(e),w.appendChild(t),L.indexOf(e)!==L.length-1&&((t=document.createElement("span")).innerHTML=", ",w.appendChild(t))})});E();document.querySelector("#envira-install-recommended").addEventListener("click",function(){0===b.length&&g.forEach(function(e){e.checked&&!b.includes(e.value)&&b.push(e.value)});var e={action:"install_recommended_plugins",plugins:b,nonce:enviraOnboardingWizard.nonce};fetch(enviraOnboardingWizard.ajaxUrl,{method:"post",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams(e).toString()}).then(function(e){return e.json()}).then(function(e){e.success}).catch(function(e){console.error("Error:",e)})});var S='<svg class=envira-checkmark fill=none viewBox="0 0 14 11" xmlns=http://www.w3.org/2000/svg>\n<path clip-rule=evenodd d="M10.8542 1.37147C11.44 0.785682 12.3897 0.785682 12.9755 1.37147C13.5613 1.95726 13.5613 2.907 12.9755 3.49279L6.04448 10.4238C5.74864 10.7196 5.35996 10.8661 4.97222 10.8631C4.58548 10.8653 4.19805 10.7189 3.90298 10.4238L1.0243 7.5451C0.438514 6.95931 0.438514 6.00956 1.0243 5.42378C1.61009 4.83799 2.55983 4.83799 3.14562 5.42378L4.97374 7.2519L10.8542 1.37147Z" fill=currentColor fill-rule=evenodd></path>\n</svg>',x=document.querySelector("#selected-add-ons");var q=document.querySelector(".envira-gallery-verify-submit"),k=document.querySelector("#license-key-message"),_=document.querySelector(".envira-onboarding-spinner");q.addEventListener("click",function(e){e.preventDefault();e=document.getElementById("envira-settings-key").value;if(""===e)return k.classList.add("envira-error"),void(k.innerHTML="Please enter your license key.");_.style.visibility="visible",q.classList.add("envira-disabled"),k.classList.remove("envira-success","envira-error");function t(){_.style.visibility="hidden",q.disabled=!1,q.classList.remove("envira-disabled")}e={action:"envira_connect",key:e,onboarding:"install_addons",_wpnonce:enviraOnboardingWizard.connect_nonce};fetch(enviraOnboardingWizard.ajaxUrl,{method:"post",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:new URLSearchParams(e).toString()}).then(function(e){return e.json()}).then(function(e){e.success?k.classList.add("envira-success"):k.classList.add("envira-error"),k.innerHTML=e.data.message,t()}).catch(function(e){k.classList.add("envira-error"),k.innerHTML="Error verifying the license key.",console.log("Error:",e),t()})});e=function(){document.body.style.visibility="visible"},"interactive"===document.readyState||"complete"===document.readyState?e():document.addEventListener("DOMContentLoaded",e)})();