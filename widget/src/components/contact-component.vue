<template>
    <div style="height: 100%">
        <div class="w-100 d-flex justify-center" v-if="loading">
            <v-progress-circular
                    :size="50"
                    color="primary"
                    indeterminate
            ></v-progress-circular>
        </div>
        <perfect-scrollbar key="contacts" v-if="!activeContact" ref="messages" class="contacts">
            <v-list two-line>
                <template v-for="(item,  index) in contacts">
                    <v-divider v-if="index != 0"></v-divider>
                    <v-list-item
                            :key="item.id"
                            @click="$store.commit('SET_ACTIVE_CONTACT', item)"
                    >
                        <v-list-item-avatar>
                            <v-img :src="$root.getSrc(item.photo)"></v-img>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title v-html="item.name"></v-list-item-title>
                            <p class="mb-0">{{item.email}}</p>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
        </perfect-scrollbar>
        <perfect-scrollbar key="single" class="text-center contacts" v-if="activeContact" :settings="{useBothWheelAxes:false, wheelSpeed: 0.1, suppressScrollX: false}">
            <div>
                <v-avatar size="110">
                    <v-img :src="$root.getSrc(activeContact.photo)"></v-img>
                </v-avatar>
                <h3 class="my-2">{{activeContact.name}}</h3>
                <div class="my-1">
                    <v-icon class="mr-3" v-if="activeContact.email">mdi-email</v-icon>{{activeContact.email}}
                </div>
                <div class="my-1">
                    <v-icon class="mr-3" v-if="activeContact.phone">mdi-phone</v-icon>{{activeContact.phone}}
                </div>
                <div class="my-1">
                    <v-icon class="mr-3" v-if="activeContact.phone">mdi-calendar</v-icon>{{activeContact.hour_from}} - {{activeContact.hour_to}}
                </div>
                <div>
                    <span v-html="activeContact.description"></span>
                </div>
            </div>
        </perfect-scrollbar>
    </div>
</template>
<script>
    export default {
        data:() => {
            return{
                loading: true,
            }
        },
        computed:{
            activeContact(){return this.$store.getters.activeContact},
            contacts(){return this.$store.getters.contacts}
        },
        mounted() {
            this.$store.dispatch('getContacts').then(res => {this.loading = false;})
        }
    }
</script>