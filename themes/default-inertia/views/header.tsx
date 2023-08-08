import {url} from "@/helpers/functions";
import {Link} from "@inertiajs/react";
import {usePage} from "@inertiajs/react";
import PrimaryMenu from "./components/primary-menu";

export default function Header() {
    const { config } = usePage().props;

    return (
        <>
            {/*<div className="loading-container">
                <div className="h-100 d-flex align-items-center justify-content-center">
                    <ul className="list-unstyled">
                        <li>
                            <img src={ '/jw-styles/themes/default-inertia/assets/images/loading.png' } alt="{ __('Loading') }}" height="100"/>
                        </li>

                        <li>
                            <div className="spinner">
                                <div className="rect1"></div>
                                <div className="rect2"></div>
                                <div className="rect3"></div>
                                <div className="rect4"></div>
                                <div className="rect5"></div>
                            </div>
                        </li>
                        <li>
                            <p>{{__('Loading')}}</p>
                        </li>
                    </ul>
                </div>
            </div>*/}

            <header className="bg-light">
                <div className="navigation-wrap navigation-shadow bg-white">
                    <nav className="navbar navbar-hover navbar-expand-lg navbar-soft">
                        <div className="container">

                            <div className="offcanvas-header">
                                <div data-toggle="modal" data-target="#modal_aside_right" className="btn-md">
                                    <span className="navbar-toggler-icon"></span>
                                </div>
                            </div>

                            <figure className="mb-0 mx-auto">
                                <Link href={"/"}>
                                    <img src={config.logo} alt={config.title} className="img-fluid logo"/>
                                </Link>
                            </figure>

                            <div className="collapse navbar-collapse justify-content-between" id="main_nav99">

                                <PrimaryMenu />

                                <ul className="navbar-nav ">
                                    <li className="nav-item search hidden-xs hidden-sm ">
                                        <a className="nav-link" href="">
                                            <i className="fa fa-search"></i>
                                        </a>
                                    </li>
                                </ul>

                                <div className="top-search navigation-shadow">
                                    <div className="container">
                                        <div className="input-group ">
                                            <form action={ url('search') } >

                                                <input type="hidden" name="type" value="posts"/>

                                                    <div className="row no-gutters mt-3">
                                                        <div className="col">
                                                            <input
                                                                className="form-control border-secondary border-right-0 rounded-0"
                                                                type="search" placeholder="Search " name="q"
                                                                id="example-search-input4" autoComplete="off"/>
                                                        </div>

                                                        <div className="col-auto">
                                                            <button
                                                                className="btn btn-outline-secondary border-left-0 rounded-0 rounded-right">
                                                                <i className="fa fa-search"></i>
                                                            </button>
                                                        </div>

                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </nav>
                </div>

                <div id="modal_aside_right" className="modal fixed-left fade" tabIndex={-1} role="dialog">
                    <div className="modal-dialog modal-dialog-aside" role="document">
                        <div className="modal-content">
                            <div className="modal-header">
                                <div className="widget__form-search-bar  ">
                                    <div className="row no-gutters">
                                        <div className="col">
                                            <input className="form-control border-secondary border-right-0 rounded-0"
                                                   placeholder="Search"/>
                                        </div>
                                        <div className="col-auto">
                                            <button className="btn btn-outline-secondary border-left-0 rounded-0 rounded-right">
                                                <i className="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <nav className="list-group list-group-flush">

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </>
);
}
