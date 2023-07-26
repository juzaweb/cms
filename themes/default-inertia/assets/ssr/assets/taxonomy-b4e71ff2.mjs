import { a as jsxs, j as jsx } from "../ssr.mjs";
import { _ as __ } from "./functions-e021afb9.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
function taxonomy({ taxonomy: taxonomy2 }) {
  return /* @__PURE__ */ jsxs("section", { children: [
    /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsx("div", { className: "row", children: /* @__PURE__ */ jsx("div", { className: "col-md-12", children: /* @__PURE__ */ jsxs("ul", { className: "breadcrumbs bg-light mb-4", children: [
      /* @__PURE__ */ jsx("li", { className: "breadcrumbs__item", children: /* @__PURE__ */ jsxs("a", { href: "{{ home_url() }}", className: "breadcrumbs__url", children: [
        /* @__PURE__ */ jsx("i", { className: "fa fa-home" }),
        " ",
        __("Home")
      ] }) }),
      /* @__PURE__ */ jsx("li", { className: "breadcrumbs__item breadcrumbs__item--current", children: taxonomy2.name })
    ] }) }) }) }),
    /* @__PURE__ */ jsxs("div", { className: "container", children: [
      /* @__PURE__ */ jsxs("div", { className: "row", children: [
        /* @__PURE__ */ jsx("div", { className: "col-md-8", children: /* @__PURE__ */ jsxs("aside", { className: "wrapper__list__article ", children: [
          /* @__PURE__ */ jsx("h4", { className: "border_section", children: taxonomy2.name }),
          /* @__PURE__ */ jsx("div", { className: "row" })
        ] }) }),
        /* @__PURE__ */ jsx("div", { className: "col-md-4", children: /* @__PURE__ */ jsx("div", { className: "sidebar-sticky" }) }),
        /* @__PURE__ */ jsx("div", { className: "clearfix" })
      ] }),
      /* @__PURE__ */ jsx("div", { className: "pagination-area", children: /* @__PURE__ */ jsx(
        "div",
        {
          className: "pagination wow fadeIn animated",
          "data-wow-duration": "2s",
          "data-wow-delay": "0.5s",
          style: "visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;"
        }
      ) })
    ] })
  ] });
}
export {
  taxonomy as default
};
