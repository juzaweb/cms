import TopOptions from "@/pages/dev-tool/components/top-options";
import Admin from "@/layouts/admin";

export interface IndexProps {
    title: string
}

export default function Index() {

    return (
        <Admin>
            <TopOptions />

            <div className="row mt-3">
                {/*<div className="col-md-3">
                    {module && moduleType && moduleData && <MenuHandle module={module} moduleType={moduleType} moduleData={moduleData}></MenuHandle>}
                </div>*/}

                {/*<div className="col-md-12">
                    {module && moduleType && selectedOption && <OptionHandle module={module} moduleType={moduleType} selectedOption={selectedOption}/> }
                </div>*/}
            </div>
        </Admin>
    );
}
