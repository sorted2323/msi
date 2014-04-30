/* YUI 3.9.1 (build 5852) Copyright 2013 Yahoo! Inc. http://yuilibrary.com/license/ */
YUI.add("event-delegate",function(e,t){function f(t,r,u,l){var c=n(arguments,0,!0),h=i(u)?u:null,p,d,v,m,g,y,b,w,E;if(s(t)){w=[];if(o(t))for(y=0,b=t.length;y<b;++y)c[0]=t[y],w.push(e.delegate.apply(e,c));else{c.unshift(null);for(y in t)t.hasOwnProperty(y)&&(c[0]=y,c[1]=t[y],w.push(e.delegate.apply(e,c)))}return new e.EventHandle(w)}p=t.split(/\|/),p.length>1&&(g=p.shift(),c[0]=t=p.shift()),d=e.Node.DOM_EVENTS[t],s(d)&&d.delegate&&(E=d.delegate.apply(d,arguments));if(!E){if(!t||!r||!u||!l)return;v=h?e.Selector.query(h,null,!0):u,!v&&i(u)&&(E=e.on("available",function(){e.mix(E,e.delegate.apply(e,c),!0)},u)),!E&&v&&(c.splice(2,2,v),E=e.Event._attach(c,{facade:!1}),E.sub.filter=l,E.sub._notify=f.notifySub)}return E&&g&&(m=a[g]||(a[g]={}),m=m[t]||(m[t]=[]),m.push(E)),E}var n=e.Array,r=e.Lang,i=r.isString,s=r.isObject,o=r.isArray,u=e.Selector.test,a=e.Env.evt.handles;f.notifySub=function(t,r,i){r=r.slice(),this.args&&r.push.apply(r,this.args);var s=f._applyFilter(this.filter,r,i),o,u,a,l;if(s){s=n(s),o=r[0]=new e.DOMEventFacade(r[0],i.el,i),o.container=e.one(i.el);for(u=0,a=s.length;u<a&&!o.stopped;++u){o.currentTarget=e.one(s[u]),l=this.fn.apply(this.context||o.currentTarget,r);if(l===!1)break}return l}},f.compileFilter=e.cached(function(e){return function(t,n){return u(t._node,e,n.currentTarget===n.target?null:n.currentTarget._node)}}),f._disabledRE=/^(?:button|input|select|textarea)$/i,f._applyFilter=function(t,n,r){var s=n[0],o=r.el,a=s.target||s.srcElement,l=[],c=!1;a.nodeType===3&&(a=a.parentNode);if(a.disabled&&f._disabledRE.test(a.nodeName))return l;n.unshift(a);if(i(t))while(a){c=a===o,u(a,t,c?null:o)&&l.push(a);if(c)break;a=a.parentNode}else{n[0]=e.one(a),n[1]=new e.DOMEventFacade(s,o,r);while(a){t.apply(n[0],n)&&l.push(a);if(a===o)break;a=a.parentNode,n[0]=e.one(a)}n[1]=s}return l.length<=1&&(l=l[0]),n.shift(),l},e.delegate=e.Event.delegate=f},"3.9.1",{requires:["node-base"]});
