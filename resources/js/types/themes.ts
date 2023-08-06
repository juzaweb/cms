export interface Theme {
    name: string
    title: string
    description: string
}

export interface Plugin {
    name: string
    extra: {
        juzaweb?: {
            name?: string
        }
    };
}
