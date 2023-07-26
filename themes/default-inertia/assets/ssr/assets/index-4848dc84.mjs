import { j as jsx, a as jsxs } from "../ssr.mjs";
import Main from "./main-187d38ba.mjs";
import Content from "./content-5eee3841.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
import "./header-513d9ecb.mjs";
import "./functions-e021afb9.mjs";
import "./footer-3e174a1c.mjs";
function Index({ title, posts }) {
  return /* @__PURE__ */ jsx(Main, { children: /* @__PURE__ */ jsx("section", { children: /* @__PURE__ */ jsxs("div", { className: "container", children: [
    /* @__PURE__ */ jsxs("div", { className: "row", children: [
      /* @__PURE__ */ jsx("div", { className: "col-md-8", children: /* @__PURE__ */ jsxs("aside", { className: "wrapper__list__article ", children: [
        /* @__PURE__ */ jsx("h4", { className: "border_section", children: title }),
        /* @__PURE__ */ jsx("div", { className: "row", children: posts.data.map((post) => {
          return /* @__PURE__ */ jsx("div", { className: "col-md-6", children: /* @__PURE__ */ jsx(Content, { post }) }, post.id);
        }) })
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
        style: { visibility: "visible", animationDuration: "2s", animationDelay: "0.5s", animationName: "fadeIn" }
      }
    ) })
  ] }) }) });
}
export {
  Index as default
};
