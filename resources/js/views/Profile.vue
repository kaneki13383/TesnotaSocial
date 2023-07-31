<template>
  <div class="container block">
    <div>
      <img :src="me.avatar" alt="" />
      <label for="changeAvatar">Выберите фотографию</label>
      <input type="file" ref="avatar" @change="handleFile" id="changeAvatar" />
      <p>{{ me.name }} {{ me.surname }}</p>
    </div>
    <a @click="logout()">Выход</a>
  </div>

  <div class="container block"></div>
</template>

<script>
export default {
  data() {
    return {
      me: [],
    };
  },
  mounted() {
    this.getMe();
    document.title = "Профиль";
  },
  methods: {
    getMe() {
      axios
        .get("/api/me", {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((res) => {
          this.me = res.data.content;
          this.$store.state.user.avatar = this.me.avatar;
          this.$store.state.user.name = this.me.name;
          this.$store.state.user.surname = this.me.surname;
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
        .then((res) => {
          localStorage.removeItem("token");
          this.$router.push("/");
        });
    },
    handleFile() {
      this.file = this.$refs.avatar.files[0];
      let fd = new FormData();
      fd.set("avatar", this.file);
      axios
        .post("/api/change/avatar", fd, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((res) => {
          this.me.avatar = res.data.content;
          this.getMe();
        });
    },
  },
};
</script>

<style lang="scss" scoped>
a {
  cursor: pointer;
}
label {
  opacity: 0;
  background: rgba(0, 0, 0, 0.452);
  width: 250px;
  height: 250px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  transition: 0.5s;
}
label:hover {
  opacity: 1;
  cursor: pointer;
}

input[type="file"] {
  display: none;
}
.block {
  a {
    float: right;
  }
  div {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    img {
      width: 250px;
      height: 250px;
      border-radius: 50%;
    }
    p {
      font-size: 25px;
    }
  }
}
</style>