<template>
  <div class="register container">
    <form action="">
      <div>
        <label for="">Имя</label>
        <input type="text" v-model="name" placeholder="Введите имя">
      </div>
      <div>
        <label for="">Фамилия</label>
        <input type="text" v-model="surname" placeholder="Введите фамилию">
      </div>
      <div>
        <label for="">Почта</label>
        <input type="email" v-model="email" placeholder="Введите почту">
      </div>
      <div>
        <label for="">Пароль</label>
        <input type="password" v-model="password" placeholder="Придумайте пароль">
      </div>
      <div>
        <label for="">Повторите пароль</label>
        <input type="password" v-model="password_repeat" placeholder="Повторите пароль">
      </div>
      <button @click.prevent="Register()">Зарегистрироваться</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      surname: "",
      email: "",
      password: "",
      password_repeat: "",
    };
  },
  updated() {
    if (localStorage.getItem("token")) {
      this.$router.push("/profile");
    }
  },
  methods: {
    Register() {
      if (this.password == this.password_repeat) {
        axios
          .post("/api/register", {
            name: this.name,
            surname: this.surname,
            email: this.email,
            password: this.password,
            password_repeat: this.password_repeat,
          })
          .then((res) => {
            localStorage.setItem("token", res.data["content"]);
            this.$router.push("/profile");
          });
      }
    },
    Login() {
      axios
        .post("/api/login", {
          email: this.email,
          password: this.password,
        })
        .then((res) => {
          localStorage.setItem("token", res.data["content"]);
          this.$router.push("/profile");
        });
    },
  },
};
</script>

<style lang="scss" scoped>
  .register{
    background-color: #272727;
    margin-top: 50px;
    border-radius: 10px;
    form{
      display: flex;
      flex-direction: column;
      gap: 20px;
      padding: 20px;
      div{
        display: flex;
        flex-direction: column;
        gap: 5px;
        input{
          background: transparent;
          border: 2px solid #af3131;
          border-radius: 5px;
          height: 30px;
          font-size: 15px;
          padding-left: 5px;
          padding-top: 10px;
          padding-bottom: 10px;
        }
      }
      button{
        cursor: pointer;
        background: transparent;
        width: 200px;
        border: 2px solid #af3131;
        border-radius: 5px;
        padding: 10px 0px;
      }
    }
  }
</style>