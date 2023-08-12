import { j as jsx, a as jsxs } from "../ssr.mjs";
import { _ as __ } from "./functions-7d1a8c11.mjs";
import Main from "./main-db1d4148.mjs";
import { Link } from "@inertiajs/react";
import Pagination from "./pagination-0d24e1e2.mjs";
import Content from "./content-e36fab22.mjs";
import DynamicSidebar from "./dynamic-sidebar-95d235d2.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "./header-f6b6cb55.mjs";
import "./primary-menu-6770b89b.mjs";
import "./menu_item-c22bc602.mjs";
import "./footer-995c808a.mjs";
import "./footer-links-46318c85.mjs";
import "./fetch-f134b4f2.mjs";
import "axios";
import "react";
import "./show-aca0f914.mjs";
function taxonomy({ taxonomy: taxonomy2, page }) {
  return /* @__PURE__ */ jsx(Main, { children: /* @__PURE__ */ jsxs("section", { children: [
    /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsx("div", { className: "row", children: /* @__PURE__ */ jsx("div", { className: "col-md-12", children: /* @__PURE__ */ jsxs("ul", { className: "breadcrumbs bg-light mb-4", children: [
      /* @__PURE__ */ jsx("li", { className: "breadcrumbs__item", children: /* @__PURE__ */ jsxs(Link, { href: "/", className: "breadcrumbs__url", children: [
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
          /* @__PURE__ */ jsx("div", { className: "row", children: page.data.map((post) => {
            return /* @__PURE__ */ jsx("div", { className: "col-md-6", children: /* @__PURE__ */ jsx(Content, { post }) }, post.id);
          }) })
        ] }) }),
        /* @__PURE__ */ jsx("div", { className: "col-md-4", children: /* @__PURE__ */ jsx("div", { className: "sidebar-sticky", children: /* @__PURE__ */ jsx(DynamicSidebar, {}) }) }),
        /* @__PURE__ */ jsx("div", { className: "clearfix" })
      ] }),
      /* @__PURE__ */ jsx("div", { className: "pagination-area", children: /* @__PURE__ */ jsx(
        "div",
        {
          className: "pagination wow fadeIn animated",
          "data-wow-duration": "2s",
          "data-wow-delay": "0.5s",
          style: { visibility: "visible", animationDuration: "2s", animationDelay: "0.5s", animationName: "fadeIn" },
          children: /* @__PURE__ */ jsx(Pagination, { data: page })
        }
      ) })
    ] })
  ] }) });
}
export {
  taxonomy as default
};
