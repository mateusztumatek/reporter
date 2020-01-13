<template>
     <div style="width: 100%">
          <v-container grid-list-xl fluid>
               <v-layout row wrap>
                    <v-flex sm12 md6 lg3>
                         <mini-statystic icon="mdi-home" title="100+" sub-title="Likes" color="primary"></mini-statystic>
                    </v-flex>
                    <v-flex sm12 md6 lg3>
                         <mini-statystic icon="mdi-home" title="100+" sub-title="Likes" color="primary"></mini-statystic>
                    </v-flex>
                    <v-flex sm12 md6 lg3>
                         <mini-statystic icon="mdi-home" title="100+" sub-title="Likes" color="primary"></mini-statystic>
                    </v-flex>
                    <v-flex sm12 md6 lg3>
                         <mini-statystic icon="mdi-home" title="100+" sub-title="Likes" color="primary"></mini-statystic>
                    </v-flex>
               </v-layout>
          </v-container>
     </div>
</template>

<script>
import {exampleRequest} from "../api/user";
import MiniStatystic from '../components/statystic/MiniStatistic'
export default {
     components:{
          MiniStatystic
     },
    mounted() {

    },
     methods:{
         sendNot(){

         }
     }
};
</script>
