import{r,j as a,a as s}from"./app-13cc16b3.js";import{_ as c}from"./functions-503419f4.js";import t from"./main-c1f7e2e7.js";import d from"./pagination-d2202422.js";import"./header-16ec2555.js";import"./primary-menu-139672a4.js";import"./menu_item-a66a5f3c.js";import"./footer-7b42e382.js";function f(){const[e,n]=r.useState(null);return a(t,{children:a("section",{className:"pt-0",children:a("div",{className:"mt-4",children:a("div",{className:"container",children:s("div",{className:"row",children:[a("div",{className:"col-md-8",children:s("aside",{className:"wrapper__list__article",children:[a("h4",{className:"border_section",children:c("Latest")}),s("div",{className:"wrapp__list__article-responsive",children:[e&&e.data.map(i=>{var l;return a("div",{className:"card__post card__post-list card__post__transition mt-30",children:s("div",{className:"row ",children:[a("div",{className:"col-md-5",children:a("div",{className:"card__post__transition",children:a("a",{href:i.url,children:a("img",{src:i.thumbnail,className:"img-fluid w-100",alt:i.title})})})}),a("div",{className:"col-md-7 my-auto pl-0",children:a("div",{className:"card__post__body ",children:s("div",{className:"card__post__content",children:[a("div",{className:"card__post__author-info mb-2",children:s("ul",{className:"list-inline",children:[a("li",{className:"list-inline-item",children:s("span",{className:"text-primary",children:[c("by")," ",(l=i.author)==null?void 0:l.name]})}),a("li",{className:"list-inline-item",children:a("span",{className:"text-dark text-capitalize",children:i.created_at})})]})}),s("div",{className:"card__post__title",children:[a("h5",{children:a("a",{href:i.url,children:i.title})}),a("p",{className:"d-none d-lg-block d-xl-block mb-0",children:i.description})]})]})})})]})})}),";"]})]})}),a("div",{className:"col-md-4",children:a("div",{className:"sticky-top"})}),a("div",{className:"mx-auto",children:a("div",{className:"pagination-area",children:a("div",{className:"pagination wow fadeIn animated","data-wow-duration":"2s","data-wow-delay":"0.5s",style:{visibility:"visible",animationDuration:"2s",animationDelay:"0.5s",animationName:"fadeIn"},children:a(d,{data:e})})})}),a("div",{className:"clearfix"})]})})})})})}export{f as default};