import{q as f}from"./app-da694496.js";function m(a,t={}){let{trans:u}=f().props,e=a.replace("cms::app.","");return e?u[e]:a}function c(a){return a}function g(a){return"/admin-cp/"+a}function n(a){return a=a.replace("-","_"),a.split("_").map(t=>t.charAt(0).toUpperCase()+t.slice(1)).join(" ")}function d(a){return a.toLowerCase().replace(/[^a-z0-9\-]/ig,"-")}function _(a){return a.toLowerCase().replace(/[^a-z0-9_]/ig,"_")}function o(a){var t,u,e;if(a!=null&&a.data&&a.data.message)return{status:a.status,message:a.data.message};if((t=a==null?void 0:a.data)!=null&&t.data&&a.data.data.message)return{status:a.data.status,message:a.data.data.message};if(a!=null&&a.response){if(a.response.data.errors){let r="";return $.each(a.response.data.errors,function(i,s){return r=s[0],!1}),{status:!1,message:r,errors:a.response.data.errors}}return{status:!1,message:a.response.data.message}}if(a!=null&&a.responseJSON){if((u=a.responseJSON)!=null&&u.errors){let r="";return $.each(a.responseJSON.errors,function(i,s){return r=s[0],!1}),{status:!1,message:r}}else if((e=a.responseJSON)!=null&&e.message)return{status:!1,message:a.responseJSON.message}}if(a.message)return{status:!1,message:a.message.message}}export{m as _,n as a,g as b,_ as c,d,o as m,c as u};
