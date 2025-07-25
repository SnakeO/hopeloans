/*jquery.supercarousel*/
/*
 * jQuery Super Carousel Plugin v3.0
 * Copyright (C) 2017 Taraprasad Swain
 * Author URL: http://www.taraprasad.com
 * Plugin URL: http://www.supercarousel.com
 */

!function(jQuery){jQuery.fn.supercarousel=function(customOptions){var $this=this,$$=jQuery(this),$wrap,locknav=!1,oldWindowWidth,superWrapXPos,superWrapYPos,ishidden=0,swipeid=!1,perPage=0,totalPages=1,currentPage=0,sucar=jQuery.fn.supercarousel,df=sucar.defaults,slides=[],currentSlide=0,totalSlides=0,sliderWidth=0,cssObj={},cssImgObj={},options,resetOptions=function(){if(options=jQuery.extend({},df,customOptions),$wrap){if(options.slideGap=parseInt(options.slideGap),$wrap.width()>=options.desktopMinWidth?"visible"==options.respDesktop?options.visible=options.desktopVisible:"fixwidth"==options.respDesktop?options.itemWidth=options.desktopWidth:"fixheight"==options.respDesktop&&(options.itemHeight=options.desktopHeight):$wrap.width()>=options.laptopMinWidth?"visible"==options.respLaptop?options.visible=options.laptopVisible:"fixwidth"==options.respLaptop?options.itemWidth=options.laptopWidth:"fixheight"==options.respLaptop&&(options.itemHeight=options.laptopHeight):$wrap.width()>=options.tabletMinWidth?"visible"==options.respTablet?options.visible=options.tabletVisible:"fixwidth"==options.respTablet?options.itemWidth=options.tabletWidth:"fixheight"==options.respTablet&&(options.itemHeight=options.tabletHeight):$wrap.width()<options.tabletMinWidth&&("visible"==options.respMobile?options.visible=options.mobileVisible:"fixwidth"==options.respMobile?options.itemWidth=options.mobileWidth:"fixheight"==options.respMobile&&(options.itemHeight=options.mobileHeight)),options.customrespby.length>0)for(var e=0;e<options.customrespby.length;e++)if(""!=options.customrespmin[e]&&""!=options.customrespmax[e]&&!isNaN(options.customrespmin[e])&&!isNaN(options.customrespmax[e])&&$wrap.width()>+options.customrespmin[e]&&$wrap.width()<+options.customrespmax[e]){"visible"!=options.customrespby[e]||isNaN(options.customrespvisible[e])?"fixwidth"!=options.customrespby[e]||isNaN(options.customrespwidth[e])?"fixheight"!=options.customrespby[e]||isNaN(options.customrespheight[e])||(options.itemHeight=+options.customrespheight[e]):options.itemWidth=+options.customrespwidth[e]:options.visible=+options.customrespvisible[e]
break}$$.find(">div img.super_image").length&&(options.type="image")}},createSuperCarousel=function(){if($$.wrap('<div class="supercarousel_wrapper"></div>').css({display:"block",visibility:"visible"}),$wrap=$$.parent()){var e=$$.html()
$$.prepend(e),$$.append(e),removeUnwantedTags(),totalSlides=$$.children().length/3,resetOptions(),checkLightBox(),disableLinks(),options.onload($$),$wrap.height(800),checkNavigation(),resetSlides(),setTimeout(function(){resetSlides()},500)}},removeUnwantedTags=function(){$$.find(">").not("div").remove()},disableLinks=function(){return options.onslideclick&&""!=options.onslideclick?($$.find(">div a").click(function(e){e.preventDefault()}),void $$.find(">div").click(function(event){event.preventDefault(),eval(options.onslideclick+"(this);")})):void $$.find(">div a").click(function(e){jQuery(e.target).hasClass("superswipe")&&e.preventDefault()})},checkLightBox=function(){if($wrap&&(!options.onslideclick||""==options.onslideclick)){getRandomInt(1e5,999999),$$.find(">div").length/3
$$.find(">div a.superlight").superLightBox({mediaCaption:"data-caption"})}},getRandomInt=function(e,t){return Math.floor(Math.random()*(t-e))+e},resetSlides=function(){$wrap&&(resetOptions(),checkParams(),resetStyleObj(),resetSlidePositions(),calculateTotalPages(),resetPagination(),resetWrapHeight(),gotoPage(currentPage),$$.stop(!0,!0))},checkNavigation=function(){1==options.nextPrev&&($wrap.parent().find(".supernext").click(function(e){e.preventDefault(),(totalPages-1>currentPage||options.circular)&&gotoPage(currentPage+1)}).css({display:"block"}),$wrap.parent().find(".superprev").click(function(e){e.preventDefault(),(currentPage>0||options.circular)&&gotoPage(currentPage-1)}).css({display:"block"}),options.arrowsOut&&$wrap.css({"margin-left":$wrap.parent().find(".superprev").width(),"margin-right":$wrap.parent().find(".supernext").width()})),options.swipe&&$this.registerSwipe(),options.keys&&jQuery("body").keyup(function(e){49==e.keyCode?gotoPage(0):50==e.keyCode?gotoPage(1):51==e.keyCode?gotoPage(2):52==e.keyCode?gotoPage(3):53==e.keyCode?gotoPage(4):54==e.keyCode?gotoPage(5):55==e.keyCode?gotoPage(6):56==e.keyCode?gotoPage(7):57==e.keyCode?gotoPage(8):58==e.keyCode?gotoPage(9):37==e.keyCode?gotoPage(currentPage-1):39==e.keyCode?gotoPage(currentPage+1):38==e.keyCode?gotoPage(currentPage-1):40==e.keyCode&&gotoPage(currentPage+1)}),options.mouseWheel&&$wrap.bind("mousewheel",function(e,t){$wrap.ismouseover()&&(gotoPage(t>0?currentPage-1:currentPage+1),e.preventDefault())})},getPageByDistance=function(e){var t=currentPage,i=-calculateNewLeft(t)-e
if(e>0){for(;-calculateNewLeft(t)>i&&(!(t>=totalPages)||options.circular);)t++
if(t>=totalPages&&!options.circular)return totalPages-1}else{for(;-calculateNewLeft(t)<i&&(!(0>=t)||options.circular);)t--
if(0>=t&&!options.circular)return 0}return t},superCarouselSwipe=function(e,t){var i={swipe:function(e){},swipeLeft:function(e){},swipeRight:function(e){},swipeUp:function(e){},swipeDown:function(e){},swipeStart:function(e){},swipeEnd:function(e,t){}},o=jQuery.extend({},i,t),s={}
s.sX=0,s.sY=0,s.eX=0,s.eY=0
var n=""
e.on("touchstart",function(e){var t=e.originalEvent.touches[0]
s.sX=t.screenX,s.sY=t.screenY,o.swipeStart(s)}),e.on("touchmove",function(e){var t=e.originalEvent.touches[0]
s.eX=t.screenX,s.eY=t.screenY,o.swipe(s)}),e.on("touchend",function(e){jQuery(window).width(),jQuery(window).height()
n=s.eX>s.sX?"r":"l",""!=n&&("l"==n?o.swipeLeft(s):"r"==n?o.swipeRight(s):"u"==n?o.swipeUp(s):"d"==n&&o.swipeDown(s)),o.swipeEnd(s,n),n=""})}
$this.registerSwipe=function(){options.swipe&&superCarouselSwipe($wrap,{swipeStart:function(e){superWrapXPos=$$.position().left,superWrapYPos=jQuery(window).scrollTop()},swipe:function(e){var t=-sliderWidth,i=-2*sliderWidth+$wrap.width(),o=e.eX-e.sX+superWrapXPos,s=e.sY-e.eY+superWrapYPos
0>s&&(s=0),o>t&&!options.circular?o=t:i>o&&!options.circular&&(o=i),$$.stop(!0,!0).css({left:o})},swipeEnd:function(e,t){var i=Math.abs(e.eX-e.sX),o=.2*$wrap.width()
if(i>o){if("r"==t){var s=getPageByDistance(-i)
gotoPage(currentPage>0||options.circular?s:currentPage)}else if("l"==t){var s=getPageByDistance(i)
gotoPage(totalPages-1>currentPage||options.circular?s:currentPage)}}else $$.animate({left:-calculateNewLeft(currentPage)})}})}
var removeSuperSwipeClass=function(e){swipeid=setTimeout(function(){jQuery(e.target).removeClass("superswipe")},500)},checkAutoScroll=function(){if($wrap&&"1"==options.autoscroll){options.effect="slide",("up"==options.direction||"down"==options.direction)&&(options.direction="left")
var e,t,i=calculateNewLeft(0),o=!!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/),s=-1!=navigator.appVersion.indexOf("Win")?!0:!1,n=1
o&&s&&(n=4),"left"==options.direction?(e=-(2*i),t="-="+options.scrollspeed*n+"px"):(e=-i,i=2*i,$$.css({left:-i}),t="+="+options.scrollspeed*n+"px"),checkSuperTimeout(i,t,e)}},checkSuperTimeout=function(e,t,i){setTimeout(function(){return locknav||options.pauseOver&&$wrap.ismouseover()?void checkSuperTimeout(e,t,i):($$.css({left:t}),Math.abs(i)-Math.abs(e)<$wrap.width()&&(e=calculateNewLeft(0),"left"==options.direction?i=-(2*e):(i=-e,e=2*e)),"left"==options.direction?$$.position().left<i&&$$.css({left:-e}):$$.position().left>i&&$$.css({left:-e}),void checkSuperTimeout(e,t,i))},options.scrollinterval)},checkAutoPlay=function(){$wrap&&options.auto&&!options.autoscroll&&setInterval(function(){locknav||(options.pauseOver?$wrap.ismouseover()||autoPlay():autoPlay())},options.pauseTime)},autoPlay=function(){"left"==options.direction||"down"==options.direction?gotoPage(currentPage+1):("right"==options.direction||"up"==options.direction)&&gotoPage(currentPage-1)},resetPagination=function(){if(options.paging)for($wrap.parent().find(".pagination").html(""),m=0;m<totalPages;m++){var e=jQuery('<a href="#"><span>'+(m+1)+"</span></a>").click(function(e){e.preventDefault(),gotoPage(jQuery(this).index())})
$wrap.parent().find(".pagination").append(e)}},gotoPage=function(e){if(!locknav){if(e>=totalPages&&!options.circular)return void gotoPage(0)
if(0>e&&!options.circular)return void gotoPage(totalPages-1)
options.onchange($$,currentPage,totalPages),e!=totalPages-1||options.circular||""==options.next?""!=options.next&&jQuery(options.next).hasClass("disabled")&&jQuery(options.next).removeClass("disabled"):jQuery(options.next).addClass("disabled"),0!=e||options.circular||""==options.prev?""!=options.prev&&jQuery(options.prev).hasClass("disabled")&&jQuery(options.prev).removeClass("disabled"):jQuery(options.prev).addClass("disabled"),currentPage=e,"slide"==options.effect?"left"==options.direction||"right"==options.direction?slideHorizontal():("up"==options.direction||"down"==options.direction)&&slideVertical():"focus"==options.effect?slideFocusHorizontal():"fade"==options.effect&&slideFadeIn(),options.paging&&$wrap.parent().find(".pagination").find(">a:eq("+currentPage+")").length>0&&($wrap.parent().find(".pagination").find(">a").removeClass("selected"),$wrap.parent().find(".pagination").find(">a:eq("+currentPage+")").addClass("selected"))}},calculateNewLeft=function(e){var t
if(!$wrap)return 0
if(options.step>0){var i=e*options.step+totalSlides
0>i?i=0:i>$$.find(">div").length-1&&(i=totalSlides),t=$$.find(">div:eq("+i+")").position().left}else t=e*$wrap.outerWidth(!1),t+=sliderWidth
if(!options.circular){var o=-2*sliderWidth+$wrap.outerWidth(!1)
o>-t&&(t=-o)}var o=-2*sliderWidth,s=-1*sliderWidth+$wrap.outerWidth(!1)
return s>0&&(s=0),o>=-t&&currentPage>0?(t=-o,currentPage=0):-t>=s&&0>currentPage&&(t=-s,currentPage=totalPages-1),t},slideFadeIn=function(){var e=calculateNewLeft(currentPage)
locknav=!0
var t=$$.clone().css({position:"absolute",display:"none",zIndex:0,left:-e,top:$$.position().top}).appendTo($wrap)
t.fadeIn(options.easingTime,options.easing,function(){$$.css({left:-e}),t.remove(),locknav=!1
var i=-2*sliderWidth,o=-1*sliderWidth+$wrap.outerWidth(!1)
o>0&&(o=0),i>=-e?$$.css({left:-e+sliderWidth}):-e>=o&&$$.css({left:-e-sliderWidth})})},slideVertical=function(){var e=calculateNewLeft(currentPage)
if(locknav=!0,"up"==options.direction)if(-e<$$.position().left)var t=1
else var t=-1
else if("down"==options.direction)if(-e<$$.position().left)var t=-1
else var t=1
var i=$$.clone().css({position:"absolute",zIndex:0,left:-e,top:$$.position().top+$wrap.outerHeight(!0)*t}).appendTo($wrap)
i.stop(!0,!0).animate({top:$$.position().top},options.easingTime,options.easing,function(){$$.css({left:-e}),i.remove(),locknav=!1
var t=-2*sliderWidth,o=-1*sliderWidth+$wrap.outerWidth(!1)
o>0&&(o=0),t>=-e?$$.css({left:-e+sliderWidth}):-e>=o&&$$.css({left:-e-sliderWidth})})},slideFocusHorizontal=function(){var e=calculateNewLeft(currentPage),t=currentPage*options.step+totalSlides
$$.find(">div").removeClass("focus"),$$.find(">div:eq("+t+")").addClass("focus"),$$.find(">div:eq("+(t+totalSlides)+")").addClass("focus"),$$.find(">div:eq("+(t-totalSlides)+")").addClass("focus")
var i=$$.find(">div:eq("+t+")").width()/2-$wrap.width()/2
e+=i,locknav=!0,$$.stop(!0,!0).animate({left:-e},options.easingTime,options.easing,function(){locknav=!1
var t=-2*sliderWidth-i,o=-1*sliderWidth-i+$wrap.outerWidth(!1)
o>0&&(o=0),t>=-e?$$.css({left:-e+sliderWidth}):-e>=o&&$$.css({left:-e-sliderWidth})}),resetWrapHeight()},slideHorizontal=function(){var e=calculateNewLeft(currentPage)
locknav=!0,$$.stop(!0,!0).animate({left:-e},options.easingTime,options.easing,function(){locknav=!1
var t=-2*sliderWidth,i=-1*sliderWidth+$wrap.outerWidth(!1)
i>0&&(i=0),t>=-e?$$.css({left:-e+sliderWidth}):-e>=i&&$$.css({left:-e-sliderWidth})}),resetWrapHeight()},checkParams=function(){options.step>totalSlides&&(options.step=totalSlides),options.visible&&(options.step>options.visible||0==options.step)&&(options.step=options.visible)},resetStyleObj=function(){$$.removeClass("superfixheight"),options.visible?(cssObj={width:getVisibleSlideWidth(),height:"auto"},cssImgObj={width:"100%",height:"auto"}):""!=options.itemWidth?(cssObj={width:options.itemWidth,height:"auto"},cssImgObj={width:"100%",height:"auto"}):""!=options.itemHeight&&(cssObj={width:"auto",height:"auto"},cssImgObj={width:"auto",height:options.itemHeight},$$.addClass("superfixheight")),$$.find(">div").css(cssObj),checkImageCarousel()},calculateTotalPages=function(){var e=$$.find(">div:last")
if(sliderWidth=(e.position().left+e.outerWidth(!1))/3,!$wrap)return 0
if(options.step>0){if(options.visible&&1==options.visible)return void(totalPages=totalSlides)
if(options.visible&&options.visible>1)return totalPages=(totalSlides-(options.visible-options.step))/options.step,void(1>totalPages&&(totalPages=1))
totalPages=1
for(var t=-1*calculateNewLeft(totalPages-1),i=-2*sliderWidth+$wrap.outerWidth(!1);t>i;)totalPages++,t=-1*calculateNewLeft(totalPages-1)}else totalPages=Math.ceil(sliderWidth/$wrap.outerWidth(!1))},resetSlidePositions=function(){$$.find(">div").each(function(){$ele=jQuery(this),""!=options.itemHeight&&"image"==options.type&&$ele.width($ele.find(".super_image").width()),$ele.prev().length>0?$ele.css({left:$ele.prev().position().left+$ele.prev().outerWidth(!1)+options.slideGap}):$ele.css({left:0})})},resetWrapHeight=function(){if(options.autoHeight&&options.step>0){var e,t=currentPage*options.step+totalSlides
if(options.visible)e=$$.find(">div").slice(t,t+options.visible).superMaxHeightElement().outerHeight(!0)
else if(options.itemWidth){var i=Math.ceil($wrap.width()/options.itemWidth)
e=$$.find(">div").slice(t,t+i).superMaxHeightElement().outerHeight(!0)}else e=$$.find(">div:eq("+t+")").outerHeight(!0)
return void $wrap.stop(!0,!0).animate({height:e+1},700,"swing",function(){})}var o=0
for(k=totalSlides;k<2*totalSlides;k++)t=$$.children(":eq("+k+")"),t.outerHeight(!0)>o&&(o=t.outerHeight(!0))
$wrap&&$wrap.height(o+1)},checkImageCarousel=function(){"image"==options.type&&$$.find("img").css(cssImgObj)},getVisibleSlides=function(){return options.visible?options.visible:""!=options.itemWidth?Math.ceil($wrap.width()/options.itemWidth):0},getVisibleSlideWidth=function(){return $wrap?Math.ceil(($wrap.width()-(options.visible-1)*options.slideGap)/options.visible):0},delayReset=function(){setTimeout(function(){resetSlides()},500)},registerHiddenCarousel=function(){setInterval(function(){$wrap.parent().is(":visible")?1==ishidden&&(delayReset(),ishidden=0):ishidden=1},500)},isIE=function(e,t){var i=jQuery('<div style="display:none;"/>').appendTo(jQuery("body"))
i.html("<!--[if "+(t||"")+" IE "+(e||"")+"]><a>&nbsp;</a><![endif]-->")
var o=i.find("a").length
return i.remove(),o},checkIsHidden=function(){options.superhidden&&registerHiddenCarousel()}
return oldWindowWidth=jQuery(window).width(),jQuery(window).resize(function(){jQuery(window).width()!=oldWindowWidth&&(resetSlides(),oldWindowWidth=jQuery(window).width())}),$$.find("img").length?$$.imagesLoaded(function(){createSuperCarousel(),checkAutoPlay(),checkAutoScroll(),checkIsHidden()}):(createSuperCarousel(),checkAutoPlay(),checkAutoScroll(),checkIsHidden()),$this}
var opts=jQuery.fn.supercarousel
opts.defaults={source:"Image",itemWidth:"",itemHeight:"",desktopMinWidth:1200,laptopMinWidth:992,tabletMinWidth:450,mobileMinWidth:0,direction:"left",effect:"slide",respDesktop:"visible",desktopVisible:"5",desktopWidth:"400",desktopHeight:"400",respLaptop:"visible",laptopVisible:"3",laptopWidth:"300",laptopHeight:"300",respTablet:"visible",tabletVisible:"2",tabletWidth:"200",tabletHeight:"200",respMobile:"visible",mobileVisible:"1",mobileWidth:"200",mobileHeight:"200",customrespmin:[],customrespmax:[],customrespby:[],customrespvisible:[],customrespwidth:[],customrespheight:[],arrowsOut:!1,slideGap:5,step:1,type:"content",auto:!1,autoscroll:!1,scrollspeed:1,scrollinterval:10,autoHeight:!1,easing:"swing",easingTime:700,pauseTime:1e3,pauseOver:!0,next:"",prev:"",paging:!1,circular:!1,mouseWheel:!1,swipe:!1,keys:!1,superhidden:!1,carouselid:0,onchange:function(e,t,i){},onload:function(e){}}}(jQuery),jQuery.fn.superMaxHeightElement=function(){var e=null,t=0
return this.each(function(){var i=jQuery(this).height()
i>t&&(t=i,e=jQuery(this))}),e},jQuery(document).ready(function(){jQuery(".supercrsl").each(function(){var e=jQuery(this).data("carouseloptions")
if(e){var t=["desktopVisible","desktopWidth","desktopHeight","laptopVisible","laptopWidth","laptopHeight","tabletVisible","tabletWidth","tabletHeight","mobileVisible","mobileWidth","mobileHeight","easingTime","step","pauseTime","scrollspeed","slideGap"],i=["auto","pauseOver","autoscroll","autoHeight","nextPrev","arrowsOut","circular","mouseWheel","swipe","keys","superhidden","paging"]
for(var o in t)e[t[o]]=parseInt(e[t[o]])
for(var o in i)e[i[o]]=1==parseInt(e[i[o]])?!0:!1
jQuery(this).find(".supercarousel").supercarousel(e)}})}),jQuery.expr[":"].hiddenByParent=function(e){return jQuery(e).parents("*:not(:visible)").length}


/*jquery.easing*/
jQuery.easing.jswing=jQuery.easing.swing;jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,f,a,h,g){return jQuery.easing[jQuery.easing.def](e,f,a,h,g)},easeInQuad:function(e,f,a,h,g){return h*(f/=g)*f+a},easeOutQuad:function(e,f,a,h,g){return -h*(f/=g)*(f-2)+a},easeInOutQuad:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f+a}return -h/2*((--f)*(f-2)-1)+a},easeInCubic:function(e,f,a,h,g){return h*(f/=g)*f*f+a},easeOutCubic:function(e,f,a,h,g){return h*((f=f/g-1)*f*f+1)+a},easeInOutCubic:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f+a}return h/2*((f-=2)*f*f+2)+a},easeInQuart:function(e,f,a,h,g){return h*(f/=g)*f*f*f+a},easeOutQuart:function(e,f,a,h,g){return -h*((f=f/g-1)*f*f*f-1)+a},easeInOutQuart:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f+a}return -h/2*((f-=2)*f*f*f-2)+a},easeInQuint:function(e,f,a,h,g){return h*(f/=g)*f*f*f*f+a},easeOutQuint:function(e,f,a,h,g){return h*((f=f/g-1)*f*f*f*f+1)+a},easeInOutQuint:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f*f+a}return h/2*((f-=2)*f*f*f*f+2)+a},easeInSine:function(e,f,a,h,g){return -h*Math.cos(f/g*(Math.PI/2))+h+a},easeOutSine:function(e,f,a,h,g){return h*Math.sin(f/g*(Math.PI/2))+a},easeInOutSine:function(e,f,a,h,g){return -h/2*(Math.cos(Math.PI*f/g)-1)+a},easeInExpo:function(e,f,a,h,g){return(f==0)?a:h*Math.pow(2,10*(f/g-1))+a},easeOutExpo:function(e,f,a,h,g){return(f==g)?a+h:h*(-Math.pow(2,-10*f/g)+1)+a},easeInOutExpo:function(e,f,a,h,g){if(f==0){return a}if(f==g){return a+h}if((f/=g/2)<1){return h/2*Math.pow(2,10*(f-1))+a}return h/2*(-Math.pow(2,-10*--f)+2)+a},easeInCirc:function(e,f,a,h,g){return -h*(Math.sqrt(1-(f/=g)*f)-1)+a},easeOutCirc:function(e,f,a,h,g){return h*Math.sqrt(1-(f=f/g-1)*f)+a},easeInOutCirc:function(e,f,a,h,g){if((f/=g/2)<1){return -h/2*(Math.sqrt(1-f*f)-1)+a}return h/2*(Math.sqrt(1-(f-=2)*f)+1)+a},easeInElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return -(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e},easeOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return g*Math.pow(2,-10*h)*Math.sin((h*k-i)*(2*Math.PI)/j)+l+e},easeInOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k/2)==2){return e+l}if(!j){j=k*(0.3*1.5)}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}if(h<1){return -0.5*(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e}return g*Math.pow(2,-10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j)*0.5+l+e},easeInBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*(f/=h)*f*((g+1)*f-g)+a},easeOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*((f=f/h-1)*f*((g+1)*f+g)+1)+a},easeInOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}if((f/=h/2)<1){return i/2*(f*f*(((g*=(1.525))+1)*f-g))+a}return i/2*((f-=2)*f*(((g*=(1.525))+1)*f+g)+2)+a},easeInBounce:function(e,f,a,h,g){return h-jQuery.easing.easeOutBounce(e,g-f,0,h,g)+a},easeOutBounce:function(e,f,a,h,g){if((f/=g)<(1/2.75)){return h*(7.5625*f*f)+a}else{if(f<(2/2.75)){return h*(7.5625*(f-=(1.5/2.75))*f+0.75)+a}else{if(f<(2.5/2.75)){return h*(7.5625*(f-=(2.25/2.75))*f+0.9375)+a}else{return h*(7.5625*(f-=(2.625/2.75))*f+0.984375)+a}}}},easeInOutBounce:function(e,f,a,h,g){if(f<g/2){return jQuery.easing.easeInBounce(e,f*2,0,h,g)*0.5+a}return jQuery.easing.easeOutBounce(e,f*2-g,0,h,g)*0.5+h*0.5+a}});

/*jquery.easing.compatibility*/
jQuery.extend(jQuery.easing,{easeIn:function(e,t,i,o,s){return jQuery.easing.easeInQuad(e,t,i,o,s)},easeOut:function(e,t,i,o,s){return jQuery.easing.easeOutQuad(e,t,i,o,s)},easeInOut:function(e,t,i,o,s){return jQuery.easing.easeInOutQuad(e,t,i,o,s)},expoin:function(e,t,i,o,s){return jQuery.easing.easeInExpo(e,t,i,o,s)},expoout:function(e,t,i,o,s){return jQuery.easing.easeOutExpo(e,t,i,o,s)},expoinout:function(e,t,i,o,s){return jQuery.easing.easeInOutExpo(e,t,i,o,s)},bouncein:function(e,t,i,o,s){return jQuery.easing.easeInBounce(e,t,i,o,s)},bounceout:function(e,t,i,o,s){return jQuery.easing.easeOutBounce(e,t,i,o,s)},bounceinout:function(e,t,i,o,s){return jQuery.easing.easeInOutBounce(e,t,i,o,s)},elasin:function(e,t,i,o,s){return jQuery.easing.easeInElastic(e,t,i,o,s)},elasout:function(e,t,i,o,s){return jQuery.easing.easeOutElastic(e,t,i,o,s)},elasinout:function(e,t,i,o,s){return jQuery.easing.easeInOutElastic(e,t,i,o,s)},backin:function(e,t,i,o,s){return jQuery.easing.easeInBack(e,t,i,o,s)},backout:function(e,t,i,o,s){return jQuery.easing.easeOutBack(e,t,i,o,s)},backinout:function(e,t,i,o,s){return jQuery.easing.easeInOutBack(e,t,i,o,s)}});


/*jquery.feedify*/
(function(e){e.extend({feedify:function(t,n){var r={lt:{regex:/(<)/g,template:"&lt;"},gt:{regex:/(>)/g,template:"&gt;"},dq:{regex:/(")/g,template:"&quot;"},sq:{regex:/(')/g,template:"&#x27;"},link:{regex:/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig,template:'<a href="$1">$1</a>'},user:{regex:/((?:^|[^a-zA-Z0-9_!#$%&*@＠]|RT:?))([@＠])([a-zA-Z0-9_]{1,20})(\/[a-zA-Z][a-zA-Z0-9_-]{0,24})?/g,template:'$1<a href="http://twitter.com/#!/$3$4">@$3$4</a>'},hash:{regex:/(^|\s)#(\w+)/g,template:'$1<a href="http://twitter.com/#!/search?q=%23$2">#$2</a>'},email:{regex:/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi,template:'<a href="mailto:$1">$1</a>'}};var i=e.extend(r,n);e.each(i,function(e,n){t=t.replace(n.regex,n.template)});return t}})})(jQuery);


/*jquery.framerate*/
jQuery.fn.framerate=function(e){var t=jQuery.extend({framerate:30,logframes:!1},e),i=Math.floor(1e3/t.framerate)
jQuery.extend(jQuery.fx.prototype,{custom:function(e,t,o){function s(e){return n.step(e)}this.startTime=(new Date).getTime(),this.start=e,this.end=t,this.unit=o||this.unit||"px",this.now=this.start,this.pos=this.state=0
var n=this
s.elem=this.elem,void 0===jQuery.timerId&&(jQuery.timerId=!1),s()&&jQuery.timers.push(s)&&!jQuery.timerId&&(jQuery.timerId=setInterval(jQuery.fx.tick,i))}})
var o=(new Date).getTime()
jQuery.extend(jQuery.fx,{tick:function(){if(t.logframes){var e=(new Date).getTime()
console.log(Math.floor(1e3/(e-o))),o=e}for(var i=jQuery.timers,s=0;s<i.length;s++)i[s]()||i.splice(s--,1)
i.length||jQuery.fx.stop()},stop:function(){clearInterval(jQuery.timerId),jQuery.timerId=null}})}


/*jquery.ismouseover*/
!function(e){function t(){var t=e(this)
t.mousemove(function(e){jQuery.mlp={x:e.pageX,y:e.pageY}})}e.mlp={x:0,y:0},e(t),e.fn.ismouseover=function(t){var i=!1
return this.eq(0).each(function(){var t=e(this),o=t.offset()
i=o.left<=e.mlp.x&&o.left+t.outerWidth()>e.mlp.x&&o.top<=e.mlp.y&&o.top+t.outerHeight()>e.mlp.y}),i}}(jQuery);


/*jquery.mousewheel*/
!function(e){function t(t){var i=t||window.event,o=[].slice.call(arguments,1),s=0,n=0,a=0
return t=e.event.fix(i),t.type="mousewheel",i.wheelDelta&&(s=i.wheelDelta/120),i.detail&&(s=-i.detail/3),a=s,void 0!==i.axis&&i.axis===i.HORIZONTAL_AXIS&&(a=0,n=-1*s),void 0!==i.wheelDeltaY&&(a=i.wheelDeltaY/120),void 0!==i.wheelDeltaX&&(n=-1*i.wheelDeltaX/120),o.unshift(t,s,n,a),(e.event.dispatch||e.event.handle).apply(this,o)}var i=["DOMMouseScroll","mousewheel"]
if(e.event.fixHooks)for(var o=i.length;o;)e.event.fixHooks[i[--o]]=e.event.mouseHooks
e.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var e=i.length;e;)this.addEventListener(i[--e],t,!1)
else this.onmousewheel=t},teardown:function(){if(this.removeEventListener)for(var e=i.length;e;)this.removeEventListener(i[--e],t,!1)
else this.onmousewheel=null}},e.fn.extend({mousewheel:function(e){return e?this.bind("mousewheel",e):this.trigger("mousewheel")},unmousewheel:function(e){return this.unbind("mousewheel",e)}})}(jQuery);


/*jquery.superlightbox*/
/*
 * jQuery SuperLightBox Plugin v1.0
 * Copyright (C) 2017 Taraprasad Swain
 * Author URL: http://www.taraprasad.com
 * Email: swain.tara@gmail.com
 */
jQuery.fn.superLightBox=function(e){var t,o,r,i,a={gallery:!0,swipe:!0,keyboard:!0,closeOutClick:!0,videopreviewurl:"images/video-preview.jpg",galleryThumbnailWidth:100,galleryThumbanilGap:1,maxZoom:3,mediaAttribute:"href",mediaCaption:"data-superlightcaption"},n=[],s=[],l=[],p=[],d=0,c=0,u=0,g=jQuery.extend({},a,e)
g.keyboard&&jQuery(document).keyup(function(e){jQuery(".superlightboxcontainer").length&&jQuery(".superlightboxcontainer").hasClass(i)&&(e.preventDefault(),27==e.keyCode?f():37==e.keyCode||38==e.keyCode?y(t-1):(39==e.keyCode||40==e.keyCode)&&y(t+1))}),jQuery(window).resize(function(){jQuery(".superlightboxcontainer").length&&jQuery(".superlightboxcontainer").hasClass(i)&&(S(),v())})
var m=function(e){var o=e.attr("href")
if(n.indexOf(o)>-1){t=n.indexOf(o),jQuery(".superlightboxcontainer").length&&jQuery(".superlightboxcontainer").remove(),jQuery("body").append(O())
var r='<div class="superlightbox_slide"></div>'
jQuery(".superlightbox_slider").append(r),jQuery(".superlightbox_slider").append(r),jQuery(".superlightbox_slider").append(r),g.gallery&&n.length>1&&_(),jQuery(".superlightboxcontainer").fadeIn(),x(),y(t)}},_=function(){var e=""
for(var t in n)e+=b(n[t],t)
jQuery(".superlightbox_gallery_wrapper").append(e)
var o=0
jQuery(".superlightbox_gallery_wrapper > div").each(function(e){var t=e*g.galleryThumbnailWidth+e*g.galleryThumbanilGap
o=t,jQuery(this).css({left:t})}),o+=g.galleryThumbnailWidth,jQuery(".superlightbox_gallery_wrapper").width(o)},h=function(e){if(jQuery(".superlightboxcontainer").length){var t=jQuery(window).width()
if(jQuery(".superlightbox_gallery_wrapper").width()>t){var o=parseInt(jQuery(".superlightbox_gallery_wrapper").position().left),r=o-e*t,i=-jQuery(".superlightbox_gallery_wrapper").width()+t
i>r?r=i:r>0&&(r=0),jQuery(".superlightbox_gallery_wrapper").animate({left:r},g.easingTime,function(){})}}},v=function(){if(jQuery(".superlightboxcontainer").length&&g.gallery){if(jQuery(window).width()>jQuery(".superlightbox_gallery_wrapper").width()){var e=(jQuery(window).width()-jQuery(".superlightbox_gallery_wrapper").width())/2
jQuery(".superlightbox_gallery_wrapper").css({left:e})}else jQuery(".superlightbox_gallery_wrapper").css({left:0})
jQuery(".superlightbox_gallery_wrapper").is(":visible")?jQuery(".superlightbox_gallery_nav").show():jQuery(".superlightbox_gallery_nav").hide()}},b=function(e,t){var o=R(e),r="",i=""
"image"==o?r=e:"youtube"==o?(r=N(e),i=" superlightbox_video"+U(e)):"vimeo"==o&&(r=g.videopreviewurl,I(e),i=" superlightbox_video"+D(e))
var a='<div class="superlightbox_thumb'+t+i+'" style="background-image: url(\''+r+"')\"></div>"
return a},f=function(){if(jQuery(".superlightboxcontainer").length){var e=jQuery(".superlightbox_slide"+t)
e.length&&e.addClass("superlightbox_remove"),jQuery(".superlightboxcontainer").fadeOut("slow",function(){jQuery(this).remove()})}},x=function(){jQuery(".superlightboxcontainer").length&&(jQuery(".superlightbox_close").click(function(){f()}),g.closeOutClick&&jQuery(".superlightbox_slider").click(function(e){"IMG"!=e.target.nodeName&&f()}),jQuery(".superlightbox_prev").click(function(){y(t-1)}),jQuery(".superlightbox_next").click(function(){y(t+1)}),g.gallery&&(jQuery(".superlightbox_gallery_button").click(function(){jQuery(this).hasClass("superlightbox_gallery_open")?(jQuery(this).removeClass("superlightbox_gallery_open"),jQuery(this).addClass("superlightbox_gallery_close"),jQuery(".superlightbox_gallery_wrapper").slideDown(),jQuery(".superlightbox_slider").addClass("superlightbox_gallery_visible"),v()):(jQuery(this).removeClass("superlightbox_gallery_close"),jQuery(this).addClass("superlightbox_gallery_open"),jQuery(".superlightbox_gallery_wrapper").slideUp(),jQuery(".superlightbox_gallery_nav").hide(),jQuery(".superlightbox_slider").removeClass("superlightbox_gallery_visible"))}),jQuery(".superlightbox_gallery_prev").click(function(){h(-1)}),jQuery(".superlightbox_gallery_next").click(function(){h(1)}),jQuery(".superlightbox_gallery_wrapper > div").click(function(){y(jQuery(this).index())}),g.swipe&&H(".superlightbox_gallery_wrapper",{swipeStart:function(e){d=jQuery(".superlightbox_gallery_wrapper").position().left},swipe:function(e){jQuery(window).width()
jQuery(".superlightbox_gallery_wrapper").css({left:e.eX-e.sX+d})},swipeEnd:function(e,t){var o=(Math.abs(e.sX)-Math.abs(e.eX),jQuery(window).width()),r=jQuery(".superlightbox_gallery_wrapper").width()
if(o>r){var i=(o-r)/2
jQuery(".superlightbox_gallery_wrapper").animate({left:i},g.easingTime)}else jQuery(".superlightbox_gallery_wrapper").position().left>0?jQuery(".superlightbox_gallery_wrapper").animate({left:0},g.easingTime):jQuery(".superlightbox_gallery_wrapper").position().left<-r+o&&jQuery(".superlightbox_gallery_wrapper").animate({left:-r+o},g.easingTime)}})),g.swipe&&H(".superlightbox_wrapper",{pinchImage:".superlightbox_slider > div:eq(1) img",maxZoom:g.maxZoom,pinchZoom:function(e){jQuery(".superlightbox_slider > div:eq(1) img").css(e)},pinchZoomStart:function(e){jQuery(".superlightbox_slider").addClass("superlightbox_sliding")},pinchZoomEnd:function(e){jQuery(".superlightbox_slider").removeClass("superlightbox_sliding"),Q()},swipeStart:function(e){jQuery(".superlightbox_slider").addClass("superlightbox_sliding")},swipe:function(e){var t=jQuery(window).width()
jQuery(".superlightbox_slider").css({left:-t+e.eX-e.sX})},swipeEnd:function(e,o){var r=Math.abs(e.sX)-Math.abs(e.eX),i=jQuery(window).width(),a=.2*i
if(Math.abs(r)>a)y(r>0?t+1:t-1)
else{var i=jQuery(window).width()
jQuery(".superlightbox_slider").animate({left:-i},g.easingTime,function(){jQuery(".superlightbox_slider").removeClass("superlightbox_sliding")})}}}))},y=function(e){var i="right"
t>e&&(i="left"),0>e||e==n.length-1?(e=n.length-1,o=e-1,r=0):e>=n.length||0==e?(e=0,o=n.length-1,r=1):(o=e-1,r=e+1)
var a,s=P(e),l=1
return e==t?void(0==jQuery(".superlightbox_slider > div.superlightbox_slide"+e).length&&(jQuery(".superlightbox_slider > div:first").replaceWith(P(o)),jQuery(".superlightbox_slider > div:eq(1)").replaceWith(s),jQuery(".superlightbox_slider > div:last").replaceWith(P(r)),E(o),E(e),E(r),Q())):("left"==i?(a=jQuery(".superlightbox_slider > div:first"),l=-1):a=jQuery(".superlightbox_slider > div:last"),a.hasClass("superlightbox_slide"+e)||(a.replaceWith(s),E(e),Q()),w(l),void(t=e))},w=function(e){if(jQuery(".superlightboxcontainer").length&&3==jQuery(".superlightbox_slider > div").length){var t=jQuery(window).width(),o=0
e>0&&(o=-2*t),jQuery(".superlightbox_slider").addClass("superlightbox_sliding"),jQuery(".superlightbox_slider").animate({left:o},g.easingTime,k)}},k=function(){var e=".superlightbox_slider > .superlightbox_slide"+t,i=".superlightbox_slider > .superlightbox_slide"+r,a=".superlightbox_slider > .superlightbox_slide"+o
jQuery(".superlightbox_slider > div").not(e+","+i+","+a).remove(),jQuery(e).length>1&&(0==jQuery(".superlightbox_slider").position().left?jQuery(e+":last").remove():jQuery(e+":first").remove()),jQuery(a).length>1&&jQuery(a+":last").remove(),jQuery(i).length>1&&jQuery(i+":first").remove(),jQuery(".superlightbox_slider > div:first").hasClass("superlightbox_slide"+o)||(jQuery(a).remove(),jQuery(".superlightbox_slider").prepend(P(o)),E(o)),jQuery(".superlightbox_slider > div:last").hasClass("superlightbox_slide"+r)||(jQuery(i).remove(),jQuery(".superlightbox_slider").append(P(r)),E(r)),jQuery(".superlightbox_slider").removeClass("superlightbox_sliding"),Q(),j(t)},S=function(){j(o),j(t),j(r),Q()},j=function(e){if(jQuery(".superlightboxcontainer").length){var o=jQuery(window).height(),r=jQuery(window).width()
if(l[e]){e==t&&(u=0,c=0)
var i=jQuery(".superlightbox_slide"+e),a=l[e],n=p[e],s=parseInt(a*r),d=parseInt(n*o)
s>o?(i.find("img").css({height:o,width:d,left:"50%",top:"50%"}),jQuery(".superlightbox_slide"+e).find(".superlightbox_caption").length&&jQuery(".superlightbox_slide"+e).find(".superlightbox_caption").css({"max-width":d})):(i.find("img").css({width:r,height:s,left:"50%",top:"50%"}),jQuery(".superlightbox_slide"+e).find(".superlightbox_caption").length&&jQuery(".superlightbox_slide"+e).find(".superlightbox_caption").css({"max-width":r}))}else jQuery(".superlightbox_slide"+e).find(".superlightbox_embed_wrapper").length&&(jQuery(".superlightbox_slide"+e).find(".superlightbox_embed_wrapper").css({"max-width":parseInt(1.77*o)}),jQuery(".superlightbox_slide"+e).find(".superlightbox_caption").length&&jQuery(".superlightbox_slide"+e).find(".superlightbox_caption").css({"max-width":parseInt(1.77*o)}))}},Q=function(){var e=jQuery(window).width()
jQuery(".superlightbox_slider > div").each(function(t){jQuery(this).css({left:t*e,width:e})}),jQuery(".superlightbox_slider").css({left:-e,width:3*e})},P=function(e){if(!n[e])return""
var t,o=n[e],r=R(o)
return"image"==r?t='<div class="superlightbox_slide superlightbox_slide'+e+' superloading">':"youtube"==r?(t='<div class="superlightbox_slide superlightbox_slide_video superlightbox_slide'+e+'">',t+=A(o)):"vimeo"==r&&(t='<div class="superlightbox_slide superlightbox_slide_video superlightbox_slide'+e+'">',t+=W(o)),""!=s[e]&&(t+='<div class="superlightbox_caption">'+s[e]+"</div>"),t+="</div>"},E=function(e){var t=n[e],o=R(t)
if("image"!=o)return void j(e)
var r=new Image
r.superindex=e,r.onload=T,r.src=t},T=function(){if(void 0!==this.superindex&&jQuery(".superlightbox_slide"+this.superindex).length){var e=jQuery(".superlightbox_slide"+this.superindex),t=""
""!=s[this.superindex]&&(t='<div class="superlightbox_caption">'+s[this.superindex]+"</div>"),e.html('<img src="'+this.src+'" />'+t),l[this.superindex]=this.naturalHeight/this.naturalWidth,p[this.superindex]=this.naturalWidth/this.naturalHeight,j(this.superindex),setTimeout(function(){e.removeClass("superloading")},800)}},R=function(e){var t=e.split(".").reverse()[0].toLowerCase()
return jQuery.inArray(t,["jpg","jpeg","png","gif"])>-1?"image":$(e)?"youtube":C(e)?"vimeo":""},C=function(e){var t=/\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i,o=t.exec(e)
return o&&o[1]},$=function(e){var t=/\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9_\-]+)/i,o=t.exec(e)
return o&&o[1]},A=function(e){var t=U(e)
return'<div class="superlightbox_embed_wrapper"><div class="superlightbox_embed"><iframe width="560" height="315" src="//www.youtube.com/embed/'+t+'" frameborder="0" allowfullscreen></iframe></div></div>'},U=function(e){var t=e.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/)
return null!=t?t[1]:""},N=function(e){var t=U(e)
return"https://img.youtube.com/vi/"+t+"/0.jpg"},W=function(e){var t=/(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(\S+)/g
if(t.test(e))var o='<div class="superlightbox_embed_wrapper"><div class="superlightbox_embed"><iframe width="420" height="345" src="//player.vimeo.com/video/$1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div></div>',e=e.replace(t,o)
return e},I=function(e){var t=D(e)
jQuery.ajax({type:"GET",url:"http://vimeo.com/api/v2/video/"+t+".json",jsonp:"callback",dataType:"jsonp",success:function(e){if(jQuery(".superlightbox_video"+e[0].id).length){var t=e[0].thumbnail_large
jQuery(".superlightbox_video"+e[0].id).css({"background-image":"url('"+t+"')"})}}})},D=function(e){var t=e.match(/^.+vimeo.com\/(.*\/)?([^#\?]*)/)
return t?t[2]||t[1]:null},O=function(){return'<div class="superlightboxcontainer '+i+'" style="display:none;"><a href="javascript: void(0);" class="superlightbox_close"></a><div class="superlightbox_wrapper"><div class="superlightbox_slider"></div></div><div class="superlightbox_gallery"><a href="javascript: void(0);" class="superlightbox_gallery_button superlightbox_gallery_open"></a><a href="javascript: void(0);" class="superlightbox_gallery_nav superlightbox_gallery_prev" style="display: none;"></a><a href="javascript: void(0);" class="superlightbox_gallery_nav superlightbox_gallery_next" style="display: none;"></a><div class="superlightbox_gallery_wrapper" style="display: none;"></div></div><a href="javascript: void(0);" class="superlightbox_prev"></a><a href="javascript: void(0);" class="superlightbox_next"></a></div>'},M=function(e,t){t=t||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"
for(var o="",r=0;e>r;r++){var i=Math.floor(Math.random()*t.length)
o+=t.substring(i,i+1)}return o},H=function(e,t){var o={pinchImage:"",pinchZoom:function(e){},pinchZoomStart:function(){},pinchZoomEnd:function(){},swipe:function(e){},swipeLeft:function(e){},swipeRight:function(e){},swipeUp:function(e){},swipeDown:function(e){},swipeStart:function(e){},swipeEnd:function(e,t){},maxZoom:3},r=jQuery.extend({},o,t),i={},a=!1,n=!1
i.sX=0,i.sY=0,i.eX=0,i.eY=0
var s,l,p,d,g,m,_,h,v,b,f,x,y,w,k,S,j,Q,P,E,T,R,C,$,A,U,N,W,I=.1,D=20,O=40,M=40,H=50,z="",L=1,F=0,Y=0,X=c,B=u,q=jQuery(e)
q.on("touchstart",function(e){if(1==e.originalEvent.touches.length){a=!0,n=!1
var t=e.originalEvent.touches[0]
i.sX=t.screenX,i.sY=t.clientY,1==L?r.swipeStart(i):r.pinchZoomStart()}else if(2==e.originalEvent.touches.length){a=!1,n=!0
var o=jQuery(window).width()/2,g=jQuery(window).height()/2
0==c&&0==c&&(c=jQuery(r.pinchImage).width(),u=jQuery(r.pinchImage).height(),X=c,B=u,L=1,F=o-X,Y=g-B),s=e.originalEvent.touches[0].clientX,l=e.originalEvent.touches[0].clientY,p=e.originalEvent.touches[1].clientX,d=e.originalEvent.touches[1].clientY,j=(s+p)/2,Q=(l+d)/2,N=(j-F)/X,W=(Q-Y)/B,v=Math.sqrt(Math.pow(p-s,2)+Math.pow(d-l,2)),r.pinchZoomStart()}}),q.on("touchmove",function(e){if(e.preventDefault(),a){var t=e.originalEvent.touches[0]
if(i.eX=t.screenX,i.eY=t.clientY,L>1){var o={}
o.left=F+X+(i.eX-i.sX),o.top=Y+B+(i.eY-i.sY),r.pinchZoom(o)}else r.swipe(i)}else if(n){g=e.originalEvent.touches[0].clientX,m=e.originalEvent.touches[0].clientY,_=e.originalEvent.touches[1].clientX,h=e.originalEvent.touches[1].clientY,b=Math.sqrt(Math.pow(_-g,2)+Math.pow(h-m,2)),f=b/v,x=f*L,w=c*x,y=u*x,P=(g+_)/2,E=(m+h)/2,T=(X-w)*N,R=(B-y)*W,C=-j+P,$=-Q+E,A=T+C,U=R+$,k=parseInt(F+A),S=parseInt(Y+U)
var o={}
o.left=k+w,o.top=S+y,o.width=w,o.height=y,r.pinchZoom(o)}}),q.on("touchend",function(e){if(a){if(L>1)return F+=i.eX-i.sX,void(Y+=i.eY-i.sY)
var t=jQuery(window).width(),o=jQuery(window).height()
D=t*I,M=o*I,(i.eX-D>i.sX||i.eX+D<i.sX)&&i.eY<i.sY+H&&i.sY>i.eY-H&&(z=i.eX>i.sX?"l":"r"),(i.eY-M>i.sY||i.eY+M<i.sY)&&i.eX<i.sX+O&&i.sX>i.eX-O&&(z=i.eY>i.sY?"d":"u"),""!=z&&("l"==z?r.swipeLeft(i):"r"==z?r.swipeRight(i):"u"==z?r.swipeUp(i):"d"==z&&r.swipeDown(i)),r.swipeEnd(i,z),z=""}else if(n){var s=jQuery(window).width()/2,l=jQuery(window).height()/2
if(1>x){x=1
var p={}
p.left="50%",p.top="50%",p.width=c,p.height=u,r.pinchZoom(p),k=s-c,S=l-u,w=c,y=u}else if(x>r.maxZoom){x=r.maxZoom,w=c*x,y=u*x,T=(X-w)*N,R=(B-y)*W,C=-j+P,$=-Q+E,A=T+C,U=R+$,k=parseInt(F+A),S=parseInt(Y+U)
var p={}
p.left=k+w,p.top=S+y,p.width=w,p.height=y,r.pinchZoom(p)}F=k,Y=S,X=w,B=y,L=x,r.pinchZoomEnd()}a=!1,n=!1}),q.on("touchcancel",function(e){a=!1,n=!1})}
return i=M(10),this.each(function(){var e=jQuery(this),t=e.attr(g.mediaAttribute)
if(jQuery.inArray(t,n)<0){n.push(t)
var o=void 0!==e.attr(g.mediaCaption)?e.attr(g.mediaCaption):""
s.push(o)}e.click(function(e){e.preventDefault(),m(jQuery(this))})})}


