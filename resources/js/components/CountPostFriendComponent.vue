<template>
    <div class="block profile">
        <div>
            <p>Посты</p>
            <p>{{ posts.length }}</p>
        </div>
        <div>
            <p>Друзья</p>
            <p>{{ friends.length }}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            friends: [],
            posts: [],
            token: localStorage.getItem('token')
        }
    },
    mounted() {
        if (this.token != null) {
            this.my_friends()
            this.allPosts()
        }
    },
    methods: {
        my_friends() {
            axios
                .get("/api/my/friend", {
                    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
                })
                .then((res) => {
                    this.friends = res.data.data
                })
        },
        allPosts() {
            axios
                .get("/api/post/my", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                })
                .then((res) => {
                    this.posts = res.data.posts;
                })
        }
    },
}
</script>

<style lang="scss" scoped>
.profile {
    display: flex;
    flex-direction: row;
    gap: 30px;
    height: max-content;

    div {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
}
</style>