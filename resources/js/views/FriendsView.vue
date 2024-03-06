<template>
    <div class="search">
        <input type="search" placeholder="Поиск друзей">
    </div>
    <div class="block">
        Тут будут друзья
    </div>
</template>

<script>
export default {
    data() {
        return {
            friends: []
        }
    },
    mounted() {
        this.my_friends()
    },
    methods: {
        my_friends() {
            axios
                .get("/api/me", {
                    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
                })
                .then((res) => {
                    this.me = res.data.content;
                    this.$store.state.user.avatar = this.me.avatar;
                    this.$store.state.user.name = this.me.name;
                    this.$store.state.user.surname = this.me.surname;
                    this.$store.state.user.email = this.me.email;

                    axios.get(`/api/my/friends/${this.$store.state.user.id}`)
                        .then(res => {
                            console.log(res);
                        })
                })
        }
    },
}
</script>

<style lang="scss" scoped>
.search {
    margin-top: 20px;

    input {
        width: 100%;
        height: 40px;
        background: transparent;
        border: 2px solid #af3131;
        border-radius: 10px;
        padding-left: 5px;
    }
}
</style>