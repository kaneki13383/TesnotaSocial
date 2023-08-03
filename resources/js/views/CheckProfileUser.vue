<template>
  <div class="container block info">
    <div>
      <img :src="user.avatar" alt="" />
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
        });
    },
  },
};
</script>

<style lang="scss" scoped>
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