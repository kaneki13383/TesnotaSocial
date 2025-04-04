<template>
  <div class="container block info" :style="{ 'background-color': me.profile_color }">
    <a @click="logout()">Выход</a>
    <div>
      <img v-if="load == true" src="../../../public/img/no_avatar.jpg" alt="" />
      <img v-if="load != true" :src="me.avatar" alt="" />
      <label for="changeAvatar">Изменить фотографию</label>
      <input type="file" accept=".png,.webp,.jpg,.jpeg" ref="avatar" @change="handleFile" id="changeAvatar" />
      <div v-if="load == true">
        <div class="active_loading"></div>
      </div>
      <p @click="modal = true">{{ me.name }} {{ me.surname }}</p>
    </div>
  </div>

  <CountPostFriendComponent class="dn" />

  <div class="background" v-if="modal == true">
    <div class="container block modal">
      <div>
        <a @click="modal = false">✖</a>
      </div>
      <form action="">
        <h1>Редактировать личные данные</h1>
        <div>
          <label for="name">Имя</label>
          <input id="name" type="text" v-model="name" />
        </div>
        <div>
          <label>Фамилия</label>
          <input id="" type="text" v-model="surname" />
        </div>
        <div>
          <label>Почта</label>
          <input id="" type="email" v-model="email" />
        </div>
        <div>
          <label>Цвет профиля</label>
          <input type="color" v-model="profile_color">
        </div>
        <button @click.prevent="changeProfile()">Сохранить</button>
      </form>
    </div>
  </div>


  <div class="container">
    <MyPostsComponentVue />
  </div>
</template>

<script>
import CountPostFriendComponent from "../components/CountPostFriendComponent.vue";
import MyPostsComponentVue from "../components/MyPostsComponent.vue";
export default {
  data() {
    return {
      load: true,
      me: [],
      modal: false,
      name: "",
      surname: "",
      email: "",
      profile_color: ''
    };
  },
  components: {
    MyPostsComponentVue,
    CountPostFriendComponent
  },
  updated() {
    console.log(this.profile_color);

  },
  mounted() {
    this.getMe();
    (this.name = this.$store.state.user.name),
      (this.surname = this.$store.state.user.surname),
      (this.email = this.$store.state.user.email),
      (document.title = "Профиль");
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
          this.$store.state.user.email = this.me.email;
          this.load = false;
          this.profile_color = this.me.profile_color
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
    changeProfile() {
      let fd = new FormData();
      fd.set("name", this.name);
      fd.set("surname", this.surname);
      fd.set("email", this.email);
      fd.set('profile_color', this.profile_color);
      axios
        .post("/api/change/profile", fd, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((res) => {
          this.getMe();
          this.$store.state.user.name = this.me.name;
          this.$store.state.user.surname = this.me.surname;
          this.$store.state.user.email = this.me.email;
          this.modal = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.dn{
  display: none;
}
.active_loading {
  background: linear-gradient(110deg, #525252, #474747 18%, #525252);
  border-radius: 5px;
  width: 270px;
  height: 28px;
  background-size: 200% 100%;
  animation: 1s shine linear infinite;
}

@keyframes shine {
  to {
    background-position-x: -200%;
  }
}

.background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: rgba(0, 0, 0, 0.6);

  a {
    cursor: pointer;
  }

  .modal {
    position: relative;
    z-index: 4;
    width: fit-content;

    a {
      position: absolute;
      top: 2px;
      right: 9px;
      color: #af3131;
      transition: 0.5s;
      font-size: 25px;
    }

    a:hover {
      cursor: pointer;
      color: red;
    }

    h1 {
      text-align: center;
      margin-top: 10px;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      width: 100%;

      div {
        display: flex;
        flex-direction: column;
        gap: 5px;

        input[type=color] {
          border: none;
          border-radius: 100px;
          padding: 0;
        }

        input {
          width: 320px;
          background: transparent;
          border: 2px solid #af3131;
          border-radius: 10px;
          height: 30px;
          padding-left: 5px;
        }
      }

      button {
        background: transparent;
        border: 2px solid #af3131;
        border-radius: 10px;
        padding: 5px 25px;
        transition: 0.5s;
      }

      button:hover {
        background: #af3131;
        color: #000;
        cursor: pointer;
      }
    }
  }
}

.info {
  position: relative;
  a {
    position: absolute;
    top: 25px;
    right: 30px;
    color: #af3131;
    transition: 0.5s;
  }

  a:hover {
    color: red;
    cursor: pointer;
  }

  div {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;

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

    img {
      width: 250px;
      height: 250px;
      border-radius: 50%;
    }

    p {
      font-size: 25px;
    }

    p::after {
      content: "✎";
      transform: scale(-1, 1);
      color: #dfbd25;
      position: absolute;
      padding-right: 10px;
      opacity: 0;
      transition: 0.2s;
    }

    p:hover::after {
      opacity: 1;
      cursor: pointer;
    }
  }
}

@media screen and (max-width: 1630px) {
  .info div {
    img {
      width: 200px;
      height: 200px;
    }

    label {
      width: 200px;
      height: 200px;
      font-size: 14px;
    }

    p {
      font-size: 20px;
    }
  }
}

@media screen and (max-width: 1054px) {
  .info div {
    p::after {
      opacity: 1;
    }
  }
  .dn{
    display: flex;
    justify-content: center;
  }
}
</style>