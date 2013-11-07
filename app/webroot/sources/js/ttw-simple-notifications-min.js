/**
 * Created by 23rd and Walnut for Codebasehero.com
 * www.23andwalnut.com
 * www.codebasehero.com
 * User: Saleem El-Amin
 * Date: 6/11/11
 * Time: 6:41 AM
 *
 * License: You are free to use this file in personal and commercial products, however re-distribution 'as-is' without prior consent is prohibited.
 */

(function(a){a.fn.ttwSimpleNotifications=function(i){var l=this,f,p,q,b,g,d,n={};f={position:"bottom right",autoHide:true,autoHideDelay:6000,clickCallback:null,showCallback:null,hideCallback:null};d={tmp:".tmp",notification:".ttw-simple-notification",close:".close"};p={wrapper:'<div class="ttw-simple-notification-wrapper"></div>',tmp:'<div class="ttw-simple-notification-tmp"></div>',notification:'<div class="ttw-simple-notification"><div class="icon"></div><div class="message"></div><span class="close"></span></div>'};q=a.extend({},f,i);function o(){var r,s={position:"absolute"};r=q.position.split(" ");s[r[0]]=0;s[r[1]]=0;b=a(p.wrapper).css(s).appendTo(l);g=a(p.tmp).appendTo(l);a(d.notification+" "+d.close).live("click",function(){h(a(this).parent(d.notification).attr("id"))});a(d.notification).live("click",function(){j(q.clickCallback)})}function m(s){if(typeof s!="undefined"){var r=a(p.notification),t;if(typeof s=="string"){k(r,s)}else{k(r,s.msg);e(r,s.icon)}t="ttwNotification"+new Date().getTime();n[t]={};n[t].notification=r;c(t,s.autoHide);r.attr("id",t);r.appendTo(b).slideDown(300,function(){r.animate({opacity:1},function(){j(q.showCallback)})});return t}else{return false}}function k(r,s){if(typeof s!="undefined"){r.find(".message").html(s)}}function e(s,r){if(typeof r!="undefined"){s.addClass("show-icon").find(".icon").css("background","transparent url("+r+") no-repeat center center scroll")}}function c(s,r){if(r||(r!==false&&q.autoHide!==false)){n[s]["timeout"]=setTimeout(function(){h(s)},q.autoHideDelay)}}function h(r){if(typeof n[r]!=undefined){if(typeof n[r]["timeout"]!="undefined"){clearTimeout(n[r]["timeout"])}n[r]["notification"].fadeOut();delete n[r];j(q.hideCallback)}}function j(s){var r=Array.prototype.slice.call(arguments,1);if(a.isFunction(s)){s.apply(this,r)}}o();return{show:m,hide:h,notifications:n}}})(jQuery);