import{j as a,a as r,F as d,d as i}from"./app-13cc16b3.js";function s({items:n}){return n.map(e=>a("li",{className:"nav-item {% if item.children %} dropdown {% endif %}",children:e.children?r(d,{children:[a("a",{className:"nav-link active dropdown-toggle text-dark",href:e.link,"data-toggle":"dropdown",children:e.label}),a("ul",{className:"dropdown-menu dropdown-menu-left",children:e.children.map(l=>a("li",{children:a(i,{className:"dropdown-item text-dark",href:l.link,children:l.label})}))})]}):a("a",{className:"nav-link active text-dark",href:e.link,children:e.label})}))}export{s as default};
