<template>
  <div class="container block info">
    <div>
      <img v-if="load == true" src="../../../public/img/no_avatar.jpg" alt="" />
      <img v-if="load != true" :src="user.avatar" alt="" />
      <div v-if="load == true">
        <div class="active_loading"></div>
      </div>
      <p>{{ user.name }} {{ user.surname }}</p>
    </div>
    <button v-if="butt == 'Добавить в друзья'" class="add_friend" @click.prevent="add_friend()">Добавить в друзья
      +</button>
    <button v-if="butt == 'Запрос в друзья отправлен'" class="add_friend">Запрос в друзья отправлен</button>
    <button v-if="butt == 'Хочет добавить вас в друзья'" class="add_friend" @click.prevent="accept_frined()">Хочет
      добавить вас в друзья</button>
    <button v-if="butt == 'У вас в друзьях'" class="add_friend">У вас в друзьях</button>
  </div>

  <div class="container">
    <CheckUserPostsComponent />
  </div>
</template>

<script>
import CheckUserPostsComponent from "../components/CheckUserPostsComponent.vue";
export default {
  data() {
    return {
      id: 0,
      user: [],
      load: true,
      butt: 'Добавить в друзья'
    };
  },
  components: {
    CheckUserPostsComponent,
  },
  mounted() {
    this.getUser();
    this.check_friend();
  },
  methods: {
    getUser() {
      let url = window.location.pathname;
      this.id = url.split("/")[2];
      axios
        .get(`/api/user/${this.id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((res) => {
          this.user = res.data;
          this.load = false;
        });
    },
    add_friend() {
      axios.post(`/api/add_friend/${this.id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        id_user: this.$store.state.user.id,
      })
        .then(res => {
          this.check_friend()
        })
    },
    check_friend() {
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

          axios.get(`/api/check/friend/${this.user.id}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
          })
            .then(res => {
              this.butt = res.data
            })

        })
        .catch((err) => {
          this.$router.push("/");
        });
    },
    accept_frined() {
      axios.get(`/api/accept/friend/${this.$store.state.user.id}`)
        .then(res => {
          this.butt = res.data
          this.check_friend();
        })
    }
  },
};
</script>

<style lang="scss" scoped>
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

.info {
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

  .add_friend {
    cursor: pointer;
    background: transparent;
    border: 1px solid #fff;
    color: #fff;
    padding: 10px 10px;
    border-radius: 10px
  }
}
</style>