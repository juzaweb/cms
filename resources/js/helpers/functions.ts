import {getSidebar} from "@/helpers/fetch";

export function __(key: string, args = {}): string {
    // let lang = juzaweb.lang[key.replace('cms::app.', '')];
    // if (lang) {
    //     return lang;
    // }

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

export function message_in_response(response: any): { status: boolean, message: string } | undefined {
    // CMS json data
    if (response?.data) {
        if (response.data.message) {
            return {
                status: response.status,
                message: response.data.message
            };
        }
    }

    // CMS response
    if (response?.data?.data) {
        if (response.data.data.message) {
            return {
                status: response.data.status,
                message: response.data.data.message
            };
        }
    }

    // Get message validate
    if (response?.responseJSON) {
        if (response.responseJSON?.errors) {
            let message = '';
            $.each(response.responseJSON.errors, function (index, msg) {
                message = msg[0];
                return false;
            });

            return {
                status: false,
                message: message
            };
        } else if (response.responseJSON?.message) {
            return {
                status: false,
                message: response.responseJSON.message
            };
        }
    }

    // Get message errors
    if (response.message) {
        return {
            status: false,
            message: response.message.message
        };
    }
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
