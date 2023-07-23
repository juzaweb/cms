import {__} from "@/helpers/functions";

export default function () {
    return (
        <section className="wrap__section">
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <div className="card mx-auto" style="max-width:520px;">

                            <article className="card-body">
                                {/*{% if errors %}
                                <div className="alert alert-danger">
                                    <ul>
                                        {% for error in errors %}
                                        <li>{{error}}</li>
                                        {% endfor %}
                                    </ul>
                                </div>
                                {% endif %}*/}

                                <header className="mb-4">
                                    <h4 className="card-title">{ __('Sign up') }</h4>
                                </header>

                                <form method="post" action="">
                                    <div className="form-row">
                                        <div className="col form-group">
                                            <label htmlFor="name">{ __('Full name') }</label>
                                            <input name="name" type="text" className="form-control" placeholder=""
                                                   />
                                        </div>
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="email">{ __('Email') }</label>
                                        <input name="email" id="email" type="email" className="form-control"
                                               placeholder=""/>
                                            <small className="form-text text-muted">
                                                {__('We\'ll never share your email with anyone else.')}
                                            </small>
                                    </div>

                                    <div className="form-row">
                                        <div className="form-group col-md-6">
                                            <label htmlFor="password">{ __('Create password') }</label>
                                            <input name="password" id="password" className="form-control"
                                                   type="password"/>
                                        </div>
                                        <div className="form-group col-md-6">
                                            <label htmlFor="password_confirmation">{ __('Repeat password') }</label>
                                            <input name="password_confirmation" id="password_confirmation"
                                                   className="form-control" type="password"/>
                                        </div>
                                    </div>

                                    <div className="form-group">
                                        <button type="submit" className="btn btn-primary btn-block"> {__('Register')} </button>
                                    </div>

                                    <div className="form-group">
                                        <label className="custom-control custom-checkbox"> <input type="checkbox"
                                                                                                  className="custom-control-input"
                                                                                                  checked=""/>
                                            <span className="custom-control-label"> { __('I am agree with') } <a
                                                href="#">{ __('terms and contitions') }</a> </span>
                                        </label>
                                    </div>

                                </form>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
