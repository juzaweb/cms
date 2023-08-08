import { a as jsxs, j as jsx, F as Fragment } from "../ssr.mjs";
import { useState } from "react";
import Comments from "./comments-2d2731b4.mjs";
import { _ as __ } from "./functions-7d1a8c11.mjs";
import { usePage } from "@inertiajs/react";
import { p as postComment } from "./fetch-f134b4f2.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "axios";
function CommentForm({ post, comments }) {
  const [message, setMessage] = useState(null);
  const { guest } = usePage().props;
  const [content, setContent] = useState("");
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [website, setWebsite] = useState("");
  const handleComment = (e) => {
    e.preventDefault();
    postComment(post, content, name, email, website).then((res) => {
      setContent("");
      setMessage({ status: res.data.status, message: res.data.data.message });
      setTimeout(() => setMessage(null), 3e3);
    }).catch((err) => {
      console.log(err);
      setMessage({ status: false, message: err.response.data.message });
    });
    return false;
  };
  return /* @__PURE__ */ jsxs("div", { id: "comments", className: "comments-area", children: [
    /* @__PURE__ */ jsx(Comments, { comments }),
    /* @__PURE__ */ jsxs("div", { className: "comment-respond", children: [
      /* @__PURE__ */ jsx("h3", { className: "comment-reply-title", children: __("Leave a Reply") }),
      message && (message.status ? /* @__PURE__ */ jsx("div", { className: "alert alert-success", children: message.message }) : /* @__PURE__ */ jsx("div", { className: "alert alert-danger", children: message.message })),
      /* @__PURE__ */ jsxs("form", { onSubmit: handleComment, method: "post", className: "comment-form", id: "comment-form", children: [
        /* @__PURE__ */ jsxs("p", { className: "comment-notes", children: [
          /* @__PURE__ */ jsx("span", { id: "email-notes", children: __("Your email address will not be published.") }),
          __("Required fields are marked"),
          /* @__PURE__ */ jsx("span", { className: "required", children: "*" })
        ] }),
        /* @__PURE__ */ jsxs("p", { className: "comment-form-comment", children: [
          /* @__PURE__ */ jsxs("label", { htmlFor: "content", children: [
            __("Comment"),
            /* @__PURE__ */ jsx("span", { className: "required", children: "*" })
          ] }),
          /* @__PURE__ */ jsx(
            "textarea",
            {
              name: "content",
              id: "content",
              cols: 45,
              rows: 5,
              maxLength: 65525,
              required: true,
              onChange: (e) => setContent(e.currentTarget.value),
              value: content
            }
          )
        ] }),
        guest ? /* @__PURE__ */ jsxs(Fragment, { children: [
          /* @__PURE__ */ jsxs("p", { className: "comment-form-author", children: [
            /* @__PURE__ */ jsxs("label", { htmlFor: "name", children: [
              __("Name"),
              " ",
              /* @__PURE__ */ jsx(
                "span",
                {
                  className: "required",
                  children: "*"
                }
              )
            ] }),
            /* @__PURE__ */ jsx(
              "input",
              {
                type: "text",
                id: "name",
                name: "name",
                required: true,
                value: name,
                onChange: (e) => setName(e.currentTarget.value)
              }
            )
          ] }),
          /* @__PURE__ */ jsxs("p", { className: "comment-form-email", children: [
            /* @__PURE__ */ jsxs("label", { htmlFor: "email", children: [
              __("Email"),
              " ",
              /* @__PURE__ */ jsx(
                "span",
                {
                  className: "required",
                  children: "*"
                }
              )
            ] }),
            /* @__PURE__ */ jsx(
              "input",
              {
                type: "email",
                id: "email",
                name: "email",
                required: true,
                value: email,
                onChange: (e) => setEmail(e.currentTarget.value)
              }
            )
          ] }),
          /* @__PURE__ */ jsxs("p", { className: "comment-form-url", children: [
            /* @__PURE__ */ jsx("label", { htmlFor: "website", children: __("Website") }),
            /* @__PURE__ */ jsx(
              "input",
              {
                type: "text",
                id: "website",
                name: "website",
                value: website,
                onChange: (e) => setWebsite(e.currentTarget.value)
              }
            )
          ] })
        ] }) : "",
        /* @__PURE__ */ jsx("p", { className: "form-submit", children: /* @__PURE__ */ jsx(
          "input",
          {
            type: "submit",
            name: "submit",
            id: "submit",
            className: "submit",
            value: __("Post Comment")
          }
        ) })
      ] })
    ] })
  ] });
}
export {
  CommentForm as default
};
