<template>
    <div>
        <v-card>
            <v-card-title>{{model.display_name}}</v-card-title>
            <v-card-text>
                <slot name="before_inside" :params="params"></slot>
                <v-data-table
                        :headers="headers"
                        :items="data.data"
                        :options.sync="table_params"
                        :loading="load"
                >
                    <template v-for="header in model.display" v-slot:[getSlotName(header.value)]="{item}">
                        <span v-if="!header.type || header.type == 'text'">{{item[header.value]}}</span>
                        <span v-if="header.type == 'image'">
                            <v-img v-if="item[header.value]" max-width="40px" max-height="40px" class="my-2" :src="getSrc(item[header.value])"></v-img>
                        </span>
                    </template>
                    <template v-slot:item.actions="{item}">
                        <slot name="actions" :item="item"></slot>
                    </template>
                </v-data-table>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" v-if="model.adding" :to="model.adding.to">Dodaj</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
    import {getData} from "../../api/bread";

    export default {
        props:{
            model: Object,
        },
        watch:{
            params:{
                deep: true,
                handler: function () {
                    if(this.timeout){
                        console.log('GFWIAGHWA');
                        this.getData();
                    }
                }
            },
            table_params:{
                deep: true,
                handler: function () {
                    if(this.timeout){
                        console.log('GFWIAGHWA');
                        this.getData();
                    }
                }
            }
        },
        computed:{
            headers() {
                return this.model.display.concat({text: 'Akcje', value: 'actions', sortable: false});
            },
            query_params(){
                var params = {};
                params.page = this.table_params.page;
                (this.table_params.itemsPerPage == -1)? params.per_page = 10000000 : params.per_page = this.table_params.itemsPerPage;
                if(typeof this.table_params.sortBy == 'object') params.sort_by = this.table_params.sortBy[0];
                if(typeof this.table_params.sortDesc == 'object'){
                    if(this.table_params.sortDesc[0]){
                        params.sort_desc = 1;
                    }
                }
                params = {...params, ...this.params};
                return params;
            }
        },
        data:() => {return {
            timeout: false,
            table_params:{},
            params: {},
            data:{},
            load: false,
        }},
        mounted() {
            this.getData();
            setTimeout(() => {
                this.timeout = true;
            }, 1000)
        },
        methods:{
            getSlotName(value){
                return 'item.'+value;
            },
            getData(){
                this.load = true;
                getData(this.model.name, this.query_params).then(response => {
                    this.data = response;
                    this.load = false;
                })
            }
        }
    }
</script>