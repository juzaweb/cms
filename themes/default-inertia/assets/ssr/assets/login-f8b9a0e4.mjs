import { j as jsx, a as jsxs } from "../ssr.mjs";
import { _ as __, u as url } from "./functions-e021afb9.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
function Login() {
  return /* @__PURE__ */ jsx("section", { className: "wrap__section", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsx("div", { className: "row", children: /* @__PURE__ */ jsxs("div", { className: "col-md-12", children: [
    /* @__PURE__ */ jsx("div", { className: "card mx-auto", style: "max-width: 380px;", children: /* @__PURE__ */ jsxs("div", { className: "card-body", children: [
      /* @__PURE__ */ jsx("h4", { className: "card-title mb-4", children: __("Sign in") }),
      /* @__PURE__ */ jsxs("form", { action: "", method: "post", children: [
        /* @__PURE__ */ jsx("div", { className: "form-group", children: /* @__PURE__ */ jsx(
          "input",
          {
            name: "email",
            className: "form-control",
            placeholder: __("Email"),
            type: "text"
          }
        ) }),
        /* @__PURE__ */ jsx("div", { className: "form-group", children: /* @__PURE__ */ jsx(
          "input",
          {
            name: "password",
            className: "form-control",
            placeholder: __("Password"),
            type: "password"
          }
        ) }),
        /* @__PURE__ */ jsxs("div", { className: "form-group", children: [
          /* @__PURE__ */ jsx("a", { href: "#", className: "float-right", children: __("Forgot password?") }),
          /* @__PURE__ */ jsxs("label", { className: "float-left custom-control custom-checkbox", children: [
            " ",
            /* @__PURE__ */ jsx(
              "input",
              {
                name: "remember",
                type: "checkbox",
                className: "custom-control-input",
                checked: ""
              }
            ),
            /* @__PURE__ */ jsxs("span", { className: "custom-control-label", children: [
              " ",
              __("Remember"),
              " "
            ] })
          ] })
        ] }),
        /* @__PURE__ */ jsx("div", { className: "form-group", children: /* @__PURE__ */ jsxs("button", { type: "submit", className: "btn btn-primary btn-block", children: [
          __("Login"),
          " "
        ] }) })
      ] })
    ] }) }),
    /* @__PURE__ */ jsxs("p", { className: "text-center mt-4", children: [
      __("Don't have account?"),
      " ",
      /* @__PURE__ */ jsx(
        "a",
        {
          href: url("register"),
          children: __("Sign up")
        }
      )
    ] })
  ] }) }) }) });
}
export {
  Login as default
};
