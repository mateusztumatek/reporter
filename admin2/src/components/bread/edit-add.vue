<template>
    <div class="edit-add">
        <v-container grid-list-xl fluid>
                <v-row>
                    <v-fab-transition>
                        <v-btn
                                :loading="load"
                                color="primary"
                                dark
                                absolute
                                top
                                right
                                fab
                                @click="save()"
                                style="top: 30px"
                        >
                            <v-icon>mdi-content-save</v-icon>
                        </v-btn>
                    </v-fab-transition>
                    <v-form ref="form" lazy-validation class="row">
                        <v-col :sm="group.width.sm" :md="group.width.md" :lg="group.width.lg" v-for="(group,id) in model.fields_groups">
                            <v-card :loading="load">
                                <v-card-title>
                                    {{group.name}}
                                </v-card-title>
                                <v-card-text>
                                    <p>{{group.label}}</p>
                                    <div v-for="field in group.fields">
                                        <v-text-field :error="errors[field.name] != null" :error-messages="errors[field.name]" v-if="field.type == 'text'" v-model="item[field.name]" :rules="field.validation" :label="field.label"></v-text-field>
                                        <media-picker v-model="item[field.name]" :rules="field.validation" v-if="field.type == 'media'"></media-picker>
                                    </div>
                                    <slot :name="'additional_'+group.id" :item="item"></slot>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-form>
                </v-row>
        </v-container>
    </div>
</template>
<script>
    import {saveData, getSingleData, updateData} from "../../api/bread";
    import MediaPicker from '@/components/media-picker';
    export default {
        props:{model: Object},
        components:{
            MediaPicker
        },
        data: () => {return {
            item:{},
            load: false,
            errors:[]
        }},
        computed:{
            editing(){
                if(this.item.id){
                    return true;
                }
                return false;
            }
        },
        mounted(){
            if(this.$route.params.id){
                this.getModel();
            }
        },
        methods:{
            save(){
                this.load = true;
                this.errors = [];
                if(this.$refs.form.validate()){
                    if(this.item.id){
                        var func = updateData(this.model.name, this.item.id, this.item);
                    }else{
                        var func = saveData(this.model.name, this.item);
                    }
                    func.then(response => {
                        this.load = false;
                        if(this.editing){
                            if(this.model.edit && typeof this.model.edit.redirect == 'function'){
                                this.$router.push(this.model.edit.redirect(response));
                            }
                        }else{
                            if(this.model.adding && typeof this.model.adding.redirect == 'function') this.$router.push(this.model.adding.redirect(response));
                        }
                    }).catch(e => {
                        this.load = false;
                        if(e.response && e.response.data && e.response.data.errors){
                            this.errors = e.response.data.errors;
                        }
                    })
                }else{
                    this.load = false;
                }
            },
            getModel(){
                this.load = true;
                getSingleData(this.model.name, this.$route.params.id).then(response => {
                    this.item = response;
                    this.load = false;
                }).catch(e => {
                    if(e.response.status == 403){
                        this.$router.go(-1);
                        this.$store.commit('app/ADD_MESSAGE', {text: 'Brak dostępu', type:'error'});
                        return;
                    }
                    this.$router.go(-1);
                    this.$store.commit('app/ADD_MESSAGE', {text: e.response.data.message, type:'error'});
                    this.load = false;
                })
            }
        }
    }
</script>
<style lang="scss">
    .edit-add{

    }
</style>