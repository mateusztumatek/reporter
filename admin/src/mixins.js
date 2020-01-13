export default {
    data(){
        return{
            load: false,
        }
    },
    methods:{
        startLoading(){
            this.load = true;
        },
        stopLoading(){
            this.load = false;
        }
    }
}