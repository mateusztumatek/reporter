import Layout from '@/AppMain.vue';

const websites =
    {
        path: '/contacts',
        name: 'Contacts',
        component: Layout,
        children: [
            {
                path: '/contacts',
                component: () => import('@/views/contacts/edit-add'),
                meta:{auth: true}
            },
        ],
    };
export default websites;