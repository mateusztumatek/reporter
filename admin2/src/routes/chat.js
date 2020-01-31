import Layout from '@/AppMain.vue';

const websites =
    {
        path: '/chat',
        name: 'Czat',
        component: Layout,
        children: [
            {
                path: '/chat',
                component: () => import('@/views/chat/browse'),
                meta:{auth: true},
                children:[
                    {
                        path:'/chat/:hash',
                        component: () => import('@/views/chat/message-form'),
                        meta:{auth:true}
                    }
                ]
            },
        ],
    };
export default websites;