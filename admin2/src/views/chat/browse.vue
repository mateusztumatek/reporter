<template>
    <div>
        <div class="row mx-0">
            <contact-list></contact-list>
            <div style="flex-grow: 1">
                <div class="container w-100 pb-0" style="height: 100%">
                    <router-view></router-view>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import ContactList from './contact-list';
    export default {
        components:{ContactList},
        mounted() {
            this.$store.dispatch('chat/getChats');
        }
    }
</script>