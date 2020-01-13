const getters = {
    sidebar: (state) => {return state.navigation.sidebar},
    title: (state) => {return state.navigation.title},
    header: (state) => {return state.navigation.header},
    user: (state) => {return state.user.user},
    location: (state) => {return state.user.location},
    mobile: (state) => {return  state.navigation.mobile},
    verified: (state) => {return state.user.user.email_verified_at},
    app: (state) => {return state.app.app},
    notifications: (state) => {return state.notifications.notifications},
    messages: (state) => {return state.app.app.messages},
};
export default getters;