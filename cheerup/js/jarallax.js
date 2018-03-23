/*!
 * Name    : Just Another Parallax [Jarallax]
 * Version : 1.8.0
 * Copyright (c) 2017 nK Licensed under the WTFPL license.
 */
!function(e){"use strict";function t(e){var t=["O","Moz","ms","Ms","Webkit"],n=t.length;if(void 0!==l.style[e])return!0;for(e=e.charAt(0).toUpperCase()+e.substr(1);--n>-1&&void 0===l.style[t[n]+e];);return n>=0}function n(){a=e.innerWidth||document.documentElement.clientWidth,r=e.innerHeight||document.documentElement.clientHeight}function i(e,t,n){e.addEventListener?e.addEventListener(t,n):e.attachEvent("on"+t,function(){n.call(e)})}function o(t){e.requestAnimationFrame(function(){"scroll"!==t.type&&n();for(var e=0,i=h.length;e<i;e++)"scroll"!==t.type&&(h[e].coverImage(),h[e].clipContainer()),h[e].onScroll()})}Date.now||(Date.now=function(){return(new Date).getTime()}),e.requestAnimationFrame||!function(){for(var t=["webkit","moz"],n=0;n<t.length&&!e.requestAnimationFrame;++n){var i=t[n];e.requestAnimationFrame=e[i+"RequestAnimationFrame"],e.cancelAnimationFrame=e[i+"CancelAnimationFrame"]||e[i+"CancelRequestAnimationFrame"]}if(/iP(ad|hone|od).*OS 6/.test(e.navigator.userAgent)||!e.requestAnimationFrame||!e.cancelAnimationFrame){var o=0;e.requestAnimationFrame=function(e){var t=Date.now(),n=Math.max(o+16,t);return setTimeout(function(){e(o=n)},n-t)},e.cancelAnimationFrame=clearTimeout}}();var a,r,l=document.createElement("div"),s=t("transform"),c=t("perspective"),m=navigator.userAgent,p=m.toLowerCase().indexOf("android")>-1,u=/iPad|iPhone|iPod/.test(m)&&!e.MSStream,d=m.toLowerCase().indexOf("firefox")>-1,g=m.indexOf("MSIE ")>-1||m.indexOf("Trident/")>-1||m.indexOf("Edge/")>-1,f=document.all&&!e.atob;n();var h=[],y=function(){function e(e,n){var i,o=this;if(o.$item=e,o.defaults={type:"scroll",speed:.5,imgSrc:null,imgWidth:null,imgHeight:null,elementInViewport:null,zIndex:-100,noAndroid:!1,noIos:!0,onScroll:null,onInit:null,onDestroy:null,onCoverImage:null},i=JSON.parse(o.$item.getAttribute("data-jarallax")||"{}"),o.options=o.extend({},o.defaults,i,n),!(!s||p&&o.options.noAndroid||u&&o.options.noIos)){o.options.speed=Math.min(2,Math.max(-1,parseFloat(o.options.speed)));var a=o.options.elementInViewport;a&&"object"==typeof a&&"undefined"!=typeof a.length&&(a=a[0]),!a instanceof Element&&(a=null),o.options.elementInViewport=a,o.instanceID=t++,o.image={src:o.options.imgSrc||null,$container:null,$item:null,width:o.options.imgWidth||null,height:o.options.imgHeight||null,useImgTag:u||p||g,position:!c||d?"absolute":"fixed"},o.initImg()&&o.init()}}var t=0;return e}();y.prototype.css=function(t,n){if("string"==typeof n)return e.getComputedStyle?e.getComputedStyle(t).getPropertyValue(n):t.style[n];n.transform&&(c&&(n.transform+=" translateZ(0)"),n.WebkitTransform=n.MozTransform=n.msTransform=n.OTransform=n.transform);for(var i in n)t.style[i]=n[i];return t},y.prototype.extend=function(e){e=e||{};for(var t=1;t<arguments.length;t++)if(arguments[t])for(var n in arguments[t])arguments[t].hasOwnProperty(n)&&(e[n]=arguments[t][n]);return e},y.prototype.initImg=function(){var e=this;return null===e.image.src&&(e.image.src=e.css(e.$item,"background-image").replace(/^url\(['"]?/g,"").replace(/['"]?\)$/g,"")),!(!e.image.src||"none"===e.image.src)},y.prototype.init=function(){function e(){t.coverImage(),t.clipContainer(),t.onScroll(!0),t.options.onInit&&t.options.onInit.call(t),setTimeout(function(){t.$item&&t.css(t.$item,{"background-image":"none","background-attachment":"scroll","background-size":"auto"})},0)}var t=this,n={position:"absolute",top:0,left:0,width:"100%",height:"100%",overflow:"hidden",pointerEvents:"none"},i={};t.$item.setAttribute("data-jarallax-original-styles",t.$item.getAttribute("style")),"static"===t.css(t.$item,"position")&&t.css(t.$item,{position:"relative"}),"auto"===t.css(t.$item,"z-index")&&t.css(t.$item,{zIndex:0}),t.image.$container=document.createElement("div"),t.css(t.image.$container,n),t.css(t.image.$container,{visibility:"hidden","z-index":t.options.zIndex}),t.image.$container.setAttribute("id","jarallax-container-"+t.instanceID),t.$item.appendChild(t.image.$container),t.image.useImgTag?(t.image.$item=document.createElement("img"),t.image.$item.setAttribute("src",t.image.src),i=t.extend({"max-width":"none"},n,i)):(t.image.$item=document.createElement("div"),i=t.extend({"background-position":"50% 50%","background-size":"100% auto","background-repeat":"no-repeat no-repeat","background-image":'url("'+t.image.src+'")'},n,i));for(var o=0,a=t.$item;null!==a&&a!==document&&0===o;){var r=t.css(a,"-webkit-transform")||t.css(a,"-moz-transform")||t.css(a,"transform");r&&"none"!==r&&(o=1,t.css(t.image.$container,{transform:"translateX(0) translateY(0)"})),a=a.parentNode}(o||"opacity"===t.options.type||"scale"===t.options.type||"scale-opacity"===t.options.type)&&(t.image.position="absolute"),i.position=t.image.position,t.css(t.image.$item,i),t.image.$container.appendChild(t.image.$item),t.image.width&&t.image.height?e():t.getImageSize(t.image.src,function(n,i){t.image.width=n,t.image.height=i,e()}),h.push(t)},y.prototype.destroy=function(){for(var e=this,t=0,n=h.length;t<n;t++)if(h[t].instanceID===e.instanceID){h.splice(t,1);break}var i=e.$item.getAttribute("data-jarallax-original-styles");e.$item.removeAttribute("data-jarallax-original-styles"),"null"===i?e.$item.removeAttribute("style"):e.$item.setAttribute("style",i),e.$clipStyles&&e.$clipStyles.parentNode.removeChild(e.$clipStyles),e.image.$container.parentNode.removeChild(e.image.$container),e.options.onDestroy&&e.options.onDestroy.call(e),delete e.$item.jarallax;for(var o in e)delete e[o]},y.prototype.getImageSize=function(e,t){if(e&&t){var n=new Image;n.onload=function(){t(n.width,n.height)},n.src=e}},y.prototype.clipContainer=function(){if(!f){var e=this,t=e.image.$container.getBoundingClientRect(),n=t.width,i=t.height;if(!e.$clipStyles){e.$clipStyles=document.createElement("style"),e.$clipStyles.setAttribute("type","text/css"),e.$clipStyles.setAttribute("id","#jarallax-clip-"+e.instanceID);var o=document.head||document.getElementsByTagName("head")[0];o.appendChild(e.$clipStyles)}var a=["#jarallax-container-"+e.instanceID+" {","   clip: rect(0 "+n+"px "+i+"px 0);","   clip: rect(0, "+n+"px, "+i+"px, 0);","}"].join("\n");e.$clipStyles.styleSheet?e.$clipStyles.styleSheet.cssText=a:e.$clipStyles.innerHTML=a}},y.prototype.coverImage=function(){var e=this;if(e.image.width&&e.image.height){var t=e.image.$container.getBoundingClientRect(),n=t.width,i=t.height,o=t.left,a=e.image.width,l=e.image.height,s=e.options.speed,c="scroll"===e.options.type||"scroll-opacity"===e.options.type,m=0,p=0,u=i,d=0,g=0;c&&(m=s<0?s*Math.max(i,r):s*(i+r),s>1?u=Math.abs(m-r):s<0?u=m/s+Math.abs(m):u+=Math.abs(r-i)*(1-s),m/=2),p=u*a/l,p<n&&(p=n,u=p*l/a),c?(d=o+(n-p)/2,g=(r-u)/2):(d=(n-p)/2,g=(i-u)/2),"absolute"===e.image.position&&(d-=o),e.parallaxScrollDistance=m,e.css(e.image.$item,{width:p+"px",height:u+"px",marginLeft:d+"px",marginTop:g+"px"}),e.options.onCoverImage&&e.options.onCoverImage.call(e)}},y.prototype.isVisible=function(){return this.isElementInViewport||!1},y.prototype.onScroll=function(e){var t=this;if(t.image.width&&t.image.height){var n=t.$item.getBoundingClientRect(),i=n.top,o=n.height,l={visibility:"visible",backgroundPosition:"50% 50%"},s=n;if(t.options.elementInViewport&&(s=t.options.elementInViewport.getBoundingClientRect()),t.isElementInViewport=s.bottom>=0&&s.right>=0&&s.top<=r&&s.left<=a,e||t.isElementInViewport){var c=Math.max(0,i),m=Math.max(0,o+i),p=Math.max(0,-i),u=Math.max(0,i+o-r),d=Math.max(0,o-(i+o-r)),g=Math.max(0,-i+r-o),f=1-2*(r-i)/(r+o),h=1;if(o<r?h=1-(p||u)/o:m<=r?h=m/r:d<=r&&(h=d/r),"opacity"!==t.options.type&&"scale-opacity"!==t.options.type&&"scroll-opacity"!==t.options.type||(l.transform="",l.opacity=h),"scale"===t.options.type||"scale-opacity"===t.options.type){var y=1;t.options.speed<0?y-=t.options.speed*h:y+=t.options.speed*(1-h),l.transform="scale("+y+")"}if("scroll"===t.options.type||"scroll-opacity"===t.options.type){var v=t.parallaxScrollDistance*f;"absolute"===t.image.position&&(v-=i),l.transform="translateY("+v+"px)"}t.css(t.image.$item,l),t.options.onScroll&&t.options.onScroll.call(t,{section:n,beforeTop:c,beforeTopEnd:m,afterTop:p,beforeBottom:u,beforeBottomEnd:d,afterBottom:g,visiblePercent:h,fromViewportCenter:f})}}},i(e,"scroll",o),i(e,"resize",o),i(e,"orientationchange",o),i(e,"load",o);var v=function(e){("object"==typeof HTMLElement?e instanceof HTMLElement:e&&"object"==typeof e&&null!==e&&1===e.nodeType&&"string"==typeof e.nodeName)&&(e=[e]);var t,n=arguments[1],i=Array.prototype.slice.call(arguments,2),o=e.length,a=0;for(a;a<o;a++)if("object"==typeof n||"undefined"==typeof n?e[a].jarallax||(e[a].jarallax=new y(e[a],n)):e[a].jarallax&&(t=e[a].jarallax[n].apply(e[a].jarallax,i)),"undefined"!=typeof t)return t;return e};v.constructor=y;var x=e.jarallax;if(e.jarallax=v,e.jarallax.noConflict=function(){return e.jarallax=x,this},"undefined"!=typeof jQuery){var $=function(){var t=arguments||[];Array.prototype.unshift.call(t,this);var n=v.apply(e,t);return"object"!=typeof n?n:this};$.constructor=y;var b=jQuery.fn.jarallax;jQuery.fn.jarallax=$,jQuery.fn.jarallax.noConflict=function(){return jQuery.fn.jarallax=b,this}}i(e,"DOMContentLoaded",function(){v(document.querySelectorAll("[data-jarallax], [data-jarallax-video]"))})}(window);