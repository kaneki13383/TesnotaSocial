<template>
  <form id="hide" action="">
    <input type="text" v-model="text" placeholder="Расскажите, что у вас нового!" @click.prevent="OpenCreatePost()" />
    <transition name="slide-fade">
      <div v-if="create_post == true" style="display: flex; flex-direction: column; gap: 10px">
        <input multiple type="file" id="file" ref="file" accept=".png,.webp,.jpg,.jpeg" required
          v-on:change="handleFileUpload()" />
        <button @click="addFiles()">Выбрать фото</button>
        <button @click.prevent="createPost()">Опубликовать</button>

        <div class="preview_photo">
          <div v-for="(photo, index) in url" :key="photo" id="preview">
            <p @click="url.splice(index, 1), removeFile(index)" id="hide" class="remove_photo">
              ✖
            </p>
            <img v-if="url" :src="photo" />
          </div>
        </div>
      </div>
    </transition>

    <transition name="slide-fade">
      <div v-if="message != ''" @click="message = ''" class="message">
        <p>{{ message }}</p>
      </div>
    </transition>

    <transition name='slide-fade'>
      <div v-if="error != ''" @click="error = ''" class="error">
        <p>{{ error }}</p>
      </div>
    </transition>

  </form>
  <PostsComponent ref="PostsComponent" />
</template>

<script>
import PostsComponent from "../components/PostsComponent.vue";
export default {
  data() {
    return {
      create_post: false,
      text: "",
      message: "",
      error: "",
      files: [],
      url: [],
    };
  },
  components: {
    PostsComponent,
  },
  mounted() {
    document.title = "Новости";
  },
  methods: {
    CloseCreatePost: function (event) {
      if (!event.target.matches("#hide")) {
        var info = document.getElementById("hide");
        if (!info.contains(event.target)) {
          this.create_post = false;
        } else {
          this.create_post = true;
        }
      }
    },
    OpenCreatePost() {
      this.create_post = true;
      window.onclick = this.CloseCreatePost;
    },
    removeFile(key) {
      this.files.splice(key, 1);
    },
    addFiles() {
      this.$refs.file.click();
    },
    handleFileUpload() {
      let uploadedFiles = this.$refs.file.files;

      for (var i = 0; i < uploadedFiles.length; i++) {
        this.files.push(uploadedFiles[i]);
      }
      const preview = this.$refs.file.files;
      for (let index = 0; index < preview.length; index++) {
        this.url.push(URL.createObjectURL(preview[index]));
      }
    },
    createPost() {
      let fd = new FormData();
      fd.set("text", this.text);
      for (let index = 0; index < this.files.length; index++) {
        fd.append("file[]", this.files[index]);
      }
      axios
        .post("/api/post/create", fd, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((res) => {
          this.text = "";
          this.message = res.data.message;
          setTimeout((ers) => {
            this.message = ''
          }, 3000)
          this.create_post = false;
          this.files = [];
          this.url = [];
          this.$refs.PostsComponent.allPosts();
          window.addEventListener("scroll", this.ScrollCheck);
        })
        .catch((err) => {
          this.error = err.message;
          setTimeout((ers) => {
            this.message = ''
          }, 3000)
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s ease-out;
}

.slide-fade-enter-from {
  transform: translateY(-50px);
  opacity: 0;
}

.slide-fade-leave-to {
  transform: translateY(50px);
  opacity: 0;
}

form {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 10px;

  input {
    outline: none;
    width: 100%;
    background: transparent;
    border: 2px solid #af3131;
    height: 40px;
    border-radius: 10px;
    padding-left: 5px;
    margin-top: 20px;
  }

  input[type="file"] {
    width: auto;
    position: absolute;
    top: -500px;
  }

  div {
    button {
      cursor: pointer;
      background: transparent;
      padding: 5px 25px;
      border: 2px solid #af3131;
      border-radius: 10px;
    }
  }
}

.message {
  cursor: pointer;
  background: #155f0b;
  padding: 10px 25px;
  border-radius: 10px;
}

.error {
  cursor: pointer;
  background: #5f0b0b;
  padding: 10px 25px;
  border-radius: 10px;
}

.preview_photo {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;

  div img {
    max-width: 400px;
  }
}

@media screen and (max-width: 1054px) {
  .preview_photo div img {
    max-width: 400px;
  }
}


@media screen and (max-width: 455px) {
  .preview_photo div img {
    max-width: 200px;
  }
}
</style>