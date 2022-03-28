<template>
    <Head :title="title" />

    <div class="juzaweb__layout juzaweb__layout--hasSider">

        <div class="juzaweb__menuLeft">
            <div class="juzaweb__menuLeft__mobileTrigger"><span></span></div>

            <div class="juzaweb__menuLeft__outer">
                <div class="juzaweb__menuLeft__logo__container">
                    <a href="/">
                        <div class="juzaweb__menuLeft__logo">
                            <img src="/jw-styles/juzaweb/styles/images/logo.svg" class="mr-2" alt="Juzaweb">
                            <div class="juzaweb__menuLeft__logo__name">Juzaweb</div>
                            <div class="juzaweb__menuLeft__logo__descr">Cms</div>
                        </div>
                    </a>
                </div>

                <div class="juzaweb__menuLeft__scroll jw__customScroll">
                    <MenuLeft></MenuLeft>
                </div>
            </div>
        </div>
        <div class="juzaweb__menuLeft__backdrop"></div>

        <div class="juzaweb__layout">
            <div class="juzaweb__layout__header">
                <MenuTop></MenuTop>
            </div>

            <div class="juzaweb__layout__content">

                <h4 class="font-weight-bold ml-3 text-capitalize">{{ $page.props.title }}</h4>

                <div class="juzaweb__utils__content">
                    <slot></slot>
                </div>
            </div>

            <div class="juzaweb__layout__footer">
                <div class="juzaweb__footer">
                    <div class="juzaweb__footer__inner">
                        <a href="https://juzaweb.com" target="_blank" rel="noopener noreferrer" class="juzaweb__footer__logo">
                            Juzaweb - Build website professional
                            <span></span>
                        </a>
                        <br />
                        <p class="mb-0">
                            Copyright © - Provided by Juzaweb
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import { defineComponent } from 'vue'
    import MenuTop from  '../Components/MenuTop';
    import MenuLeft from  '../Components/MenuLeft';

    import { Head, Link } from '@inertiajs/inertia-vue3';
    import '../../../public/jw-styles/juzaweb/styles/css/vendor.css';
    import '../../../public/jw-styles/juzaweb/styles/css/backend.css';

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head,
            Link,
            MenuTop,
            MenuLeft,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    })
</script>
