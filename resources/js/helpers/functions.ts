import {getSidebar} from "@/helpers/fetch";
import axios, {AxiosRequestConfig} from "axios";

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

export async function post_request(
    url: string,
    data: any,
    config?: AxiosRequestConfig)
{
    let response = await axios.post(url, data, config);
    console.log(response.data);
    return message_in_response(response.data);
}

export function convert_to_label_field(str: string): string {
    str = str.replace('-', '_');
    return str.split('_').map((word: string) => {
        return word.charAt(0).toUpperCase() + word.slice(1);
    }).join(' ');
}

export function convert_to_slug(str: string): string {
    return str.toLowerCase().replace(/[^a-z0-9\-]/ig, '-');
}

export function convert_to_name_field(str: string): string {
    return str.toLowerCase().replace(/[^a-z0-9_]/ig, '_');
}

export function message_in_response(response: any): { status: boolean, message: string, errors?: Array<string> } | undefined {
    // console.log(response);
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


    // Get message validate error axios
    if (response?.response) {
        if (response.response.data.errors) {
            let message = '';
            $.each(response.response.data.errors, function (index, msg) {
                message = msg[0];
                return false;
            });

            return {
                status: false,
                message: message,
                errors: response.response.data.errors
            };
        }

        return {
            status: false,
            message: response.response.data.message
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
