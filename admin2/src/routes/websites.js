import Layout from '@/AppMain.vue';

const websites =
    {
        path: '/websites',
        name: 'Websites',
        component: Layout,
        children: [
            {
                path: '/',
                component: () => import('@/views/websites/browse'),
                meta:{auth: true}
            },
            {
                path:'/websites/create',
                component: () => import('@/views/websites/edit-add'),
                meta: {auth:true}
            },
            {
                path:'/websites/:id',
                component: () => import('@/views/websites/edit-add'),
                meta: {auth:true}
            }
        ],
    };
export default websites;