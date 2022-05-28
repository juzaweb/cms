import React, {useEffect} from 'react'
import MenuTop from '../components/MenuTop'
import MenuLeft from '../components/MenuLeft'
import { usePage, Head, Link } from '@inertiajs/inertia-react'
//import {addScriptJS} from "@/utils/common";

export default function Backend({ children }) {
    const { title } = usePage().props

    useEffect(() => {
        //addScriptJS('/jw-styles/juzaweb/tinymce/tinymce.min.js')
    }, [])

    return (
        <>
        <Head>
            <title>{title}</title>
        </Head>

        <div className="juzaweb__layout juzaweb__layout--hasSider">
            <div className="juzaweb__menuLeft">
                <div className="juzaweb__menuLeft__mobileTrigger"><span></span></div>

                <div className="juzaweb__menuLeft__outer">
                    <div className="juzaweb__menuLeft__logo__container">
                        <Link href="/">
                            <div className="juzaweb__menuLeft__logo">
                                <img src="/jw-styles/juzaweb/images/logo.svg" className="mr-2" alt="Juzaweb" />
                                <div className="juzaweb__menuLeft__logo__name">JuzaWeb</div>
                                <div className="juzaweb__menuLeft__logo__descr">Cms</div>
                            </div>
                        </Link>
                    </div>

                    <div className="juzaweb__menuLeft__scroll jw__customScroll">
                        <MenuLeft />
                    </div>
                </div>
            </div>

            <div className="juzaweb__menuLeft__backdrop"></div>

            <div className="juzaweb__layout">
                <div className="juzaweb__layout__header">
                    <MenuTop />
                </div>

                <div className="juzaweb__layout__content">

                    <h4 className="font-weight-bold ml-3 text-capitalize">
                        {title}
                    </h4>

                    <div className="juzaweb__utils__content">

                        {/* @do_action('backend_message')

                        @php
                            $messages = get_backend_message();
                        @endphp

                        @foreach($messages as $message)
                            <div className="alert alert-{{ $message['status'] == 'error' ? 'danger' : $message['status'] }} jw-message">
                                <button type="button" className="close close-message" data-dismiss="alert" aria-label="Close" data-id="{{ $message['id'] }}">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {!! e_html($message['message']) !!}
                            </div>
                        @endforeach

                        @if(session()->has('message'))
                            <div className="alert alert-{{ session()->get('status') == 'error' ? 'danger' : 'success' }} jw-message">{{ session()->get('message') }}</div>
                        @endif */}

                    <article>{children}</article>

                </div>
            </div>

                <div className="juzaweb__layout__footer">
                    <div className="juzaweb__footer">
                        <div className="juzaweb__footer__inner">
                            <a href="https://juzaweb.com" target="_blank" rel="noopener noreferrer" className="juzaweb__footer__logo">
                                Juzaweb - Build website professional
                                <span></span>
                            </a>
                            <br />
                            <p className="mb-0">
                                Copyright ©2022 - Provided by Juzaweb
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </>
    )
}
