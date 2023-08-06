export interface ToolOption {
    key: string
    label: string
}

export interface ModuleData {
    configs: {
        options: Array<ToolOption>
    }
}
