import * as jsxRuntime from "react/jsx-runtime";
import ReactDOMServer from "react-dom/server";
import { createInertiaApp } from "@inertiajs/react";
import createServer from "@inertiajs/react/server";
const Fragment = jsxRuntime.Fragment;
const jsx = jsxRuntime.jsx;
const jsxs = jsxRuntime.jsxs;
async function resolvePageComponent(path, pages) {
  const page = pages[path];
  if (typeof page === "undefined") {
    throw new Error(`Page not found: ${path}`);
  }
  return typeof page === "function" ? page() : page;
}
createServer(
  (page) => createInertiaApp({
    page,
    render: ReactDOMServer.renderToString,
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./views/${name}.tsx`, /* @__PURE__ */ Object.assign({ "./views/auth/login.tsx": () => import("./assets/login-f8b9a0e4.mjs"), "./views/auth/register.tsx": () => import("./assets/register-fdba6b07.mjs"), "./views/components/comments.tsx": () => import("./assets/comments-6c49e628.mjs"), "./views/components/menu_item.tsx": () => import("./assets/menu_item-074a78f1.mjs"), "./views/footer.tsx": () => import("./assets/footer-3e174a1c.mjs"), "./views/header.tsx": () => import("./assets/header-513d9ecb.mjs"), "./views/index.tsx": () => import("./assets/index-4848dc84.mjs"), "./views/layouts/main.tsx": () => import("./assets/main-187d38ba.mjs"), "./views/search.tsx": () => import("./assets/search-9514cf2c.mjs"), "./views/template-parts/components/related.tsx": () => import("./assets/related-86565ff9.mjs"), "./views/template-parts/content.tsx": () => import("./assets/content-5eee3841.mjs"), "./views/template-parts/single-page.tsx": () => import("./assets/single-page-1879f93e.mjs"), "./views/template-parts/single.tsx": () => import("./assets/single-7d4023e4.mjs"), "./views/template-parts/taxonomy.tsx": () => import("./assets/taxonomy-b4e71ff2.mjs"), "./views/templates/home.tsx": () => import("./assets/home-b9cd2fb5.mjs") })),
    setup: ({ App, props }) => {
      return /* @__PURE__ */ jsx(App, { ...props });
    }
  })
);
export {
  Fragment as F,
  jsxs as a,
  jsx as j
};
