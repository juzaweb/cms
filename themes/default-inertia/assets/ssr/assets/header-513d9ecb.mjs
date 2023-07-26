import { j as jsx, F as Fragment, a as jsxs } from "../ssr.mjs";
import { u as url } from "./functions-e021afb9.mjs";
import { usePage, Link } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function Header() {
  const { config } = usePage().props;
  return /* @__PURE__ */ jsx(Fragment, { children: /* @__PURE__ */ jsxs("header", { className: "bg-light", children: [
    /* @__PURE__ */ jsx("div", { className: "navigation-wrap navigation-shadow bg-white", children: /* @__PURE__ */ jsx("nav", { className: "navbar navbar-hover navbar-expand-lg navbar-soft", children: /* @__PURE__ */ jsxs("div", { className: "container", children: [
      /* @__PURE__ */ jsx("div", { className: "offcanvas-header", children: /* @__PURE__ */ jsx("div", { "data-toggle": "modal", "data-target": "#modal_aside_right", className: "btn-md", children: /* @__PURE__ */ jsx("span", { className: "navbar-toggler-icon" }) }) }),
      /* @__PURE__ */ jsx("figure", { className: "mb-0 mx-auto", children: /* @__PURE__ */ jsx(Link, { href: "/", children: /* @__PURE__ */ jsx("img", { src: config.logo, alt: config.title, className: "img-fluid logo" }) }) }),
      /* @__PURE__ */ jsxs("div", { className: "collapse navbar-collapse justify-content-between", id: "main_nav99", children: [
        /* @__PURE__ */ jsx("ul", { className: "navbar-nav ", children: /* @__PURE__ */ jsx("li", { className: "nav-item search hidden-xs hidden-sm ", children: /* @__PURE__ */ jsx("a", { className: "nav-link", href: "", children: /* @__PURE__ */ jsx("i", { className: "fa fa-search" }) }) }) }),
        /* @__PURE__ */ jsx("div", { className: "top-search navigation-shadow", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsx("div", { className: "input-group ", children: /* @__PURE__ */ jsxs("form", { action: url("search"), children: [
          /* @__PURE__ */ jsx("input", { type: "hidden", name: "type", value: "posts" }),
          /* @__PURE__ */ jsxs("div", { className: "row no-gutters mt-3", children: [
            /* @__PURE__ */ jsx("div", { className: "col", children: /* @__PURE__ */ jsx(
              "input",
              {
                className: "form-control border-secondary border-right-0 rounded-0",
                type: "search",
                placeholder: "Search ",
                name: "q",
                id: "example-search-input4",
                autoComplete: "off"
              }
            ) }),
            /* @__PURE__ */ jsx("div", { className: "col-auto", children: /* @__PURE__ */ jsx(
              "button",
              {
                className: "btn btn-outline-secondary border-left-0 rounded-0 rounded-right",
                children: /* @__PURE__ */ jsx("i", { className: "fa fa-search" })
              }
            ) })
          ] })
        ] }) }) }) })
      ] })
    ] }) }) }),
    /* @__PURE__ */ jsx("div", { id: "modal_aside_right", className: "modal fixed-left fade", tabIndex: -1, role: "dialog", children: /* @__PURE__ */ jsx("div", { className: "modal-dialog modal-dialog-aside", role: "document", children: /* @__PURE__ */ jsxs("div", { className: "modal-content", children: [
      /* @__PURE__ */ jsxs("div", { className: "modal-header", children: [
        /* @__PURE__ */ jsx("div", { className: "widget__form-search-bar  ", children: /* @__PURE__ */ jsxs("div", { className: "row no-gutters", children: [
          /* @__PURE__ */ jsx("div", { className: "col", children: /* @__PURE__ */ jsx(
            "input",
            {
              className: "form-control border-secondary border-right-0 rounded-0",
              placeholder: "Search"
            }
          ) }),
          /* @__PURE__ */ jsx("div", { className: "col-auto", children: /* @__PURE__ */ jsx("button", { className: "btn btn-outline-secondary border-left-0 rounded-0 rounded-right", children: /* @__PURE__ */ jsx("i", { className: "fa fa-search" }) }) })
        ] }) }),
        /* @__PURE__ */ jsx("button", { type: "button", className: "close", "data-dismiss": "modal", "aria-label": "Close", children: /* @__PURE__ */ jsx("span", { "aria-hidden": "true", children: "×" }) })
      ] }),
      /* @__PURE__ */ jsx("div", { className: "modal-body", children: /* @__PURE__ */ jsx("nav", { className: "list-group list-group-flush" }) })
    ] }) }) })
  ] }) });
}
export {
  Header as default
};
