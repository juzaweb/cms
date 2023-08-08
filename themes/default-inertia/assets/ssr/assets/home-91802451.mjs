import { j as jsx, a as jsxs } from "../ssr.mjs";
import { _ as __ } from "./functions-7d1a8c11.mjs";
import Main from "./main-db1d4148.mjs";
import Pagination from "./pagination-0d24e1e2.mjs";
import { useState } from "react";
import DynamicSidebar from "./dynamic-sidebar-95d235d2.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
import "./header-f6b6cb55.mjs";
import "./primary-menu-6770b89b.mjs";
import "./menu_item-c22bc602.mjs";
import "./footer-995c808a.mjs";
import "./footer-links-46318c85.mjs";
import "./fetch-f134b4f2.mjs";
import "axios";
import "./show-aca0f914.mjs";
function home() {
  const [posts, setPosts] = useState(null);
  return /* @__PURE__ */ jsx(Main, { children: /* @__PURE__ */ jsx("section", { className: "pt-0", children: /* @__PURE__ */ jsx("div", { className: "mt-4", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsxs("div", { className: "row", children: [
    /* @__PURE__ */ jsx("div", { className: "col-md-8", children: /* @__PURE__ */ jsxs("aside", { className: "wrapper__list__article", children: [
      /* @__PURE__ */ jsx("h4", { className: "border_section", children: __("Latest") }),
      /* @__PURE__ */ jsxs("div", { className: "wrapp__list__article-responsive", children: [
        posts && posts.data.map((item) => {
          var _a;
          return /* @__PURE__ */ jsx("div", { className: "card__post card__post-list card__post__transition mt-30", children: /* @__PURE__ */ jsxs("div", { className: "row ", children: [
            /* @__PURE__ */ jsx("div", { className: "col-md-5", children: /* @__PURE__ */ jsx("div", { className: "card__post__transition", children: /* @__PURE__ */ jsx("a", { href: item.url, children: /* @__PURE__ */ jsx("img", { src: item.thumbnail, className: "img-fluid w-100", alt: item.title }) }) }) }),
            /* @__PURE__ */ jsx("div", { className: "col-md-7 my-auto pl-0", children: /* @__PURE__ */ jsx("div", { className: "card__post__body ", children: /* @__PURE__ */ jsxs("div", { className: "card__post__content", children: [
              /* @__PURE__ */ jsx("div", { className: "card__post__author-info mb-2", children: /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
                /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs("span", { className: "text-primary", children: [
                  __("by"),
                  " ",
                  (_a = item.author) == null ? void 0 : _a.name
                ] }) }),
                /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("span", { className: "text-dark text-capitalize", children: item.created_at }) })
              ] }) }),
              /* @__PURE__ */ jsxs("div", { className: "card__post__title", children: [
                /* @__PURE__ */ jsx("h5", { children: /* @__PURE__ */ jsx("a", { href: item.url, children: item.title }) }),
                /* @__PURE__ */ jsx("p", { className: "d-none d-lg-block d-xl-block mb-0", children: item.description })
              ] })
            ] }) }) })
          ] }) });
        }),
        ";"
      ] })
    ] }) }),
    /* @__PURE__ */ jsx("div", { className: "col-md-4", children: /* @__PURE__ */ jsx("div", { className: "sticky-top", children: /* @__PURE__ */ jsx(DynamicSidebar, {}) }) }),
    /* @__PURE__ */ jsx("div", { className: "mx-auto", children: /* @__PURE__ */ jsx("div", { className: "pagination-area", children: /* @__PURE__ */ jsx(
      "div",
      {
        className: "pagination wow fadeIn animated",
        "data-wow-duration": "2s",
        "data-wow-delay": "0.5s",
        style: { visibility: "visible", animationDuration: "2s", animationDelay: "0.5s", animationName: "fadeIn" },
        children: /* @__PURE__ */ jsx(Pagination, { data: posts })
      }
    ) }) }),
    /* @__PURE__ */ jsx("div", { className: "clearfix" })
  ] }) }) }) }) });
}
export {
  home as default
};
