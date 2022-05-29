<template>
    <div class="">
        <b-navbar toggleable="lg" type="dark" variant="dark" style="min-height: 10vh">
            <div class="container">
                <b-navbar-brand href="/">Chat App</b-navbar-brand>

                <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

                <b-collapse id="nav-collapse" is-nav>
                    
                    <div class="" style="margin-left: auto">
                        <b-navbar-nav>
                            <b-nav-item-dropdown>
                                <template #button-content>
                                    <em>{{ user.name }}</em>
                                </template>
                                <b-dropdown-item href="#">Profile</b-dropdown-item>
                                <b-dropdown-item :href="route('logout')">Sign Out</b-dropdown-item>
                            </b-nav-item-dropdown>
                        </b-navbar-nav>
                    </div>
                </b-collapse>
            </div>
        </b-navbar>

        <div>
            <slot />
        </div>
    </div>
</template>
<script>
export default {
    name: 'Layout',
    props: {
        user: Object,
    },
    data() {
        return {

        }
    },
    mounted() {
        console.log('Component mounted.')
    },

}
</script>
