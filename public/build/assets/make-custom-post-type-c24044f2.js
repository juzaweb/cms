import{r as m,j as e,a as p,b as f}from"./app-172eccbe.js";import{a as g,m as i}from"./functions-3a6386bd.js";import h from"./post-type-form-f7b9acee.js";function j({module:l}){const[u,a]=m.useState(!1),[o,t]=m.useState(),d=r=>{r.preventDefault();let c=new FormData(r.target);return a(!0),f.post(g("dev-tools/plugin/"+l.name+"/make-post-type"),c,{headers:{"Content-Type":"application/json"}}).then(n=>{let s=i(n);a(!1),t(s),(s==null?void 0:s.status)===!0&&r.target.reset(),setTimeout(()=>{t(void 0)},2e3)}).catch(n=>{t(i(n)),a(!1),setTimeout(()=>{t(void 0)},2e3)}),!1};return e("div",{className:"row",children:p("div",{className:"col-md-12",children:[e("h5",{children:"Make Custom Post Type"}),o&&e("div",{className:`alert alert-${o.status?"success":"danger"} jw-message`,children:o.message}),e("form",{method:"POST",onSubmit:d,children:e(h,{buttonLoading:u})})]})})}export{j as default};
