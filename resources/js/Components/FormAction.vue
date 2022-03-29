<template>
    <form :action="action" :method="method" :class="className">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        name: 'FormAction',
        props: {
            action: {
                type: String,
                default: ''
            },
            method: {
                type: String,
                default: 'GET'
            },
            className: {
                type: String,
                default: ''
            }
        },
        mounted() {
            this.action = '/asdsad';
        }
    }
</script>