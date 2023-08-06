import { createStore } from "vuex";
export default createStore({
    state() {
        return {
            user: {
                id: 0,
                name: '',
                surname: '',
                email: '',
                avatar: '',
            },
              page: 0
        }
    },
})