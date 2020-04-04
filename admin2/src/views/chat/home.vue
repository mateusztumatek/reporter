<template>
    <div>
        <v-row>
            <v-col md="6">
                <v-card>
                    <v-card-title>Ustawienia czatu</v-card-title>
                    <v-card-text>
                        <label>Wybierz kolor główny</label>
                        <v-color-picker v-model="chat_settings.primary" label="Kolor podstawowy"></v-color-picker>
                        <media-picker label="Logo wyświetlane w oknie" v-model="chat_settings.logo" class="mt-5"></media-picker>
                        <v-textarea label="Wiadomość w głównym oknie" v-model="chat_settings.main_message"></v-textarea>
                        <v-btn color="primary" dark class="w-100">Zapisz ustawienia</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col md="6">
                <iframe ref="frame_elem" class="w-100" src="http://localhost:8081/dist" frameborder="0" scrolling="no" style="border: none; overflow: hidden !important; height: 665px"></iframe>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import MediaPicker from "../../components/media-picker";
    export default {
        components: {MediaPicker},
        data:() => {return {
           chat_settings:{
               primary: '#000000'
           },
           iframe_object: null,
        }},
        watch:{
            chat_settings:{
                deep: true,
                handler: function () {
                    if(this.iframe_object){
                        this.iframe_object.contentWindow.postMessage({type: 'chat_settings', chat_settings: this.chat_settings}, '*');
                    }
                }
            }
        },
        mounted() {
            window.addEventListener('message', msg => {
                if(msg.data && msg.data.width){
                    this.$refs.frame_elem.style.height = msg.data.height;
                }
            })
            this.$refs.frame_elem.onload = (elem) => {
                this.iframe_object = elem.target;
                elem = elem.target;
                setTimeout(() => {
                    elem.contentWindow.postMessage({type: 'open_window'}, '*');
                }, 400)

            }
        }
    }
</script>