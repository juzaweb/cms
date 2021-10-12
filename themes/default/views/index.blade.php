@extends('juzaweb::layouts.frontend')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-wrapper">
                        <div class="blog-grid-system">
                            <div class="row">
                                @foreach($posts as $post)
                                    {{ get_template_part($post, 'content') }}
                                @endforeach
                            </div>
                        </div><!-- end blog-grid-system -->
                    </div><!-- end page-wrapper -->

                    <hr class="invis3">

                    <div class="row">
                        <div class="col-md-12">
                            <nav aria-label="Page navigation">
                                {{ $posts->links() }}
                            </nav>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </section>
@endsection
