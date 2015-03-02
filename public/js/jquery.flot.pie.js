(function(d){function f(Z){var am=null;var b=null;var ah=null;var ad=null;var af=null;var a=0;var V=true;var ag=10;var R=0.95;var ae=0;var aq=false;var N=false;var al=[];Z.hooks.processOptions.push(an);Z.hooks.bindEvents.push(ap);function an(g,h){if(h.series.pie.show){h.grid.show=false;if(h.series.pie.label.show=="auto"){if(h.legend.show){h.series.pie.label.show=false}else{h.series.pie.label.show=true}}if(h.series.pie.radius=="auto"){if(h.series.pie.label.show){h.series.pie.radius=3/4}else{h.series.pie.radius=1}}if(h.series.pie.tilt>1){h.series.pie.tilt=1}if(h.series.pie.tilt<0){h.series.pie.tilt=0}g.hooks.processDatapoints.push(X);g.hooks.drawOverlay.push(Q);g.hooks.draw.push(ab)}}function ap(g,j){var h=g.getOptions();if(h.series.pie.show&&h.grid.hoverable){j.unbind("mousemove").mousemove(W)}if(h.series.pie.show&&h.grid.clickable){j.unbind("click").click(aj)}}function T(h){var g="";function j(l,k){if(!k){k=0}for(var m=0;m<l.length;++m){for(var n=0;n<k;n++){g+="\t"}if(typeof l[m]=="object"){g+=""+m+":\n";j(l[m],k+1)}else{g+=""+m+": "+l[m]+"\n"}}}j(h);alert(g)}function ac(g){for(var j=0;j<g.length;++j){var h=parseFloat(g[j].data[0][1]);if(h){a+=h}}}function X(g,k,j,h){if(!aq){aq=true;am=g.getCanvas();b=d(am).parent();e=g.getOptions();g.setData(c(g.getData()))}}function P(){ae=b.children().filter(".legend").children().width();ah=Math.min(am.width,(am.height/e.series.pie.tilt))/2;af=(am.height/2)+e.series.pie.offset.top;ad=(am.width/2);if(e.series.pie.offset.left=="auto"){if(e.legend.position.match("w")){ad+=ae/2}else{ad-=ae/2}}else{ad+=e.series.pie.offset.left}if(ad<ah){ad=ah}else{if(ad>am.width-ah){ad=am.width-ah}}}function S(g){for(var h=0;h<g.length;++h){if(typeof(g[h].data)=="number"){g[h].data=[[1,g[h].data]]}else{if(typeof(g[h].data)=="undefined"||typeof(g[h].data[0])=="undefined"){if(typeof(g[h].data)!="undefined"&&typeof(g[h].data.label)!="undefined"){g[h].label=g[h].data.label}g[h].data=[[1,0]]}}}return g}function c(j){j=S(j);ac(j);var k=0;var g=0;var m=e.series.pie.combine.color;var h=[];for(var l=0;l<j.length;++l){j[l].data[0][1]=parseFloat(j[l].data[0][1]);if(!j[l].data[0][1]){j[l].data[0][1]=0}if(j[l].data[0][1]/a<=e.series.pie.combine.threshold){k+=j[l].data[0][1];g++;if(!m){m=j[l].color}}else{h.push({data:[[1,j[l].data[0][1]]],color:j[l].color,label:j[l].label,angle:(j[l].data[0][1]*(Math.PI*2))/a,percent:(j[l].data[0][1]/a*100)})}}if(g>0){h.push({data:[[1,k]],color:m,label:e.series.pie.combine.label,angle:(k*(Math.PI*2))/a,percent:(k/a*100)})}return h}function ab(h,k){if(!b){return}ctx=k;P();var g=h.getData();var l=0;V=true;while(V&&l<ag){V=false;if(l>0){ah*=R}l+=1;n();if(e.series.pie.tilt<=0.8){m()}j()}if(l>=ag){n();b.prepend('<div class="error">Could not draw pie with labels contained inside canvas</div>')}if(h.setSeries&&h.insertLegend){h.setSeries(g);h.insertLegend()}function n(){ctx.clearRect(0,0,am.width,am.height);b.children().filter(".pieLabel, .pieLabelBackground").remove()}function m(){var r=5;var s=15;var o=10;var t=0.02;if(e.series.pie.radius>1){var q=e.series.pie.radius}else{var q=ah*e.series.pie.radius}if(q>=(am.width/2)-r||q*e.series.pie.tilt>=(am.height/2)-s||q<=o){return}ctx.save();ctx.translate(r,s);ctx.globalAlpha=t;ctx.fillStyle="#000";ctx.translate(ad,af);ctx.scale(1,e.series.pie.tilt);for(var p=1;p<=o;p++){ctx.beginPath();ctx.arc(0,0,q,0,Math.PI*2,false);ctx.fill();q-=p}ctx.restore()}function j(){startAngle=Math.PI*e.series.pie.startAngle;if(e.series.pie.radius>1){var q=e.series.pie.radius}else{var q=ah*e.series.pie.radius}ctx.save();ctx.translate(ad,af);ctx.scale(1,e.series.pie.tilt);ctx.save();var r=startAngle;for(var o=0;o<g.length;++o){g[o].startAngle=r;s(g[o].angle,g[o].color,true)}ctx.restore();ctx.save();ctx.lineWidth=e.series.pie.stroke.width;r=startAngle;for(var o=0;o<g.length;++o){s(g[o].angle,e.series.pie.stroke.color,false)}ctx.restore();O(ctx);if(e.series.pie.label.show){p()}ctx.restore();function s(t,v,u){if(t<=0){return}if(u){ctx.fillStyle=v}else{ctx.strokeStyle=v;ctx.lineJoin="round"}ctx.beginPath();if(Math.abs(t-Math.PI*2)>1e-9){ctx.moveTo(0,0)}else{if(d.browser.msie){t-=0.0001}}ctx.arc(0,0,q,r,r+t,false);ctx.closePath();r+=t;if(u){ctx.fill()}else{ctx.stroke()}}function p(){var t=startAngle;if(e.series.pie.label.radius>1){var w=e.series.pie.label.radius}else{var w=ah*e.series.pie.label.radius}for(var u=0;u<g.length;++u){if(g[u].percent>=e.series.pie.label.threshold*100){v(g[u],t,u)}t+=g[u].angle}function v(B,I,K){if(B.data[0][1]==0){return}var z=e.legend.labelFormatter,A,M=e.series.pie.label.formatter;if(z){A=z(B.label,B)}else{A=B.label}if(M){A=M(A,B)}var H=((I+B.angle)+I)/2;var C=ad+Math.round(Math.cos(H)*w);var E=af+Math.round(Math.sin(H)*w)*e.series.pie.tilt;var L='<span class="pieLabel" id="pieLabel'+K+'" style="position:absolute;top:'+E+"px;left:"+C+'px;">'+A+"</span>";b.append(L);var D=b.children("#pieLabel"+K);var ar=(E-D.height()/2);var J=(C-D.width()/2);D.css("top",ar);D.css("left",J);if(0-ar>0||0-J>0||am.height-(ar+D.height())<0||am.width-(J+D.width())<0){V=true}if(e.series.pie.label.background.opacity!=0){var G=e.series.pie.label.background.color;if(G==null){G=B.color}var F="top:"+ar+"px;left:"+J+"px;";d('<div class="pieLabelBackground" style="position:absolute;width:'+D.width()+"px;height:"+D.height()+"px;"+F+"background-color:"+G+';"> </div>').insertBefore(D).css("opacity",e.series.pie.label.background.opacity)}}}}}function O(g){if(e.series.pie.innerRadius>0){g.save();innerRadius=e.series.pie.innerRadius>1?e.series.pie.innerRadius:ah*e.series.pie.innerRadius;g.globalCompositeOperation="destination-out";g.beginPath();g.fillStyle=e.series.pie.stroke.color;g.arc(0,0,innerRadius,0,Math.PI*2,false);g.fill();g.closePath();g.restore();g.save();g.beginPath();g.strokeStyle=e.series.pie.stroke.color;g.arc(0,0,innerRadius,0,Math.PI*2,false);g.stroke();g.closePath();g.restore()}}function Y(j,h){for(var g=false,k=-1,m=j.length,l=m-1;++k<m;l=k){((j[k][1]<=h[1]&&h[1]<j[l][1])||(j[l][1]<=h[1]&&h[1]<j[k][1]))&&(h[0]<(j[l][0]-j[k][0])*(h[1]-j[k][1])/(j[l][1]-j[k][1])+j[k][0])&&(g=!g)}return g}function U(j,l){var g=Z.getData(),m=Z.getOptions(),n=m.series.pie.radius>1?m.series.pie.radius:ah*m.series.pie.radius;for(var k=0;k<g.length;++k){var h=g[k];if(h.pie.show){ctx.save();ctx.beginPath();ctx.moveTo(0,0);ctx.arc(0,0,n,h.startAngle,h.startAngle+h.angle,false);ctx.closePath();x=j-ad;y=l-af;if(ctx.isPointInPath){if(ctx.isPointInPath(j-ad,l-af)){ctx.restore();return{datapoint:[h.percent,h.data],dataIndex:0,series:h,seriesIndex:k}}}else{p1X=(n*Math.cos(h.startAngle));p1Y=(n*Math.sin(h.startAngle));p2X=(n*Math.cos(h.startAngle+(h.angle/4)));p2Y=(n*Math.sin(h.startAngle+(h.angle/4)));p3X=(n*Math.cos(h.startAngle+(h.angle/2)));p3Y=(n*Math.sin(h.startAngle+(h.angle/2)));p4X=(n*Math.cos(h.startAngle+(h.angle/1.5)));p4Y=(n*Math.sin(h.startAngle+(h.angle/1.5)));p5X=(n*Math.cos(h.startAngle+h.angle));p5Y=(n*Math.sin(h.startAngle+h.angle));arrPoly=[[0,0],[p1X,p1Y],[p2X,p2Y],[p3X,p3Y],[p4X,p4Y],[p5X,p5Y]];arrPoint=[x,y];if(Y(arrPoly,arrPoint)){ctx.restore();return{datapoint:[h.percent,h.data],dataIndex:0,series:h,seriesIndex:k}}}ctx.restore()}}return null}function W(g){ai("plothover",g)}function aj(g){ai("plotclick",g)}function ai(p,j){var o=Z.offset(),l=parseInt(j.pageX-o.left),n=parseInt(j.pageY-o.top),g=U(l,n);if(e.grid.autoHighlight){for(var m=0;m<al.length;++m){var k=al[m];if(k.auto==p&&!(g&&k.series==g.series)){ao(k.series)}}}if(g){ak(g.series,p)}var h={pageX:j.pageX,pageY:j.pageY};b.trigger(p,[h,g])}function ak(h,g){if(typeof h=="number"){h=series[h]}var j=aa(h);if(j==-1){al.push({series:h,auto:g});Z.triggerRedrawOverlay()}else{if(!g){al[j].auto=false}}}function ao(g){if(g==null){al=[];Z.triggerRedrawOverlay()}if(typeof g=="number"){g=series[g]}var h=aa(g);if(h!=-1){al.splice(h,1);Z.triggerRedrawOverlay()}}function aa(g){for(var j=0;j<al.length;++j){var h=al[j];if(h.series==g){return j}}return -1}function Q(h,g){var j=h.getOptions();var l=j.series.pie.radius>1?j.series.pie.radius:ah*j.series.pie.radius;g.save();g.translate(ad,af);g.scale(1,j.series.pie.tilt);for(i=0;i<al.length;++i){k(al[i].series)}O(g);g.restore();function k(m){if(m.angle<0){return}g.fillStyle="rgba(255, 255, 255, "+j.series.pie.highlight.opacity+")";g.beginPath();if(Math.abs(m.angle-Math.PI*2)>1e-9){g.moveTo(0,0)}g.arc(0,0,l,m.startAngle,m.startAngle+m.angle,false);g.closePath();g.fill()}}}var e={series:{pie:{show:false,radius:"auto",innerRadius:0,startAngle:3/2,tilt:1,offset:{top:0,left:"auto"},stroke:{color:"#FFF",width:1},label:{show:"auto",formatter:function(b,a){return'<div style="font-size:x-small;text-align:center;padding:2px;color:'+a.color+';">'+b+"<br/>"+Math.round(a.percent)+"%</div>"},radius:1,background:{color:null,opacity:0},threshold:0},combine:{threshold:-1,color:null,label:"Other"},highlight:{opacity:0.5}}}};d.plot.plugins.push({init:f,options:e,name:"pie",version:"1.0"})})(jQuery);