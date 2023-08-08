import { j as jsx } from "../ssr.mjs";
import { Link } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function Pagination({ data }) {
  return data.meta.last_page > 1 && data.meta.links.map(
    (page, index) => /* @__PURE__ */ jsx(
      Link,
      {
        href: page.url,
        className: page.active ? "active" : "",
        children: page.label
      },
      index
    )
  );
}
export {
  Pagination as default
};
