export default {
    data:() => {return {
        rules:{
            required: (v) => !!v || 'Te pole jest wymagane',
            email: v => /.+@.+\..+/.test(v) || 'Te pole musi być poprawnym adresem email',
        }
    }},
}