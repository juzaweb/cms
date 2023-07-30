import {Link, usePage} from "@inertiajs/react";
import FooterLinks from "./components/footer-links";
import { Config } from "@/types/config";

export default function Footer() {
    const { config } = usePage<{config: Config}>().props;

    return (
        <>
            <section className="wrapper__section p-0">
                <div className="wrapper__section__components">
                    <footer>
                        <div className="wrapper__footer bg__footer-dark pb-0">
                            <div className="container">
                                <div className="row">
                                    <div className="col-md-3">

                                    </div>

                                    <div className="col-md-3">

                                    </div>

                                    <div className="col-md-3">

                                    </div>

                                    <div className="col-md-3">

                                    </div>
                                </div>
                            </div>
                            <div className="mt-4">
                                <div className="container">
                                    <div className="row">
                                        <div className="col-md-4">
                                            <figure className="image-logo">
                                                <img src={config.logo} alt="" className="logo-footer"/>
                                            </figure>
                                        </div>

                                        <div className="col-md-8 my-auto ">
                                            <div className="social__media">
                                                <ul className="list-inline">
                                                    <li className="list-inline-item">
                                                        <a href="#"
                                                           className="btn btn-social rounded text-white facebook">
                                                            <i className="fa fa-facebook"></i>
                                                        </a>
                                                    </li>
                                                    <li className="list-inline-item">
                                                        <a href="#"
                                                           className="btn btn-social rounded text-white twitter">
                                                            <i className="fa fa-twitter"></i>
                                                        </a>
                                                    </li>
                                                    <li className="list-inline-item">
                                                        <a href="#"
                                                           className="btn btn-social rounded text-white whatsapp">
                                                            <i className="fa fa-whatsapp"></i>
                                                        </a>
                                                    </li>
                                                    <li className="list-inline-item">
                                                        <a href="#"
                                                           className="btn btn-social rounded text-white telegram">
                                                            <i className="fa fa-telegram"></i>
                                                        </a>
                                                    </li>
                                                    <li className="list-inline-item">
                                                        <a href="#"
                                                           className="btn btn-social rounded text-white linkedin">
                                                            <i className="fa fa-linkedin"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="wrapper__footer-bottom bg__footer-dark">
                            <div className="container ">
                                <div className="row">
                                    <div className="col-md-12">
                                        <div className="border-top-1 bg__footer-bottom-section">

                                        <FooterLinks></FooterLinks>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </footer>
                </div>
            </section>

            <a href="" id="return-to-top">
                <i className="fa fa-chevron-up"></i>
            </a>
        </>
    )
}
