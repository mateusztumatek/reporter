import {validURL} from "../validation";

export default {
    name: 'Category',
    display_name: 'Kategorie',
    create_header: 'Utwórz nową kategorię',
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
            text: 'Obrazek',
            value: 'image',
            sortable: false,
            type: 'image'
        },
        {
            text: 'Opis kategorii',
            value: 'description',
            sortable: false,
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
            label: 'Uzupełnij dane kategorii',
            fields:[
                {
                    type: 'text',
                    name: 'name',
                    label: 'Wpisz nazwę kategorii',
                    validation: [
                        v => !!v || 'Name is required',
                        v => (v && v.length >= 3) || 'Nazwa musi mieć conajmniej 3 litery',
                    ]
                },
                {
                    type: 'text',
                    name: 'description',
                    label: 'Opis kategorii URL',
                    validation: []
                },{
                    type: 'media',
                    name: 'image',
                    label: 'Wybierz obrazek',
                    validation: []
                }
            ]
        }
    ],
    adding: {
        to: '/categories/create',
        redirect: (item) => {return '/categories'},
    },
    edit:{
        redirect: (item) => { return '/categories'},
    },
    canDelete: true,
    canEdit: true
}