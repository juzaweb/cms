<template>
    <app-layout title="Dashboard">
        <div class="row">
            <div class="col-md-3">
                <div class="card border-0 bg-gray-2">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center">
                            <i class="fa fa-list font-size-50 mr-3"></i>
                            <div>
                                <div class="font-size-21 font-weight-bold">{{ $page.props.lang.posts }}</div>
                                <div class="font-size-15">{{ $page.props.lang.total }}: {{ $page.props.posts }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center">
                            <i class="fa fa-list font-size-50 mr-3"></i>
                            <div>
                                <div class="font-size-21 font-weight-bold">{{ $page.props.lang.pages }}</div>
                                <div class="font-size-15">{{ $page.props.lang.total }}: {{ $page.props.pages }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card border-0 bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center">
                            <i class="fa fa-users font-size-50 mr-3"></i>
                            <div>
                                <div class="font-size-21 font-weight-bold">{{ $page.props.lang.users }}</div>
                                <div class="font-size-15">{{ $page.props.lang.total }}: {{ $page.props.users }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card border-0 bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center">
                            <i class="fa fa-hdd-o font-size-50 mr-3"></i>
                            <div>
                                <div class="font-size-21 font-weight-bold">{{ $page.props.lang.storage }}</div>
                                <div class="font-size-15">{{ $page.props.lang.total }}: {{ $page.props.storage }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="curve_chart" style="width: 100%; height: 300px"></div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $page.props.lang.new_users }}</h5>
                    </div>

                    <div class="card-body">
                        <table class="table" id="users-table">
                            <thead>
                            <tr>
                                <th data-formatter="index_formatter" data-width="5%">#</th>
                                <th data-field="name">{{ $page.props.lang.name }}</th>
                                <th data-field="created" data-width="30%" data-align="center">{{ $page.props.lang.created_at }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $page.props.lang.top_views }}</h5>
                    </div>

                    <div class="card-body">
                        <table class="table" id="posts-top-views">
                            <thead>
                            <tr>
                                <th data-formatter="index_formatter" data-width="5%">#</th>
                                <th data-field="title">{{ $page.props.lang.title }}</th>
                                <th data-field="views" data-width="10%">{{ $page.props.lang.views }}</th>
                                <th data-field="created" data-width="30%" data-align="center">{{ $page.props.lang.created_at }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
        }
    })
</script>
