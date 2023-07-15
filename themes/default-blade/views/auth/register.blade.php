{% extends 'cms::layouts.frontend' %}

{% block content %}
    <!-- register -->
    <section class="wrap__section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mx-auto" style="max-width:520px;">

                        <article class="card-body">
                            {% if errors %}
                                <div class="alert alert-danger">
                                    <ul>
                                        {% for error in errors %}
                                            <li>{{ error }}</li>
                                        {% endfor %}
                                    </ul>
                                </div>
                            {% endif %}

                            <header class="mb-4">
                                <h4 class="card-title">{{ __('Sign up') }}</h4>
                            </header>

                            <form method="post" action="">
                                {{ csrf_field() }}

                                <div class="form-row">
                                    <div class="col form-group">
                                        <label for="name">{{ __('Full name') }}</label>
                                        <input name="name" type="text" class="form-control" placeholder="" value="{{ old('name') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input name="email" id="email" type="email" class="form-control" placeholder="" value="{{ old('email') }}">
                                    <small class="form-text text-muted">
                                        {{ __('We\'ll never share your email with anyone else.') }}
                                    </small>
                                </div> <!-- form-group end.// -->

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="password">{{ __('Create password') }}</label>
                                        <input name="password" id="password" class="form-control" type="password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">{{ __('Repeat password') }}</label>
                                        <input name="password_confirmation" id="password_confirmation" class="form-control" type="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block"> {{ __('Register') }} </button>
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked="">
                                        <span class="custom-control-label"> {{ __('I am agree with') }} <a href="#">{{ __('terms and contitions') }}</a> </span>
                                    </label>
                                </div>

                            </form>
                        </article>
                    </div>
                    <!-- end register -->
                </div>
            </div>
        </div>
    </section>
    <!-- end register -->
{% endblock %}
