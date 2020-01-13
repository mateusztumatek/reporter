<template>
    <div class="list-table">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <v-flex sm12>
                    <v-card :loading="load">
                        <v-toolbar color="transparent" flat dense card>
                            <v-toolbar-title
                            ><h4>{{ $t('Twoje strony') }}</h4></v-toolbar-title
                            >
                            <v-spacer></v-spacer>
                            <slot name="widget-header-action">
                                <v-btn text flat icon @click="getWebsites()"><v-icon>refresh</v-icon></v-btn>
                            </slot>
                        </v-toolbar>
                        <v-card-text>

                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
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
                this.startLoading();
                getWebsites().then(response => {
                    this.websites = response;
                    this.stopLoading();
                })
            }
        }
    }
</script>