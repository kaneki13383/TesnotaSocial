<template>
    <div class="block friends">
        <span>Возможно знакомы</span>
        <div v-for="frined in maby_friends" :key="frined">
            <router-link :to="{ path: '/user/' + frined.id }">
                <img :src="frined.avatar" alt="">
                <p>{{ frined.name }}</p>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            maby_friends: [],
            token: localStorage.getItem('token')
        }
    },
    mounted() {
        if (this.token != null) {
            this.get_maby_frineds();
        }
    },
    methods: {
        get_maby_frineds() {
            axios.get('/api/maby/frineds', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                }
            })
                .then(res => {
                    this.maby_friends = res.data;
                })
        },
    },
}
</script>

<style lang="scss" scoped>
.friends {
    width: 20%;
    height: max-content;

    span {
        text-align: center;
    }

    div {
        margin-top: 20px;

        a {
            text-decoration: none;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;

            img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
            }
        }
    }
}
</style>