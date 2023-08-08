import { j as jsx, a as jsxs, F as Fragment } from "../ssr.mjs";
import { Link } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function MenuMobileItem({ items }) {
  return items.map((item) => {
    return /* @__PURE__ */ jsx("li", { className: "nav-item {% if item.children %} dropdown {% endif %}", children: item.children ? /* @__PURE__ */ jsxs(Fragment, { children: [
      /* @__PURE__ */ jsx(
        "a",
        {
          className: "nav-link active dropdown-toggle text-dark",
          href: item.link,
          "data-toggle": "dropdown",
          children: item.label
        }
      ),
      /* @__PURE__ */ jsx("ul", { className: "dropdown-menu dropdown-menu-left", children: item.children.map((child) => /* @__PURE__ */ jsx("li", { children: /* @__PURE__ */ jsx(Link, { className: "dropdown-item text-dark", href: child.link, children: child.label }) })) })
    ] }) : /* @__PURE__ */ jsx(
      "a",
      {
        className: "nav-link active text-dark",
        href: item.link,
        children: item.label
      }
    ) });
  });
}
export {
  MenuMobileItem as default
};
