import {getSidebar} from "@/helpers/fetch";

export function __(key: string, args = {}): string {
    let lang = juzaweb.lang[key.replace('cms::app.', '')];
    if (lang) {
        return lang;
    }

    return key;
}

export function url(uri: string): string {
    return uri;
}

export function upload_url(path: string): string {
    return path;
}

export function admin_url(path: string): string {
    return '/admin-cp/' + path;
}

// pending
export function dynamic_sidebar(name: string): string {
    getSidebar(name).then(
        (data) => {
            return data;
        }
    );

    return '';
}
