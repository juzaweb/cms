import{r as t,a as l,j as e,d as r}from"./app-64d736f9.js";import{_ as c}from"./functions-9df32527.js";import{g as m}from"./fetch-867237f9.js";function N({post:s}){const[n,d]=t.useState([]);return t.useEffect(()=>{m(s).then(a=>{d(a.data.data)})},[s.slug]),l("div",{className:"related-article",children:[e("h4",{children:c("you may also like")}),e("div",{className:"article__entry-carousel-three",children:n.map(a=>{var i;return e("div",{className:"item",children:l("div",{className:"article__entry",children:[e("div",{className:"article__image",children:e(r,{href:a.url,children:e("img",{src:a.thumbnail,alt:a.title,className:"img-fluid"})})}),l("div",{className:"article__content",children:[l("ul",{className:"list-inline",children:[e("li",{className:"list-inline-item",children:l("span",{className:"text-primary",children:[c("by")," ",(i=a.author)==null?void 0:i.name]})}),e("li",{className:"list-inline-item",children:e("span",{className:"text-dark text-capitalize",children:a.created_at})})]}),e("h5",{children:e(r,{href:a.url,children:a.title})})]})]})},a.id)})})]})}export{N as default};
