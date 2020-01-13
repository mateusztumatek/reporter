<template>
    <div>

    </div>
</template>
<script>
    import {getWebsites} from "../../api_my/websites";

    export default {
        data(){
            return{
                websites:[],
            }
        },
        mounted() {
            this.getWebsites();
        },
        methods:{
            getWebsites(){
                getWebsites().then(response => {
                    this.websites = response;
                })
            }
        }
    }
</script>