(function($){$.fn.YMslider=function(G){var b=$.extend({},$.fn.YMslider.defaults,G);return this.each(function(){var Z="overflow-x",Y="hidden",d=$(this).css(Z,Y);if(d.css(Z)==Y){var X="panel",p=d.children("ul,ol").addClass(X+"s"),f=p.children("li").addClass(X),g=f.length;if(g>1){function R(){var a="YMslider"+(new Date).getTime().toString().substr(-4,4);d.attr("id",a);return a}var q=d.attr("id")||R(),r=d.width(),j,k,s=g-1,W=' class="',h="<div"+W+'controls">',l=Math.ceil(b.init-1),H=b.title.replace(/\$ID/g,q).replace(/\$TOT/g,g),w=b.anim*1E3,t=b.pause*1E3+w,u=false,x=b.start,y=b.stop,z=b.auto,A=b.controls,I=d.offset().top,J=$(window),V="active",U="last",T="width",S="title";function B(a){a.addClass(V).siblings("."+V).removeClass(V)}function C(a){a.eq(0).addClass("first").nextAll(":"+U).addClass(U)}function D(){return i.index(i.siblings("."+V))}function m(a,e){return!e?a!=s?a+1:0:a!=0?a-1:s}function v(a,e){u=true;B(f.eq(a));$.isFunction(x)&&x.call(d);p.animate({marginLeft:-a*r},!e?w:0,b.easing,function(){B(i.eq(a));$.isFunction(y)&&y.call(d);u=false})}function n(a){v(a);a=m(a);k=setTimeout(function(){n(a)},t)}p.css(T,g*r+"px");C(f.css(T,r+"px"));for(j=0;j<g;j++){var o=j+1,E=f.eq(j),F=E.attr(S)||o;E.attr("id",q+"-"+o);h+='<a href="#'+q+'" '+S+'="'+H.replace(/\$NB/g,o).replace(/\$TIT/g,F)+'"><span>'+F+"</span></a>"+(o<g?"<span"+W+'spacer">'+b.spacer+"</span>":"</div>")}h=$(h);var i=h.children("a").click(function(){var a=i.index(this);if(!u&&a!=D())if(z){clearTimeout(k);n(a)}else v(a);if(b.top&&J.scrollTop()>I)location=this.href;return false});C(i);if(A!=false)A!="before"?d.addClass("regular").append(h):d.addClass("inverted").prepend(h);b.keyboard&&$(document).keydown(function(a){a=a.keyCode;if(a==39||a==37){var e=D();i.eq(a==39?m(e):m(e,true)).click()}});if(l<0||l>s)l=0;v(l,true);if(z){k=setTimeout(function(){n(m(l))},t);b.hover&&f.bind("mouseenter mouseleave",function(a){clearTimeout(k);if(a.type=="mouseleave"){var e=m(f.index(this));k=setTimeout(function(){n(e)},t)}})}}}})};$.fn.YMslider.defaults={init:1,auto:true,anim:1,easing:"swing",pause:10,hover:true,keyboard:true,controls:"after",spacer:" ",title:"Move to the $ID panel $NB/$TOT : $TIT",top:false,start:null,stop:null}})(jQuery);