<template>
    <Link
        class="juzaweb__menuLeft__item__link"
        :href="href"
    >
        {{ text }}
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Link,
        },
        props: [
            'text',
            'className',
            'href'
        ],
        data() {},
        methods: {
            onclick: e => {},
            onMouseMove: e => {}
        }
    }
</script>
