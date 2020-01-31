<template>
    <div class="container">
        <edit-add-component :model="category">

        </edit-add-component>
    </div>
</template>
<script>
    import EditAddComponent from '@/components/bread/edit-add';
    import Category from '../../models/category';
    export default {
        components:{
            EditAddComponent
        },
        data:() => {return{
            category: Category
        }}
    }
</script>