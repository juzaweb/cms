import { j as jsx, a as jsxs } from "../ssr.mjs";
import { l as login } from "./fetch-f134b4f2.mjs";
import { _ as __, u as url } from "./functions-7d1a8c11.mjs";
import { Link } from "@inertiajs/react";
import { useState } from "react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "axios";
function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [remember, setRemember] = useState(true);
  const [message, setMessage] = useState(null);
  const handleLogin = (e) => {
    e.isDefaultPrevented();
    login(email, password, remember).then((res) => {
      if (res.data.status) {
        window.location.href = url("/");
      }
    }).catch((err) => {
      setMessage({ status: false, message: err.response.data.message });
    });
  };
  return /* @__PURE__ */ jsx("section", { className: "wrap__section", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsx("div", { className: "row", children: /* @__PURE__ */ jsxs("div", { className: "col-md-12", children: [
    /* @__PURE__ */ jsx("div", { className: "card mx-auto", style: { maxWidth: "300px" }, children: /* @__PURE__ */ jsxs("div", { className: "card-body", children: [
      /* @__PURE__ */ jsx("h4", { className: "card-title mb-4", children: __("Sign in") }),
      message && /* @__PURE__ */ jsx("div", { className: "alert alert-danger", children: message.message }),
      /* @__PURE__ */ jsxs("form", { onSubmit: handleLogin, method: "post", children: [
        /* @__PURE__ */ jsx("div", { className: "form-group", children: /* @__PURE__ */ jsx(
          "input",
          {
            name: "email",
            className: "form-control",
            placeholder: __("Email"),
            type: "text",
            onChange: (e) => setEmail(e.target.value)
          }
        ) }),
        /* @__PURE__ */ jsx("div", { className: "form-group", children: /* @__PURE__ */ jsx(
          "input",
          {
            name: "password",
            className: "form-control",
            placeholder: __("Password"),
            type: "password",
            onChange: (e) => setPassword(e.target.value)
          }
        ) }),
        /* @__PURE__ */ jsxs("div", { className: "form-group", children: [
          /* @__PURE__ */ jsx(Link, { href: "forgot-password", className: "float-right", children: __("Forgot password?") }),
          /* @__PURE__ */ jsxs("label", { className: "float-left custom-control custom-checkbox", children: [
            /* @__PURE__ */ jsx(
              "input",
              {
                name: "remember",
                type: "checkbox",
                className: "custom-control-input",
                checked: true,
                onChange: (e) => setRemember(e.target.checked)
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
