<template>
    <div class="container">
        <browse-component :model="website">
            <template v-slot:before_inside="{params}">
                <v-alert type="info" class="my-3" dismissible>W tym miejscu znajdziesz swoje strony.</v-alert>
            </template>
            <template v-slot:actions="{item}">
                <v-btn fab color="primary" small :to="'/websites/'+item.id"><v-icon>mdi-pencil</v-icon></v-btn>
            </template>
        </browse-component>
    </div>
</template>
<script>
    import BrowseComponent from '@/components/bread/browse';
    import Website from '../../models/website';
    export default {
        components:{BrowseComponent},
        data:() => {return{
            website: Website
        }}
    }
</script>