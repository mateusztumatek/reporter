import Layout from '@/AppMain.vue';

const websites =
    {
        path: '/categories',
        name: 'Websites',
        component: Layout,
        children: [
            {
                path: '/',
                component: () => import('@/views/categories/browse'),
                meta:{auth: true}
            },
            {
                path:'/categories/create',
                component: () => import('@/views/categories/edit-add'),
                meta: {auth:true}
            },
            {
                path:'/categories/:id',
                component: () => import('@/views/categories/edit-add'),
                meta: {auth:true}
            }
        ],
    };
export default websites;