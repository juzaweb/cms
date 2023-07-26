import { a as jsxs, j as jsx } from "../ssr.mjs";
import { _ as __ } from "./functions-e021afb9.mjs";
import { Link } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function Related({ items }) {
  return /* @__PURE__ */ jsxs("div", { className: "related-article", children: [
    /* @__PURE__ */ jsx("h4", { children: __("you may also like") }),
    /* @__PURE__ */ jsx("div", { className: "article__entry-carousel-three", children: items.map((item) => {
      var _a;
      return /* @__PURE__ */ jsx("div", { className: "item", children: /* @__PURE__ */ jsxs("div", { className: "article__entry", children: [
        /* @__PURE__ */ jsx("div", { className: "article__image", children: /* @__PURE__ */ jsx(Link, { href: item.url, children: /* @__PURE__ */ jsx("img", { src: item.thumbnail, alt: item.title, className: "img-fluid" }) }) }),
        /* @__PURE__ */ jsxs("div", { className: "article__content", children: [
          /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
            /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs("span", { className: "text-primary", children: [
              __("by"),
              " ",
              (_a = item.author) == null ? void 0 : _a.name
            ] }) }),
            /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("span", { className: "text-dark text-capitalize", children: item.created_at }) })
          ] }),
          /* @__PURE__ */ jsx("h5", { children: /* @__PURE__ */ jsx(Link, { href: item.url, children: item.title }) })
        ] })
      ] }) });
    }) })
  ] });
}
export {
  Related as default
};
