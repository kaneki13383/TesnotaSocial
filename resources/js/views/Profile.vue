<template>
  <div>Profile</div>
  <p>Имя: {{ me.name }}</p>
  <a @click="logout()">Выход</a>
</template>

<script>
export default {
  data() {
    return {
      me: {},
    };
  },
  mounted() {
    this.getMe();
  },
  methods: {
    getMe() {
      axios
        .get("/api/me", {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((res) => {
          this.me = res.data.content;
        })
        .catch((err) => {
          this.$router.push("/");
        });
    },
    logout() {
      axios
        .get("/api/logout", {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((response) => {
          localStorage.removeItem("token");
          this.$router.push("/");
        });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>