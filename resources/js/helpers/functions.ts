import {getSidebar} from "@/helpers/fetch";

export function __(key: string, args = {}): string {
    return juzaweb.lang[key.replace('cms::app.', '')];
}

export function url(uri: string): string {
    return uri;
}

export function upload_url(path: string): string {
    return path;
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
