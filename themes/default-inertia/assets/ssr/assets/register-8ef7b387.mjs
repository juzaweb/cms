import { j as jsx, a as jsxs } from "../ssr.mjs";
import { _ as __ } from "./functions-7d1a8c11.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
function register() {
  return /* @__PURE__ */ jsx("section", { className: "wrap__section", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsx("div", { className: "row", children: /* @__PURE__ */ jsx("div", { className: "col-md-12", children: /* @__PURE__ */ jsx("div", { className: "card mx-auto", style: "max-width:520px;", children: /* @__PURE__ */ jsxs("article", { className: "card-body", children: [
    /* @__PURE__ */ jsx("header", { className: "mb-4", children: /* @__PURE__ */ jsx("h4", { className: "card-title", children: __("Sign up") }) }),
    /* @__PURE__ */ jsxs("form", { method: "post", action: "", children: [
      /* @__PURE__ */ jsx("div", { className: "form-row", children: /* @__PURE__ */ jsxs("div", { className: "col form-group", children: [
        /* @__PURE__ */ jsx("label", { htmlFor: "name", children: __("Full name") }),
        /* @__PURE__ */ jsx(
          "input",
          {
            name: "name",
            type: "text",
            className: "form-control",
            placeholder: ""
          }
        )
      ] }) }),
      /* @__PURE__ */ jsxs("div", { className: "form-group", children: [
        /* @__PURE__ */ jsx("label", { htmlFor: "email", children: __("Email") }),
        /* @__PURE__ */ jsx(
          "input",
          {
            name: "email",
            id: "email",
            type: "email",
            className: "form-control",
            placeholder: ""
          }
        ),
        /* @__PURE__ */ jsx("small", { className: "form-text text-muted", children: __("We'll never share your email with anyone else.") })
      ] }),
      /* @__PURE__ */ jsxs("div", { className: "form-row", children: [
        /* @__PURE__ */ jsxs("div", { className: "form-group col-md-6", children: [
          /* @__PURE__ */ jsx("label", { htmlFor: "password", children: __("Create password") }),
          /* @__PURE__ */ jsx(
            "input",
            {
              name: "password",
              id: "password",
              className: "form-control",
              type: "password"
            }
          )
        ] }),
        /* @__PURE__ */ jsxs("div", { className: "form-group col-md-6", children: [
          /* @__PURE__ */ jsx("label", { htmlFor: "password_confirmation", children: __("Repeat password") }),
          /* @__PURE__ */ jsx(
            "input",
            {
              name: "password_confirmation",
              id: "password_confirmation",
              className: "form-control",
              type: "password"
            }
          )
        ] })
      ] }),
      /* @__PURE__ */ jsx("div", { className: "form-group", children: /* @__PURE__ */ jsxs("button", { type: "submit", className: "btn btn-primary btn-block", children: [
        " ",
        __("Register"),
        " "
      ] }) }),
      /* @__PURE__ */ jsx("div", { className: "form-group", children: /* @__PURE__ */ jsxs("label", { className: "custom-control custom-checkbox", children: [
        " ",
        /* @__PURE__ */ jsx(
          "input",
          {
            type: "checkbox",
            className: "custom-control-input",
            checked: ""
          }
        ),
        /* @__PURE__ */ jsxs("span", { className: "custom-control-label", children: [
          " ",
          __("I am agree with"),
          " ",
          /* @__PURE__ */ jsx(
            "a",
            {
              href: "#",
              children: __("terms and contitions")
            }
          ),
          " "
        ] })
      ] }) })
    ] })
  ] }) }) }) }) }) });
}
export {
  register as default
};
