<template>
    <div class="container">
        <browse-component :model="category">
            <template v-slot:before_inside="{params}">
                <v-alert type="info" class="my-3" dismissible>W tym miejscu znajdziesz swoje strony.</v-alert>
            </template>
            <template v-slot:actions="{item}">
                <v-btn fab color="primary" small :to="'/categories/'+item.id"><v-icon>mdi-pencil</v-icon></v-btn>
            </template>
        </browse-component>
    </div>
</template>
<script>
    import BrowseComponent from '@/components/bread/browse';
    import Category from '../../models/category';
    export default {
        components:{BrowseComponent},
        data:() => {return{
            category: Category
        }}
    }
</script>