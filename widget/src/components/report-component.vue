<template>
    <div style="height: 100%">
        <perfect-scrollbar class="contacts">
            <v-toolbar class="my-toolbar" flat dense>
                <v-toolbar-items>
                    <v-btn color="primary" depressed>Sprawdź swoją reklamację</v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-form ref="report_form">
                <v-select :rules="[validations.required]" append-icon="mdi-arrow-down-thick" label="Wybierz kategorię reklamacji" :items="website.categories" v-model="report.category_id" item-value="id" item-text="name">
                    <template v-slot:item="{item}" :src="40">
                        <v-avatar class="ml-2" v-if="item.image">
                            <v-img :src="$root.getSrc(item.image)"></v-img>
                        </v-avatar>
                        <span class="ml-3">{{item.name}}</span>
                    </template>
                </v-select>
                <v-text-field  solo label="Nr zamówienia" v-model="report.reference_number"></v-text-field>
                <v-textarea :rules="[validations.required, validations.min]" v-model="report.description" outlined label="Opis reklamacji"></v-textarea>
                <file-component v-model="report.attachments"></file-component>
                <v-btn @click="sendReport()" class="w-100" color="primary">Wyślij reklamację</v-btn>
            </v-form>
        </perfect-scrollbar>
    </div>
</template>
<script>
    import FileComponent from './file-input';
    import {storeReport} from "../api/report";

    export default {
        components:{
            FileComponent
        },
        beforeDestroy(){
            this.$store.commit('SET_APPEARANCE', {width: 400, height: 400});
        },
        data(){
            return{
                fab:false,
                validations:{
                    required:(v) => !!v || 'ten element jest wymagany',
                    min:(v) => (v && v.length > 8) || 'Ten element powinien zawierać co najmniej 8 znaków'
                },
                load: false,
                report:{},
                completedReport:null,
            }
        },
        computed:{
            website(){return this.$store.getters.website},
        },
        mounted() {
            this.$store.commit('SET_APPEARANCE', {width: 400, height: 600});
        },
        methods:{
            sendReport(){
                if(this.$refs.report_form.validate()){
                    storeReport(this.report).then(res => {
                        this.completeReport = res;
                    }).catch(e => {
                        this.$store.dispatch('addMessage', {text: 'Coś poszło nie tak, spróbuj ponownie później', type: 'error'});
                    })
                }
            }
        }
    }
</script>
<style lang="scss">
    .my-toolbar{
        .v-toolbar__content{
            padding-left: 0px;
            padding-right: 0px;
        }
    }
</style>