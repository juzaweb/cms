<template>
    <app-layout :title="$page.props.title">
        <div class="row">
            <div class="col-md-9">

            </div>

            <div class="col-md-3">

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            AppLayout,
        }
    })
</script>
