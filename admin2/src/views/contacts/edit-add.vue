<template>
    <v-container>
        <v-form ref="form">
            <v-btn @click="save()" style="top:30px" absolute top right fab color="primary">
                <v-icon>mdi-content-save</v-icon>
            </v-btn>
            <v-row v-if="contacts">
                <v-col xl="3" lg="4" md="6">
                    <v-card :loading="loading" class="py-10">
                        <div class="text-center">
                            <v-btn @click="newElem()" fab x-large color="primary"><v-icon>mdi-plus</v-icon></v-btn>
                        </div>
                    </v-card>
                </v-col>
                <v-col xl="3" lg="4" md="6" v-for="(contact,id) in contacts.data">
                    <v-card
                            :loading="loading"
                    >
                        <v-img
                                height="250"
                                :src="(contact.photo)? $root.getSrc(contact.photo) : $root.getSrc('default/avatar.jpg')"
                        >
                            <media-picker :icons="false" v-model="contact.photo"></media-picker>
                        </v-img>
                        <v-card-text>
                            <v-select :rules="[rules.required]" label="Wybierz stronę" :items="websites" item-text="name" item-value="id" v-model="contact.website_id"></v-select>
                            <v-text-field label="Imię i nazwisko" v-model="contact.name" :rules="[rules.required]"></v-text-field>
                            <v-text-field label="Adres email" v-model="contact.email" :rules="[rules.required, rules.email]"></v-text-field>
                            <v-text-field label="Telefon" v-model="contact.phone"></v-text-field>
                            <v-textarea label="Opis kontaktu" v-model="contact.description"></v-textarea>
                            <v-row>
                                <v-col cols="6" sm="6">
                                    <v-menu
                                            ref="menu"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            max-width="290px"
                                            min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                    :rules="[rules.required]"
                                                    v-model="contact.hour_from"
                                                    label="Wybierz czas pracy od"
                                                    prepend-icon="access_time"
                                                    readonly
                                                    v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                                :rules="[rules.required]"
                                                format="24hr"
                                                v-model="contact.hour_from"
                                                full-width
                                        ></v-time-picker>
                                    </v-menu>
                                </v-col>
                                <v-col cols="6" sm="6">
                                    <v-menu
                                            ref="menu2"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            transition="scale-transition"
                                            offset-y
                                            max-width="290px"
                                            min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                    :rules="[rules.required]"
                                                    v-model="contact.hour_to"
                                                    label="Wybierz czas pracy do"
                                                    prepend-icon="access_time"
                                                    readonly
                                                    v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                                format="24hr"

                                                v-model="contact.hour_to"
                                                full-width
                                        ></v-time-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="red" @click="contacts.data.splice(id, 1)">Usuń</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-form>

    </v-container>
</template>
<script>
    import {getData} from "../../api/bread";
    import {saveContacts} from "../../api/contacts";
    import MediaPicker from "../../components/media-picker";
    import validations from '../../utilis/validations';
    export default {
        mixins:[validations],
        components: {MediaPicker},
        data:()=> {return{
            contacts:null,
            loading:false,
        }},
        computed:{
            websites(){
                return this.$store.getters.websites;
            }
        },
        mounted() {
            getData('Contact', {per_page: 100000}).then(res => {
                this.contacts = res;
            })
        },
        methods:{
            save(){
                if(this.$refs.form.validate()){
                    this.loading = true;
                    saveContacts({contacts: this.contacts.data}).then(res => {
                        this.loading = false;
                    })
                }
            },
            newElem(){
                this.contacts.data.push({});
            }
        }
    }
</script>