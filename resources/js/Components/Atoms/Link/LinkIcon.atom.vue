<template>
    <Link
        :class="'juzaweb__menuLeft__item__link ' + className"
        :href="href"
        @click="onclick"
    >
         <span class="juzaweb__menuLeft__item__title">{{ text }}</span>
        <i :class="'juzaweb__menuLeft__item__icon ' + icon"></i>
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: [
            'text',
            'className',
            'href',
            'icon',
            'callback'
        ],
        data () {
            return {
                products: [
                    {id: 1, name: 'Prod 1'},
                    {id: 2, name: 'Prod 2'},
                    {id: 3, name: 'Prod 3'}
                ]
            }
        },
        methods: {
            onclick: e => {
                if (callback) callback();
            },
        }
    })
</script>
