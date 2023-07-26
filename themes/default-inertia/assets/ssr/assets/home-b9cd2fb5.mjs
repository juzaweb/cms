import { j as jsx, a as jsxs } from "../ssr.mjs";
import { _ as __ } from "./functions-e021afb9.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
function home() {
  return /* @__PURE__ */ jsx("section", { className: "pt-0", children: /* @__PURE__ */ jsx("div", { className: "mt-4", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsxs("div", { className: "row", children: [
    /* @__PURE__ */ jsx("div", { className: "col-md-8", children: /* @__PURE__ */ jsxs("aside", { className: "wrapper__list__article", children: [
      /* @__PURE__ */ jsx("h4", { className: "border_section", children: __("Latest") }),
      /* @__PURE__ */ jsx("div", { className: "wrapp__list__article-responsive" })
    ] }) }),
    /* @__PURE__ */ jsx("div", { className: "col-md-4", children: /* @__PURE__ */ jsx("div", { className: "sticky-top" }) }),
    /* @__PURE__ */ jsx("div", { className: "mx-auto", children: /* @__PURE__ */ jsx("div", { className: "pagination-area", children: /* @__PURE__ */ jsx(
      "div",
      {
        className: "pagination wow fadeIn animated",
        "data-wow-duration": "2s",
        "data-wow-delay": "0.5s",
        style: "visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;"
      }
    ) }) }),
    /* @__PURE__ */ jsx("div", { className: "clearfix" })
  ] }) }) }) });
}
export {
  home as default
};
