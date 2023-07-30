import { MenuItem } from "./menu"
import { Page, PageProps, ErrorBag, Errors } from "@inertiajs/inertia";

export interface Config {
    title: string
    description: string
    logo: string
}

export interface BasePageProps extends Page<PageProps> {
    [key: string]: unknown;
    props: {
        errors: Errors & ErrorBag,
        config: Config,
        menu_items: MenuItem[],
        title: string,
        description: string,
        canonical?: string,
    }
}
