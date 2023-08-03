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
  </div>

  <div class="container block"></div>
</template>

<script>
export default {
  data() {
    return {
      id: "",
      user: [],
      load: true,
    };
  },
  mounted() {
    this.getUser();
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
  a {
    float: right;
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
  }
}
</style>