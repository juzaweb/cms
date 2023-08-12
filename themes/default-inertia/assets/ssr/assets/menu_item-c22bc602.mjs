import { j as jsx, a as jsxs, F as Fragment } from "../ssr.mjs";
import { Link } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function MenuItem({ items }) {
  return items.map((item) => {
    return /* @__PURE__ */ jsx("li", { className: "nav-item" + (item.children ? " dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down" : ""), children: item.children ? /* @__PURE__ */ jsxs(Fragment, { children: [
      /* @__PURE__ */ jsx(
        Link,
        {
          className: "nav-link dropdown-toggle",
          href: item.link,
          id: `dropdown-${item.id}`,
          "data-toggle": "dropdown",
          "aria-haspopup": "true",
          "aria-expanded": "false",
          children: item.label
        }
      ),
      /* @__PURE__ */ jsx("ul", { className: "dropdown-menu megamenu", "aria-labelledby": `dropdown-${item.id}`, children: /* @__PURE__ */ jsx(MenuItem, { items: item.children }) })
    ] }) : /* @__PURE__ */ jsx(Link, { className: "nav-link", href: item.link, children: item.label }) }, item.id);
  });
}
export {
  MenuItem as default
};
