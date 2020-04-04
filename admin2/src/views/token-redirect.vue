<template>
    <div>

    </div>
</template>
<script>
    import {setToken} from "../utilis/auth";

    export default {
        mounted() {
            setToken(this.$route.query.token);
            this.$router.push('/');
        }
    }
</script>