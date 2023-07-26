import { j as jsx, a as jsxs } from "../ssr.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
function Search() {
  return /* @__PURE__ */ jsx("section", { children: /* @__PURE__ */ jsxs("div", { className: "container", children: [
    /* @__PURE__ */ jsxs("div", { className: "row", children: [
      /* @__PURE__ */ jsx("div", { className: "col-md-12", children: /* @__PURE__ */ jsx("aside", { className: "wrapper__list__article ", children: /* @__PURE__ */ jsx("div", { className: "row" }) }) }),
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
  ] }) });
}
export {
  Search as default
};
