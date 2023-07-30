import { login } from "@/helpers/fetch";
import { __, url } from "@/helpers/functions";
import { Link } from "@inertiajs/react";
import { useState } from "react";

export default function Login() {
    const [email, setEmail] = useState<string>("");
    const [password, setPassword] = useState<string>("");
    const [remember, setRemember] = useState<boolean>(true);
    const [message, setMessage] = useState<{status: boolean, message: string}|null>(null);

    const handleLogin = (e: React.FormEvent) => {
        e.isDefaultPrevented();

        login(email, password, remember).then((res) => {
            if (res.data.status) {
                window.location.href = url("/");
            }
        }).catch((err) => {
            setMessage({ status: false, message: err.response.data.message });
        });
    }

    return (
        <section className="wrap__section">
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <div className="card mx-auto" style={{ maxWidth: "300px" }}>
                            <div className="card-body">
                                <h4 className="card-title mb-4">{__('Sign in')}</h4>

                                {message && <div className="alert alert-danger">{message.message}</div>}

                                <form onSubmit={handleLogin} method="post">

                                    {/*<a href="#" class="btn btn-facebook btn-block mb-2 text-white"> <i class="fa fa-facebook"></i> &nbsp; Sign
                                        in
                                        with
                                        Facebook</a>
                                        <a href="#" class="btn btn-primary btn-block mb-4"> <i class="fa fa-google"></i> &nbsp; Sign in with
                                        Google</a>*/}

                                    <div className="form-group">
                                        <input name="email" className="form-control" placeholder={__('Email')}
                                            type="text" onChange={(e) => setEmail(e.target.value)} />
                                    </div>

                                    <div className="form-group">
                                        <input name="password" className="form-control"
                                            placeholder={__('Password')} type="password" onChange={(e) => setPassword(e.target.value)} />
                                    </div>

                                    <div className="form-group">
                                        <Link href={'forgot-password'} className="float-right">
                                            {__('Forgot password?')}
                                        </Link>
                                        <label className="float-left custom-control custom-checkbox">
                                        <input
                                            name="remember"
                                            type="checkbox"
                                            className="custom-control-input"
                                            checked={true}
                                            onChange={(e) => setRemember(e.target.checked)}
                                        />
                                            <span className="custom-control-label"> {__('Remember')} </span>
                                        </label>
                                    </div>

                                    <div className="form-group">
                                        <button type="submit" className="btn btn-primary btn-block">{__('Login')} </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <p className="text-center mt-4">{__('Don\'t have account?')} <a
                            href={url('register')}>{__('Sign up')}</a></p>
                    </div>
                </div>
            </div>
        </section>
    )
}
