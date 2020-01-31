import {validURL} from "../validation";
import store from '../store';
export default {
    name: 'Website',
    display_name: 'Strony',
    create_header: 'Utwórz nową stronę',
    display:[
        {
            text: 'ID',
            value: 'id',
            sortable: false,
        },
        {
            text: 'Nazwa strony',
            value: 'name',
            sortable: true,
        },
        {
            text: 'Adres URL',
            value: 'url',
            sortable: true,
        },
        {
            text: 'Logo',
            value: 'logo',
            sortable: false,
            type: 'image',
        },
        {
            text: 'Nazwa strony',
            value: 'name',
            sortable: true,
        },
    ],
    fields_groups:[
        {
            width:{
                sm: 12,
                md: 8,
                lg:8
            },
            name: 'Dane podstawowe',
            label: 'Uzupełnij dane podstawowe twojej strony',
            fields:[
                {
                    type: 'text',
                    name: 'name',
                    label: 'Wpisz nazwę swojej strony',
                    validation: [
                        v => !!v || 'Name is required',
                        v => (v && v.length >= 3) || 'Nazwa musi mieć conajmniej 3 litery',
                    ]
                },
                {
                    type: 'text',
                    name: 'url',
                    label: 'Wpisz adres URL',
                    validation: [
                        v => !!v || 'Adres url jest wymagany',
                        v => validURL(v),
                    ]
                },{
                    type: 'media',
                    name: 'logo',
                    label: 'Wybierz logo',
                    validation: [
                        v => !!v || 'Logo jest wymagane',
                    ]
                }
            ]
        },
        {
            width:{
                sm: 12,
                md: 4,
                lg:4
            },
            id: 'categories',
            name: 'Kategorie strony',
            label: 'Wybierz kategorie strony',
            fields:[
                {
                    type: 'relation',
                    relation:{
                        model: 'Category',
                        type: 'multiple',
                        params: () => {
                            return {user_id: store.getters.user.id}
                        }
                    }
                    ,
                    name: 'categories',
                    label: 'Wybierz kategorie dla tej strony',
                },
            ]
        }
    ],
    adding: {
        to: '/websites/create',
        redirect: (item) => {return '/websites'},
    },
    edit:{
        redirect: (item) => { return '/websites'},
    },
    canDelete: true,
    canEdit: true
}