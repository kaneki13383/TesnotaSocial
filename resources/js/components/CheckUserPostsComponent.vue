<template>
  <!-- Сами посты v-for="(post, index) in posts" :key="post"-->
  <div v-for="(post, index) in posts.posts" :key="post" class="block post">
    <div class="header_post">
      <div>
        <router-link
          v-if="this.$store.state.user.id != post.id_user.id"
          :to="{ path: '/user/' + post.id_user.id }"
          ><img :src="post.id_user.avatar" alt=""
        /></router-link>
        <router-link
          v-if="this.$store.state.user.id == post.id_user.id"
          :to="{ path: '/profile' }"
          ><img :src="post.id_user.avatar" alt=""
        /></router-link>
        <div>
          <router-link
            v-if="this.$store.state.user.id != post.id_user.id"
            :to="{ path: '/user/' + post.id_user.id }"
            ><p>
              {{ post.id_user.name }} {{ post.id_user.surname }}
            </p></router-link
          >
          <router-link
            v-if="this.$store.state.user.id == post.id_user.id"
            :to="{ path: '/profile' }"
            ><p>
              {{ post.id_user.name }} {{ post.id_user.surname }}
            </p></router-link
          >
          <p>{{ getHumanDate(post.created_at) }}</p>
        </div>
      </div>
      <div
        v-if="this.$store.state.user.id == post.id_user.id"
        class="actions"
        @mouseover="Actions(post.action, index)"
        @mouseleave="CloseActions(post.action, index)"
      >
        <div>
          <svg
            fill="#606060"
            width="30px"
            height="30px"
            viewBox="0 0 32 32"
            enable-background="new 0 0 32 32"
            id="Glyph"
            version="1.1"
            xml:space="preserve"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            stroke="#606060"
          >
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g
              id="SVGRepo_tracerCarrier"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></g>
            <g id="SVGRepo_iconCarrier">
              <path
                d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z"
                id="XMLID_287_"
              ></path>
              <path
                d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z"
                id="XMLID_289_"
              ></path>
              <path
                d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z"
                id="XMLID_291_"
              ></path>
            </g>
          </svg>
        </div>

        <div v-if="post.action == true" class="dropdown-content">
          <p @click="DeletePost(post.id, index)">Удалить</p>
          <p>Редактировать</p>
          <p>Репост</p>
        </div>
      </div>
    </div>
    <div class="body_post">
      <p>
        {{ post.text }}
      </p>

      <Carousel v-if="post.photos.length > 1">
        <Slide v-for="slide in post.photos" :key="slide">
          <img :src="slide.photo" alt="" />
        </Slide>

        <template #addons>
          <Navigation />
          <Pagination />
        </template>
      </Carousel>
      <img
        v-else-if="post.photos.length == 1"
        :src="'/' + post.photos[0].photo"
        alt=""
      />
    </div>
    <div class="footer_post">
      <div @click="addLike(post.id, index)">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="34"
          height="40"
          viewBox="0 0 34 40"
          fill="none"
          v-if="post.active_like == true"
        >
          <ellipse cx="22.75" cy="16.5" rx="6.25" ry="8.5" fill="#AF3131" />
          <ellipse cx="22.75" cy="16.5" rx="6.25" ry="8.5" fill="#AF3131" />
          <ellipse cx="22.75" cy="16.5" rx="6.25" ry="8.5" fill="#AF3131" />
          <path
            d="M23.0625 6.25C20.8583 6.25 18.7989 7.35125 17.3333 9.2575C15.8677 7.35125 13.8083 6.25 11.6042 6.25C7.29582 6.25 3.79166 10.4163 3.79166 15.625C3.79166 26.9275 17.3333 33.75 17.3333 33.75C17.3333 33.75 30.875 26.9275 30.875 15.625C30.875 10.4163 27.3708 6.25 23.0625 6.25ZM17.3333 30.9963C14.6021 29.4013 5.87499 23.6725 5.87499 15.625C5.87499 11.8337 8.44478 8.75 11.6042 8.75C13.2187 8.75 14.7104 9.5325 15.8021 10.9525L16.5677 11.9488H18.0989L18.8646 10.9525C19.9562 9.5325 21.4479 8.75 23.0625 8.75C26.2219 8.75 28.7917 11.8337 28.7917 15.625C28.7917 23.6725 20.0646 29.4013 17.3333 30.9963Z"
            fill="#AF3131"
          />
          <ellipse
            cx="11.9166"
            cy="16.5"
            rx="7.08333"
            ry="8.5"
            fill="#AF3131"
          />
          <ellipse
            cx="17.3333"
            cy="24.5"
            rx="8.33333"
            ry="6.5"
            fill="#AF3131"
          />
        </svg>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="34"
          height="40"
          viewBox="0 0 34 40"
          fill="none"
          v-else
        >
          <path
            d="M11.6042 10V12.5C10.1687 12.5 8.99999 13.9013 8.99999 15.625H6.91666C6.91666 12.5238 9.01978 10 11.6042 10Z"
            fill="#AF3131"
          />
          <path
            d="M23.0032 6.25C20.8058 6.25 18.7528 7.33123 17.2917 9.20282C15.8305 7.33123 13.7775 6.25 11.5801 6.25C7.28504 6.25 3.79166 10.3405 3.79166 15.4545C3.79166 26.5515 17.2917 33.25 17.2917 33.25C17.2917 33.25 30.7917 26.5515 30.7917 15.4545C30.7917 10.3405 27.2983 6.25 23.0032 6.25ZM17.2917 30.5463C14.5688 28.9803 5.86858 23.3557 5.86858 15.4545C5.86858 11.7322 8.43046 8.70455 11.5801 8.70455C13.1897 8.70455 14.6768 9.47282 15.7651 10.867L16.5284 11.8451H18.0549L18.8182 10.867C19.9065 9.47282 21.3936 8.70455 23.0032 8.70455C26.1528 8.70455 28.7147 11.7322 28.7147 15.4545C28.7147 23.3557 20.0145 28.9803 17.2917 30.5463Z"
            fill="#AF3131"
          />
        </svg>
        <p>{{ post.countLikes }}</p>
      </div>
      <div
        @click="
          (modal = true),
            (id_post = post.id),
            (index_post = index),
            allComments()
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="29"
          height="33"
          viewBox="0 0 29 33"
          fill="none"
        >
          <g clip-path="url(#clip0_6_51)">
            <path
              d="M14.9323 2.0625C7.36981 2.0625 0.666687 7.425 0.666687 13.6125C0.666687 17.7375 2.55731 21.2437 5.82294 23.3062V23.5125C5.65106 26.1937 4.27606 27.0188 4.27606 27.0188L1.18231 28.875H4.61981C8.91669 28.875 12.0104 26.6063 13.3854 24.9563C13.9011 24.9563 14.2448 24.9563 14.7604 24.9563C22.1511 24.9563 28.1667 19.8 28.1667 13.4062C28.1667 7.0125 22.3229 2.0625 14.9323 2.0625ZM14.7604 22.8938C14.2448 22.8938 13.5573 22.8938 13.2136 22.8938H12.6979L12.3542 23.3062C11.4948 24.3375 9.60419 26.1938 6.68231 26.8125C7.19794 25.7812 7.54169 24.5438 7.54169 22.6875V22.0688L7.02606 21.8625C3.93231 20.0063 2.38544 17.1187 2.38544 13.6125C2.38544 8.6625 8.40106 4.125 14.9323 4.125C21.2917 4.125 26.4479 8.25 26.4479 13.6125C26.4479 18.5625 21.1198 22.8938 14.7604 22.8938Z"
              fill="#AF3131"
            />
          </g>
          <defs>
            <clipPath id="clip0_6_51">
              <rect
                width="27.5"
                height="33"
                fill="white"
                transform="translate(0.666687)"
              />
            </clipPath>
          </defs>
        </svg>
        <p>{{ post.countComments }}</p>
      </div>
    </div>
  </div>
  <!-- Loader -->
  <div v-if="load == true">
    <div v-for="post in 2" :key="post" class="block post">
      <div class="header_post">
        <div class="curcle_loading"></div>
        <div>
          <div class="text_loading"></div>

          <div class="text_loading"></div>
        </div>
      </div>
      <div class="body_post active_loading"></div>
      <div class="footer_post">
        <div>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="34"
            height="40"
            viewBox="0 0 34 40"
            fill="none"
            v-if="post.active_like == true"
          >
            <ellipse cx="22.75" cy="16.5" rx="6.25" ry="8.5" fill="#AF3131" />
            <ellipse cx="22.75" cy="16.5" rx="6.25" ry="8.5" fill="#AF3131" />
            <ellipse cx="22.75" cy="16.5" rx="6.25" ry="8.5" fill="#AF3131" />
            <path
              d="M23.0625 6.25C20.8583 6.25 18.7989 7.35125 17.3333 9.2575C15.8677 7.35125 13.8083 6.25 11.6042 6.25C7.29582 6.25 3.79166 10.4163 3.79166 15.625C3.79166 26.9275 17.3333 33.75 17.3333 33.75C17.3333 33.75 30.875 26.9275 30.875 15.625C30.875 10.4163 27.3708 6.25 23.0625 6.25ZM17.3333 30.9963C14.6021 29.4013 5.87499 23.6725 5.87499 15.625C5.87499 11.8337 8.44478 8.75 11.6042 8.75C13.2187 8.75 14.7104 9.5325 15.8021 10.9525L16.5677 11.9488H18.0989L18.8646 10.9525C19.9562 9.5325 21.4479 8.75 23.0625 8.75C26.2219 8.75 28.7917 11.8337 28.7917 15.625C28.7917 23.6725 20.0646 29.4013 17.3333 30.9963Z"
              fill="#AF3131"
            />
            <ellipse
              cx="11.9166"
              cy="16.5"
              rx="7.08333"
              ry="8.5"
              fill="#AF3131"
            />
            <ellipse
              cx="17.3333"
              cy="24.5"
              rx="8.33333"
              ry="6.5"
              fill="#AF3131"
            />
          </svg>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="34"
            height="40"
            viewBox="0 0 34 40"
            fill="none"
            v-else
          >
            <path
              d="M11.6042 10V12.5C10.1687 12.5 8.99999 13.9013 8.99999 15.625H6.91666C6.91666 12.5238 9.01978 10 11.6042 10Z"
              fill="#AF3131"
            />
            <path
              d="M23.0032 6.25C20.8058 6.25 18.7528 7.33123 17.2917 9.20282C15.8305 7.33123 13.7775 6.25 11.5801 6.25C7.28504 6.25 3.79166 10.3405 3.79166 15.4545C3.79166 26.5515 17.2917 33.25 17.2917 33.25C17.2917 33.25 30.7917 26.5515 30.7917 15.4545C30.7917 10.3405 27.2983 6.25 23.0032 6.25ZM17.2917 30.5463C14.5688 28.9803 5.86858 23.3557 5.86858 15.4545C5.86858 11.7322 8.43046 8.70455 11.5801 8.70455C13.1897 8.70455 14.6768 9.47282 15.7651 10.867L16.5284 11.8451H18.0549L18.8182 10.867C19.9065 9.47282 21.3936 8.70455 23.0032 8.70455C26.1528 8.70455 28.7147 11.7322 28.7147 15.4545C28.7147 23.3557 20.0145 28.9803 17.2917 30.5463Z"
              fill="#AF3131"
            />
          </svg>
          <p></p>
        </div>
        <div>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="29"
            height="33"
            viewBox="0 0 29 33"
            fill="none"
          >
            <g clip-path="url(#clip0_6_51)">
              <path
                d="M14.9323 2.0625C7.36981 2.0625 0.666687 7.425 0.666687 13.6125C0.666687 17.7375 2.55731 21.2437 5.82294 23.3062V23.5125C5.65106 26.1937 4.27606 27.0188 4.27606 27.0188L1.18231 28.875H4.61981C8.91669 28.875 12.0104 26.6063 13.3854 24.9563C13.9011 24.9563 14.2448 24.9563 14.7604 24.9563C22.1511 24.9563 28.1667 19.8 28.1667 13.4062C28.1667 7.0125 22.3229 2.0625 14.9323 2.0625ZM14.7604 22.8938C14.2448 22.8938 13.5573 22.8938 13.2136 22.8938H12.6979L12.3542 23.3062C11.4948 24.3375 9.60419 26.1938 6.68231 26.8125C7.19794 25.7812 7.54169 24.5438 7.54169 22.6875V22.0688L7.02606 21.8625C3.93231 20.0063 2.38544 17.1187 2.38544 13.6125C2.38544 8.6625 8.40106 4.125 14.9323 4.125C21.2917 4.125 26.4479 8.25 26.4479 13.6125C26.4479 18.5625 21.1198 22.8938 14.7604 22.8938Z"
                fill="#AF3131"
              />
            </g>
            <defs>
              <clipPath id="clip0_6_51">
                <rect
                  width="27.5"
                  height="33"
                  fill="white"
                  transform="translate(0.666687)"
                />
              </clipPath>
            </defs>
          </svg>
          <p></p>
        </div>
      </div>
    </div>
  </div>
  <div v-if="modal == true" class="background">
    <div class="container block content">
      <!-- Loader -->
      <div v-if="load_comm == true" class="all_coments">
        <div v-for="comment in 5" :key="comment" class="comment">
          <a>
            <div class="header">
              <div class="curcle_loading"></div>
              <div class="inf">
                <div class="text_loading"></div>
                <div class="text_loading"></div>
              </div>
            </div>
          </a>

          <div class="content">
            <div class="text_loading"></div>
          </div>
        </div>
      </div>
      <p @click="modal = false">✖</p>
      <div class="no_comm" v-if="all_comments.length == 0">
        <p>Пока никто не оставил коментарий</p>
      </div>
      <!-- Коментарии -->
      <div v-else class="all_coments">
        <div v-for="comment in all_comments" :key="comment" class="comment">
          <router-link
            v-if="this.$store.state.user.id != comment.id_user.id"
            :to="{ path: '/user/' + comment.id_user.id }"
          >
            <div class="header">
              <img :src="comment.id_user.avatar" alt="" />
              <div class="inf">
                <p>{{ comment.id_user.name }} {{ comment.id_user.surname }}</p>
                <p>{{ getHumanDate(comment.created_at) }}</p>
              </div>
            </div>
          </router-link>

          <router-link
            v-if="this.$store.state.user.id == comment.id_user.id"
            :to="{ path: '/profile' }"
          >
            <div class="header">
              <img :src="comment.id_user.avatar" alt="" />
              <div class="inf">
                <p>{{ comment.id_user.name }} {{ comment.id_user.surname }}</p>
                <p>{{ getHumanDate(comment.created_at) }}</p>
              </div>
            </div>
          </router-link>
          <div class="content">
            <p>{{ comment.comment }}</p>
          </div>
        </div>
      </div>
      <div class="create_comment">
        <form action="">
          <input type="text" v-model="comment" placeholder="Крутое фото!!!" />
          <button @click.prevent="createComment()">Отправить</button>
        </form>
      </div>
    </div>
  </div>
  <div class="container err-msg" v-if="err_msg != ''">
    <h1>{{ err_msg }}</h1>
  </div>
</template>

<script>
import moment from "moment/min/moment-with-locales";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import CarouselFixComponentVue from "./CarouselFixComponent.vue";

moment.locale("ru");
export default {
  data() {
    return {
      active_like: [],
      all_comments: [],
      load: true,
      load_comm: true,
      modal: false,
      id_post: 0,
      index_post: 0,
      comment: "",
      posts: [],
      action: false,
      err_msg: "",
      id_user: 0,
    };
  },
  mounted() {
    this.allPosts();
    if (this.err_msg == "") {
      this.ScrollCheck();
    }
  },
  components: {
    Carousel,
    Slide,
    Pagination,
    Navigation,
    CarouselFixComponentVue,
  },
  updated() {
    if (this.modal == true) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "auto";
    }
  },
  destroyed: function () {
    window.removeEventListener("scroll", this.ScrollCheck);
  },
  methods: {
    ScrollCheck: function () {
      window.addEventListener("scroll", this.ScrollCheck);
      let height = Math.max(
        document.body.scrollHeight,
        document.documentElement.scrollHeight,
        document.body.offsetHeight,
        document.documentElement.offsetHeight,
        document.body.clientHeight,
        document.documentElement.clientHeight
      );
      let my_height = document.documentElement.scrollTop + window.innerHeight;
      if (height == my_height) {
        if (
          this.posts.pagination.current_page < this.posts.pagination.last_page
        ) {
          this.nextPosts();
          window.removeEventListener("scroll", this.ScrollCheck);
        } else {
          window.removeEventListener("scroll", this.ScrollCheck);
        }
      }
    },
    allPosts() {
      let url = window.location.pathname;
      this.id_user = url.split("/")[2];
      axios
        .get(`/api/post/user/${this.id_user}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((res) => {
          this.posts = res.data;
          if (this.posts.posts.length == 0) {
            this.err_msg = "Нет постов";
            this.load = false;
          } else {
            this.$store.state.page = this.posts.pagination.current_page;

            this.posts.posts.forEach((post) => {
              post.countLikes = post.likes.length;
              post.active_like = false;
              post.countComments = post.comments.length;
              post.action = false;
            });
            for (let index = 0; index < this.posts.posts.length; index++) {
              axios
                .post(
                  "/api/likes/check",
                  {
                    id_post: this.posts.posts[index].id,
                  },
                  {
                    headers: {
                      Authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                  }
                )
                .then((res) => {
                  this.posts.posts[index].active_like = res.data.check;
                  this.load = false;
                })
                .catch((err) => {});
            }
          }
        });
    },
    nextPosts() {
      axios
        .get(
          `/api/post/user/${this.user}?page=${
            this.posts.pagination.current_page + 1
          }`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((response) => {
          for (let index = 0; index < response.data.posts.length; index++) {
            this.posts.posts.push(response.data.posts[index]);
          }
          this.posts.pagination = response.data.pagination;
          this.posts.posts.forEach((post) => {
            post.countLikes = post.likes.length;
            post.active_like = false;
            post.countComments = post.comments.length;
            post.action = false;
          });
          for (let index = 0; index < this.posts.posts.length; index++) {
            axios
              .post(
                "/api/likes/check",
                {
                  id_post: this.posts.posts[index].id,
                },
                {
                  headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                  },
                }
              )
              .then((res) => {
                this.posts.posts[index].active_like = res.data.check;
                this.load = false;
              })
              .catch((err) => {});
          }
        });
    },
    getHumanDate: function (date) {
      return moment(date).fromNow();
    },
    addLike(idPost, index) {
      axios
        .post(
          "/api/likes/create",
          {
            id_post: idPost,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((res) => {
          this.posts.posts[index].countLikes = res.data.count;
          this.posts.posts[index].active_like = res.data.check;
        });
    },
    createComment() {
      axios
        .post(
          "/api/comment/create",
          {
            id_post: this.id_post,
            comment: this.comment,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((res) => {
          this.comment = "";
          this.posts.posts[this.index_post].countComments++;

          axios
            .post(
              "/api/comment/all",
              {
                id_post: this.id_post,
              },
              {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
              }
            )
            .then((res) => {
              let arr = res.data.data;
              this.all_comments.push(arr[arr.length - 1]);
            });
        });
    },
    allComments() {
      this.load_comm = true;
      axios
        .post(
          "/api/comment/all",
          {
            id_post: this.id_post,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((res) => {
          this.all_comments = res.data.data;
          this.load_comm = false;
        });
    },
    Actions(action, index) {
      if (action == false) {
        this.posts.posts[index].action = true;
      }
    },
    CloseActions(action, index) {
      if (action == true) {
        this.posts.posts[index].action = false;
      }
    },
    DeletePost(id_post, index) {
      axios
        .get(`/api/post/delete/${id_post}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((res) => {
          this.posts.posts.splice(index, 1);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.background {
  position: fixed;
  background: rgba(0, 0, 0, 0.6);
  top: 0;
  left: 0;
  width: 100%;
  .content {
    display: flex;
    flex-direction: column;
    .no_comm {
      display: flex;
      justify-content: center;
      padding: 5% 0;
      p {
        font-size: 25px;
        color: white;
      }
    }
    p {
      cursor: pointer;
    }
    .all_coments {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-left: 2%;
      max-height: 80vh;
      overflow-y: auto;
      .comment {
        border: 2px solid #525252;
        border-radius: 10px;
        padding: 20px;
        a {
          text-decoration: none;
          .header {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            img {
              width: 50px;
              height: 50px;
              border-radius: 50%;
            }
            .inf {
              width: 100%;
              display: flex;
              flex-direction: column;
              gap: 10px;
              p {
                position: relative;
                color: white;
                font-size: 15px;
              }
              p:nth-child(2) {
                font-size: 13px;
                color: #606060;
              }
            }
          }
        }
        .content {
          padding: 20px 30px;
          p {
            color: white;
            position: relative;
          }
        }
      }
    }
  }
  .block {
    p {
      position: absolute;
      color: #af3131;
    }
  }
  height: 100vh;
}
.create_comment {
  margin-top: 20px;
  form {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 20px;
    input {
      width: 320px;
      height: 30px;
      background: transparent;
      border: 2px solid #af3131;
      border-radius: 10px;
      padding-left: 5px;
    }
    button {
      background: transparent;
      border: 2px solid #af3131;
      border-radius: 10px;
      padding: 5px 25px;
      cursor: pointer;
    }
  }
}
.active_loading {
  background: linear-gradient(110deg, #525252, #474747 18%, #525252);
  border-radius: 5px;
  width: 100%;
  height: 50vh;
  background-size: 200% 100%;
  animation: 1s shine linear infinite;
}
.text_loading {
  background: linear-gradient(110deg, #525252, #474747 18%, #525252);
  border-radius: 5px;
  width: 150px;
  height: 20px;
  background-size: 200% 100%;
  animation: 1s shine linear infinite;
}
.text_loading:nth-child(2) {
  width: 120px;
  height: 14px;
}
.curcle_loading {
  background: linear-gradient(110deg, #525252, #474747 18%, #525252);
  border-radius: 50%;
  width: 50px;
  height: 50px;
  background-size: 200% 100%;
  animation: 1s shine linear infinite;
}
@keyframes shine {
  to {
    background-position-x: -200%;
  }
}
.post {
  .header_post {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: flex-start;
    div {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 10px;
      div {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        a {
          text-decoration: none;
          p:nth-child(1) {
            font-size: 15px;
          }
        }
        p:nth-child(2) {
          color: #606060;
          font-size: 13px;
        }
      }
    }
    img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
    }
    .actions {
      svg {
        cursor: pointer;
      }
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      .dropdown-content {
        position: absolute;
        display: flex;
        flex-direction: column;
        background: #353535;
        border-radius: 10px;
        align-items: center;
        padding: 15px 0;
        p {
          cursor: pointer;
          width: 100%;
          color: white !important;
          font-size: 15px !important ;
          border-bottom: 2px solid #606060;
          padding: 0 20px;
          padding-bottom: 10px;
        }
        p:last-child {
          border: none;
          padding-bottom: 0;
        }
        p:first-child {
          padding-top: 0;
        }
      }
    }
  }
  .body_post {
    margin-top: 20px;
    img {
      margin-top: 20px;
      max-width: 100%;
    }
  }
  .footer_post {
    margin-top: 20px;
    display: flex;
    flex-direction: row;
    gap: 20px;
    div {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 5px;
      svg {
        cursor: pointer;
      }
      p {
        color: #af3131;
      }
    }
  }
}
.err-msg {
  display: flex;
  justify-content: center;
  margin-top: 50px;
}
</style>