export interface ToolOption {
    key: string
    label: string
}

export interface ModuleData {
    configs: {
        options: Array<ToolOption>
    }
}

export interface Configs {
    options: Array<ToolOption>
}
