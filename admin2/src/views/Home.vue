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
                    <!-- social/weather card start -->
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
     computed:{
       siteTrafficData(){
            const shortMonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            const monthVisitData = shortMonth.map(m => {
                 return {
                      month: m,
                      "Unique Visit": Math.floor(Math.random() * 1000) + 200,
                      "Page View": Math.floor(Math.random() * 1000) + 250
                 }
            })
            return monthVisitData;
       }
     },
    mounted() {

    },
     methods:{
         sendNot(){

         }
     }
};
</script>
