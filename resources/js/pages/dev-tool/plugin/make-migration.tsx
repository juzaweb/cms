import {Theme} from "@/types/themes";
import {Plugin} from "@/types/plugins";
import React, {useState} from "react";
import Button from "@/components/form/buttons/button";
import ColumnRow from "@/pages/dev-tool/components/plugins/migration/column-row";
import Checkbox from "@/components/form/inputs/checkbox";

export interface Column {
    name?: string;
    type: string;
    nullable: boolean;
}

const ColumnDefault = {
    name: '',
    type: 'string',
    nullable: true,
    index: false,
}

export default function MakeMigration({ module }: { module: Theme | Plugin }) {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [runMigration, setRunMigration] = useState<boolean>(true);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();

    const [columns, setColumns] = useState<Array<Column>>(
        [
            {
                name: 'id',
                type: 'bigIncrements',
                nullable: false
            }
        ]
    );

    const handleAddColumn = () => {
        setColumns([...columns, ColumnDefault]);
    }

    // @ts-ignore
    return (
        <div className={'row'}>
            <div className="col-md-12">
                {message && (
                    <div className={`alert alert-${message.status ? 'success' : 'danger' } jw-message`}>
                        {message.message}
                    </div>
                )}

                <form action="" method={'POST'}>
                    <table className={'table table-striped'}>
                        <thead>
                            <tr>
                                <th>Column</th>
                                <th style={{width: '20%'}}>Data Type</th>
                                <th style={{width: '5%'}} className={'text-center'}>Nullable</th>
                                <th style={{width: '5%'}} className={'text-center'}>Index</th>
                                <th>Foreign</th>
                            </tr>
                        </thead>
                        <tbody>
                        {columns && columns.map((column, index) => (
                            <ColumnRow key={index} column={column}></ColumnRow>
                        ))}
                        </tbody>
                    </table>

                    <button type={'button'} className={'btn btn-success'} onClick={handleAddColumn}>
                        Add column
                    </button>

                    <div className="row mt-3">
                        <div className="col-md-12">
                            <Checkbox
                                name={'run'}
                                label={'Run migration after created'}
                                checked={runMigration}
                                onChange={(e) => setRunMigration(e.target.checked)}
                            />

                            {runMigration && (
                                <>
                                    <Checkbox name={'crud'} label={'Make CRUD'}/>
                                </>
                            )}

                            <Button label={'Make Migration'} type={'submit'} loading={buttonLoading} />
                        </div>
                    </div>


                </form>
            </div>
        </div>
    )
}
