<template>
    <ul class="juzaweb__menuLeft__navigation">
        <li v-for="item in menuItems" :class="'juzaweb__menuLeft__item '+ (item.children ?  'juzaweb__menuLeft__submenu' : '') +' juzaweb__menuLeft__item-' + item.slug " >
            <span class="juzaweb__menuLeft__item__link" v-if="item.children">
                <i :class="'juzaweb__menuLeft__item__icon ' + item.icon"></i>
                <span class="juzaweb__menuLeft__item__title">{{ item.title }}</span>
            </span>

            <Link class="juzaweb__menuLeft__item__link" :href="(item.url === 'dashboard' ? adminUrl : adminUrl + '/' + item.url)" v-if="!item.children">
                <span class="juzaweb__menuLeft__item__title">{{ item.title }}</span>

                <i :class="'juzaweb__menuLeft__item__icon ' + item.icon"></i>
            </Link>

            <ul class="juzaweb__menuLeft__navigation" v-if="item.children">
                <li :class="'juzaweb__menuLeft__item juzaweb__menuLeft__item-' + child.slug" v-for="child in item.children">
                    <Link class="juzaweb__menuLeft__item__link" :href="adminUrl +'/'+ child.url">
                        <span class="juzaweb__menuLeft__item__title">{{ child.title }}</span>
                        <i :class="'juzaweb__menuLeft__item__icon ' + child.icon"></i>
                    </Link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
    import { defineComponent, computed } from 'vue'
    import { usePage, Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        setup() {
            const menuItems = computed(() => usePage().props.value.menuItems);
            const adminUrl = computed(() => usePage().props.value.adminUrl);
            return { menuItems, adminUrl }
        },
        components: {
            Head,
            Link,
        }
    })
</script>