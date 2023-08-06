export interface DatatableColumn {
    key: string
    label: string
    sortable?: boolean
    align?: string
    width?: string
}

export interface DatatableAction {
    key: string
    label: string
}

export interface DatatableSearchField {
    type: string
    label: string
}

export interface DatatableProps {
    actionUrl: string
    dataUrl: string
    uniqueId: string
    actions: Array<DatatableAction>
    columns: Array<DatatableColumn>
    escapes: Array<string>
    params: Array<string>
    searchFields: Array<DatatableSearchField>
    perPage: number
    searchable: boolean
    sortName: string
    sortOder: string
    table: string
}
