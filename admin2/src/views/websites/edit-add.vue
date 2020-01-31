<template>
    <div class="container">
        <edit-add-component :model="website">
                <template v-slot:additional_categories="{item}">
                    <v-select item-text="name" item-value="id" chips label="Wybierz kategorie" multiple v-model="item.categories" :items="categories"></v-select>
                </template>
        </edit-add-component>
    </div>
</template>
<script>
    import EditAddComponent from '@/components/bread/edit-add';
    import Website from '../../models/website'
    import {getData} from "../../api/bread";

    export default {
        components:{
            EditAddComponent
        },
        data:() => {return{
            website: Website,
            categories:[],
        }},
        computed:{
          user(){return this.$store.getters.user}
        },
        mounted() {
            this.getCategories();
        },
        methods:{
            getCategories(){
                getData('Category', {user_id: this.user.id}).then(response => {
                    this.categories = response.data;
                }).catch(e => [
                    this.$store.commit('app/ADD_MESSAGE', {text: 'Nie udało sie pobrać kategorii', type: 'error'})
                ])
            }
        }
    }
</script>